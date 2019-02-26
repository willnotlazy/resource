<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/27
 * Time: 11:01
 */
namespace app\index\model;
use think\Db;
use Firebase\JWT\JWT;
use think\Request;
use think\Session;

class User extends Base
{
    // 检查用户登录信息并返回用户信息
    public function LoginCheck($data)
    {
        // 用户验证
        $user = $data['username'];
        $password = base64_decode($data['password']);

        // 用户是否存在
        $result = Db::table('res_user')->where('username',$user)->find();
        
        if ($result['activation'] != 'activated')
        {
            $activation_key=bin2hex(openssl_random_pseudo_bytes(32));
            Db::name('user')->update(['id'=>$result['id'],'activation'=>$activation_key]);
            $content = "<a href="."http://dev-resource.com/active/{$result['email']}/{$activation_key}".">http://dev-resource.com/active/{$result['email']}/{$activation_key}</a>";
            send_activation_email($result['email'], '账号激活', $content);
            return array('code'=>20666,'msg'=>'您的账号暂未激活,本站已发送激活邮件到您的邮箱,请注意.');
        }
        if (empty($result)) return ['code' => USER_NOT_FOUND,'msg' => map[USER_NOT_FOUND]];

        // 用户是否可登录

        $flag = $this->cloudUserLogin($user);
        if ( $flag === 'deny') return array('code'=>44666,'msg'=>'您已被管理员关入小黑屋');
        if ($flag === 'no' && Base::getModelInstance('Action')->getLoginFailTimesByUser($result['id']))
        {
            $data = [
                'code' => LIMIT_LOGIN_FAIL_TIMES,
                'msg'  => map[LIMIT_LOGIN_FAIL_TIMES]
            ];
            return $data;
        }
        // 密码验证
        $password .= $result['salt'];
        if (hash('md5',$password) !== $result['password'])
        {
            $surplus = Base::getModelInstance('Action')->logLoginFailAction($result['id']);
            // 不可登录
            if ($surplus['surplus'] == 0)
            {
                Db::name('user')->where('username',$user)->update(['couldLogin'=>0]);
                return [
                    'code'  => LIMIT_LOGIN_FAIL_TIMES,
                    'msg'   => map[LIMIT_LOGIN_FAIL_TIMES]
                ];
            }
            return [
                'code'  => PASSWORD_ERROR,
                'msg'   => map[PASSWORD_ERROR],
                'data'  => $surplus
            ];
        }

        $this->redis->del('user_'.$result['id']);
        $this->redis->save();
        // 登录经验增加判断
        Base::getModelInstance('Experience')->addExperienceBylogin($result);

        // 返回token
        $userInfo = $this->getUserInfo($result['id']);
        unset($userInfo['password']);

        $_SESSION['id'] = $result['id'];
        $_SESSION['name'] = $result['username'];
        Session::set('id',$result['id']);
        Session::set('name',$result['username']);
        return ['code' => LOGIN_SUCCESS, 'msg' => map[LOGIN_SUCCESS]];
    }

    // 用户注册
    public function registerUser($data)
    {
        $salt = getSalt();
        $user = $data['username'];
        $password = $data['password'];
        $now = date('Y-m-d',time());
        $email = $data['email'];

        $data = array();
        $data = ['id'=>null,'username'=>$user,'password'=>hash('md5',$password . $salt),'email'=>$email,'salt'=>$salt,'join'=>$now,'level'=>1,'experience'=>null,'accumulatedLoginDays'=>0,'consecutiveLoginDays'=>0];
        User::name('user')->insert($data);

        Session::set('id',Db::name('user')->getLastInsID());
        Session::set('name',$user);
        User::registerLogin(Db::name('user')->getLastInsID());
        return array(
          'code'    =>   REGISTER_SUCCESS,
          'msg'     =>   map[REGISTER_SUCCESS]
        );
    }

    // 注册后登录
    private static function registerLogin($id)
    {
        $result = Db::table('res_user')->where('id',$id)->select();

        // 获得首次登录经验
        Base::getModelInstance('Experience')->addExperienceBylogin($result);
        return true;
    }

    // 获取用户信息
    public function getUserInfo($id)
    {
        return Db::table('res_user')->where('id',$id)->select();
    }

    // 根据用户名获取用户信息
    public function getFromUsername($username)
    {
        $user = Db::table('res_user')->where('username',$username)->find();
        return empty($user);
    }

    // 根据邮箱获取用户信息
    public function getFromUserEmail($email)
    {
        $user = Db::table('res_user')->where('email',$email)->find();
        return empty($user);
    }

    // 判断用户是否可以登录
    public function cloudUserLogin($user)
    {
        $status = Db::name('user')->where('username',$user)->find();
        if ((int)$status['couldLogin'] === 0) return 'no';
        if ((int) $status['couldLogin'] === -1) return 'deny';
        return 'yes';
    }

    // 获取但前用户的所有投稿
    public function getSelfPost($id, $size = 6)
    {
        $result = Db::name('user_post')
            ->field('p.*,u.username')
            ->alias('p')
            ->join('res_user u','p.authorID=u.id')
            ->where('p.authorID',$id)
            ->where('couldPost',1)
            ->order('p.postTime','desc')
            ->paginate($size)
            ->each(function ($item,$key){
                $mainClassify = $item['classify'];
                $assistantClassify = $item['second_classify'];
                $ClassifyName = Db::name('user_resource_classify')->field('ClassifyID,name')->where('classifyID','in',[$mainClassify,$assistantClassify])->column('name','classifyID');
                $item['mainClassify'] = $ClassifyName[$mainClassify];
                $item['assistantClassify'] = $ClassifyName[$assistantClassify];
                return $item;
            });

        $postid = '';
        foreach ($result as $value)
        {
            $postid .= $value['postID'] . ',';
        }
        $view = self::getModelInstance('Action')->getAllViewTimes($postid);
        return array('result'=>$result,'postId'=>$postid,'views'=>$view);
    }
    
    // 获取用户等级排行
    public function getLevelRank()
    {
        $users = Db::name('user')->field('username,level,experience,accumulatedLoginDays,consecutiveLoginDays')->order('level','desc')->order('experience','desc')->select();
        return $users;
    }

    // 邮件验证
    public function mailCheck($email, $activation_key)
    {
        $user = Db::table('res_user')->where('email',$email)->find();
        if ($user['activation'] != $activation_key) return false;
        $user['activation'] = 'activated';
        Db::name('user')->update($user);
        Session::set('id',$user['id']);
        Session::set('name',$user['username']);
        return true;
    }

    // 根据 Id 获取非密码外的基础信息
    public function getBasicInfo($id)
    {
        return Db::name('user')->field('username,thumb,level')->where('id',$id)->find();
    }

    // 获取用户个性化设置
    public function getUserSpaceSet($id)
    {
        return Db::name('user_space_set')->where('uid',$id)->find();
    }

    // 获取被关小黑屋的人
    public function getPrisoner()
    {
        $result = Db::name('user')
                        ->field('username,prisoner')
                        ->where('couldLogin',-1)
                        ->paginate(10);
        return $result;
    }
}
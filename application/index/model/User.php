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
        if (empty($result)) return ['code' => USER_NOT_FOUND,'msg' => map[USER_NOT_FOUND]];

        // 用户是否可登录
        if (!$this->cloudUserLogin($user) && Base::getModelInstance('Action')->getLoginFailTimesByUser($result['id']))
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
        if ((int)$status['couldLogin'] === 0) return false;
        return true;
    }

    // 获取但前用户的所有投稿
    public function getSelfPost($id)
    {
        $result = Db::name('user_post')
            ->field('p.*,u.username')
            ->alias('p')
            ->join('res_user u','p.authorID=u.id')
            ->where('p.authorID',$id)
            ->order('p.postTime','desc')
            ->paginate(6);

        $postid = '';
        foreach ($result as $value)
        {
            $postid .= $value['postID'] . ',';
        }
        $view = self::getModelInstance('Action')->getAllViewTimes($postid);
        return array('result'=>$result,'postId'=>$postid,'views'=>$view);
    }
}
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

class User extends Base
{
    // 检查用户登录信息并返回用户信息
    public function LoginCheck($data)
    {
        // 用户验证
        $user = $data['username'];
        $password = $data['password'];

        // 用户是否存在
        $result = Db::table('res_user')->where('username',$user)->find();
        if (empty($result)) return ['code' => USER_NOT_FOUND,'msg' => map[USER_NOT_FOUND]];

        // 用户是否可登录
        if (!$this->cloudUserLogin($user) && Base::getModelInstance('Action')->getLoginFailTimesByUser($user))
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

        if ($this->isAlreadyLogin($user)) return ['code'=>ALREADY_LOGIN,'msg'=>map[ALREADY_LOGIN]];
        // 更改用户登录状态
        Db::name('user')->where('id',$result['id'])->update(['isLogin'=>1]);

        // 登录经验增加判断
        Base::getModelInstance('Experience')->addExperienceBylogin($result);

        // 返回token
        $userInfo = $this->getUserInfo($result['id']);
        unset($userInfo['password']);
        $request = Request::instance();
        $token = createToken($result['id'],array(
            'iss' => $request->domain(),
            'aud' => $request->baseUrl(true)
        ));
        unset($userInfo);

        $tokenInfo = [
            'userID'   => $result['id'],
            'token'    => $token,
            'limit'    => time() + 1800,
            'clientIp' => getIp()
        ];
        Db::name('user_token')->insert($tokenInfo);

        return ['code' => LOGIN_SUCCESS, 'msg' => map[LOGIN_SUCCESS], 'data' => $token];
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
        return User::registerLogin(Db::name('user')->getLastInsID());
    }

    // 注册后登录
    private static function registerLogin($id)
    {
        $result = Db::table('res_user')->where('id',$id)->select();

        // 获得首次登录经验
        Base::getModelInstance('Experience')->addExperienceBylogin($result);

        // 返回token
        $userInfo = (new self)->getUserInfo($result[0]['id']);
        unset($userInfo[0]['password']);
        $request = Request::instance();
        $token = createToken($result[0]['id'],array(
            'iss' => $request->domain(),
            'aud' => $request->baseUrl(true)
        ));
        unset($userInfo);
        return $token;
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

    // 判断本次登录之前用户是否已登录
    private function isAlreadyLogin($user)
    {
        $isLogin = Db::name('user')->where('username',$user)->find()['isLogin'];
        return (int)$isLogin === 0 ? false : true;
    }


}
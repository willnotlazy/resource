<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/27
 * Time: 11:01
 */
namespace app\index\model\user;
use think\Db;
use think\Model;
use Firebase\JWT\JWT;
use think\Request;
use app\index\model\experience\Experience;

class User extends Model
{
    private static $_user = null;
    public static function getInstance()
    {
        if (is_null(self::$_user))
        {
            self::$_user = new User();
        }
        return self::$_user;
    }
    // 检查用户登录信息并返回用户信息
    public function LoginCheck($data)
    {
        // 用户验证
        $user = $data['username'];
        $password = $data['password'];
        $result = Db::table('res_user')->where('username',$user)->select();
        if (empty($result)) return $result;

        // 密码验证
        $password .= $result[0]['salt'];
        if (hash('md5',$password) !== $result[0]['password']) return null;

        // 登录经验增加判断
        Experience::getInstance()->addExperienceBylogin($result);

        // 返回token
        $userInfo = $this->getUserInfo($result[0]['id']);
        unset($userInfo[0]['password']);
        $request = Request::instance();
        $token = createToken($result[0]['id'],array(
            'iss' => $request->domain(),
            'aud' => $request->baseUrl(true)
        ));
        unset($userInfo);
        return $token;
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
        Experience::getInstance()->addExperienceBylogin($result);

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
}
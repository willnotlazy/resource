<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/27
 * Time: 11:01
 */
namespace app\index\model\user;
use think\Model;
use Firebase\JWT\JWT;
use think\Request;
class User extends Model
{
    public static function checkUser($data)
    {
        $user = $data['username'];
        $password = md5($data['password']);
        $result = User::where('username',$user)->where('password',$password)->column('username','id');
        if (empty($result)) return $result;
        $request = Request::instance();
        return createToken($result,array(
            'iss' => $request->domain(),
            'aud' => $request->baseUrl(true),
            'iat' => time(),
            'nbf' => time() + 3,
            'exp' => time() +7200
        ));
    }
    public static function registerUser($data)
    {
        $user = $data['username'];
        $password = md5($data['password']);
        $data = array();
        $data = ['id'=>null,'username'=>$user,'password'=>$password,'test'=>'test','safetest'=>0];
        User::name('user')->insert($data);
        return User::name('user')->getLastInsID();
    }
    public static function loginIn($data)
    {
        $data = decrypt($data);
        $token = $data['token'];
        if (checkToken($token) == false)
        {
            return false;
        }
        $user = $data['username'];
        $password = $data['password'];
        return User::where('username',$user)->where('password',$password)->column('username,test,safetest','id');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/27
 * Time: 11:01
 */
namespace app\index\model\user;
use think\Model;
class User extends Model
{
    public static function checkUser($data)
    {
        $user = $data['username'];
        $password = md5($data['password']);
        return User::where('username',$user)->where('password',$password)->find();
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
}
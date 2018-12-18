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
class User extends Model
{
    public function LoginCheck($data)
    {
        $user = $data['username'];
        $password = md5(PASSWORD_PREFIX . $data['password']);
        $result = Db::table('res_user')->where('username',$user)->where('password',$password)->select();
        if (empty($result)) return $result;
        $this->logAndExprience($result);
        return $result;
    }
    public function registerUser($data)
    {
        $user = $data['username'];
        $password = md5(PASSWORD_PREFIX . $data['password']);
        $data = array();
        $data = ['id'=>null,'username'=>$user,'password'=>$password,'test'=>'test','safetest'=>0];
        User::name('user')->insert($data);
        return User::name('user')->getLastInsID();
    }

    private function logAndExprience($result)
    {

        $lastLoginDate = Db::table('res_user_login_log')->where("uid=".$result[0]['id'])->order('id desc')->limit(1)->select();
        if (!$lastLoginDate || date('Y-m-d',strtotime($lastLoginDate[0]['signIn'] . " +1 days")) === date('Y-m-d',time())) {
            $userData = [
                'id'                   => $result[0]['id'],
                'accumulatedLoginDays' => $result[0]['accumulatedLoginDays'] + 1,
                'consecutiveLoginDays' => $result[0]['consecutiveLoginDays'] + 1,
                'experience'           => $result[0]['experience'] + 10 + $result[0]['consecutiveLoginDays']
            ];
            Db::table('res_user')->update($userData);
        }else if(date('Y-m-d',strtotime($lastLoginDate[0]['signIn']) === date('Y-m-d',time()))){

        }else {
            $userData = [
                'id'                   => $result[0]['id'],
                'accumulatedLoginDays' => $result[0]['accumulatedLoginDays'] + 1,
                'consecutiveLoginDays' => 1,
                'experience'           => $result[0]['experience'] + 10
            ];
            Db::table('res_user')->update($userData);
        }
        $data = [
            'id'    =>  null,
            'uid'   =>  $result[0]['id'],
            'signIn'=>  date('Y-m-d H:i:s',time())
        ];
        Db::table('res_user_login_log')->insert($data);
    }
}
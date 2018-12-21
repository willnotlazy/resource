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
        $this->logAndExprience($result);

        // 返回token
        $userInfo = $this->getUserInfo($result[0]['id']);
        unset($userInfo[0]['password']);
        $request = Request::instance();
        $token = createToken($result['0']['id'],array(
            'iss' => $request->domain(),
            'aud' => $request->baseUrl(true)
        ));
        unset($userInfo);
        return $token;
    }

    // 用户注册
    public function registerUser($data)
    {
        $user = $data['username'];
        $password = md5(PASSWORD_PREFIX . $data['password']);
        $data = array();
        $data = ['id'=>null,'username'=>$user,'password'=>$password,'test'=>'test','safetest'=>0];
        User::name('user')->insert($data);
        return User::name('user')->getLastInsID();
    }

    // 经验增加
    private function logAndExprience($result)
    {

        $lastLoginDate = Db::table('res_user_login_log')->where("uid=".$result[0]['id'])->order('id desc')->limit(1)->select();

        // 1.首次登录且连续登录 2.非首次登录 3.连续登录中断
        if (!$lastLoginDate || date('Y-m-d',strtotime($lastLoginDate[0]['signIn'] . " +1 days")) === date('Y-m-d',time())) {
            $userData = [
                'id'                   => $result[0]['id'],
                'accumulatedLoginDays' => $result[0]['accumulatedLoginDays'] + 1,
                'consecutiveLoginDays' => $result[0]['consecutiveLoginDays'] + 1,
                'experience'           => $result[0]['experience'] + 10 + $result[0]['consecutiveLoginDays']
            ];
            Db::table('res_user')->update($userData);
            $this->islevelUp($result[0]['id'],$result[0]['experience'] + 10 + $result[0]['consecutiveLoginDays']);
        }else if(date('Y-m-d',strtotime($lastLoginDate[0]['signIn'])) === date('Y-m-d',time())){

        }else {
            $userData = [
                'id'                   => $result[0]['id'],
                'accumulatedLoginDays' => $result[0]['accumulatedLoginDays'] + 1,
                'consecutiveLoginDays' => 1,
                'experience'           => $result[0]['experience'] + 10
            ];
            Db::table('res_user')->update($userData);
            $this->islevelUp($result[0]['id'],$result[0]['experience'] + 10);
        }
        $data = [
            'id'    =>  null,
            'uid'   =>  $result[0]['id'],
            'signIn'=>  date('Y-m-d H:i:s',time())
        ];
        Db::table('res_user_login_log')->insert($data);
        return $result;
    }

    // 判断等级提升
    public function islevelUp($uid,$experience)
    {
        $result = $this->table('res_user')
                        ->alias('u')
                        ->join('res_user_level l','u.level = l.level')
                        ->field('u.level,l.experience')
                        ->where('u.id',$uid)
                        ->select();
        if ($experience >= $result[0]['experience'])
        {
            $data = [
                'id'         => $uid,
                'level'      => $result[0]['level'] + 1,
                'experience' => $experience - $result[0]['experience']
            ];
            $this->table('res_user')->update($data);
        }
    }

    // 获取用户信息
    public function getUserInfo($id)
    {
        return Db::table('res_user')->where('id',$id)->select();
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/24
 * Time: 15:43
 */
namespace app\index\model\experience;

use app\index\model\user\User;
use think\Model;
use think\Db;
use app\index\model\user\User as UserModel;

class Experience extends Model
{
    private static $_experience = null;
    public static function getInstance()
    {
        if (is_null(self::$_experience))
        {
            self::$_experience = new Experience();
        }
        return self::$_experience;
    }

    // 每日登录经验增加
    public function addExperienceBylogin($result)
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

    // 回复消息经验增加
    public function addExperienceByReply($result)
    {

    }

    // 发帖增加经验
    public function addExperienceByPost($id)
    {
        $user = UserModel::getInstance()->get($id);
        $user->experience += 6;
        $user->isUpdate()->save();
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
}
?>
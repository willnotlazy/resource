<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/24
 * Time: 15:43
 */
namespace app\index\model;

use think\Db;

class Experience extends Base
{

    // 每日登录经验增加
    public function addExperienceBylogin($result)
    {
        $lastLoginDate = Db::table('res_user_login_log')->where("uid=".$result['id'])->order('id desc')->limit(1)->select();
        if (!$lastLoginDate || date('Y-m-d',strtotime($lastLoginDate[0]['signIn'] . " +1 days")) === date('Y-m-d',time())) {
            $userData = [
                'id'                   => $result['id'],
                'accumulatedLoginDays' => $result['accumulatedLoginDays'] + 1,
                'consecutiveLoginDays' => $result['consecutiveLoginDays'] + 1,
                'experience'           => $result['experience'] + 10 + $result['consecutiveLoginDays'],
                'couldLogin'           => 1
            ];
            Db::table('res_user')->update($userData);
            $this->islevelUp($result['id'],$result['experience'] + 10 + $result['consecutiveLoginDays']);
        }else if(date('Y-m-d',strtotime($lastLoginDate[0]['signIn'])) === date('Y-m-d',time())){
            $userData = [
                'id'                   => $result['id'],
                'couldLogin'           => 1
            ];
            Db::table('res_user')->update($userData);
        }else {
            $userData = [
                'id'                   => $result['id'],
                'accumulatedLoginDays' => $result['accumulatedLoginDays'] + 1,
                'consecutiveLoginDays' => 1,
                'experience'           => $result['experience'] + 10,
                'couldLogin'           => 1
            ];
            Db::table('res_user')->update($userData);
            $this->islevelUp($result['id'],$result['experience'] + 10);
        }
        $data = [
            'id'    =>  null,
            'uid'   =>  $result['id'],
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
        $user = $this->getModelInstance('User')->get($id);
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
            ->find();
        if ($experience >= $result['experience'])
        {
            $data = [
                'id'         => $uid,
                'level'      => $result['level'] + 1,
                'experience' => $experience - $result['experience']
            ];
            $this->table('res_user')->update($data);
        }
    }
}
?>
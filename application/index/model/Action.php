<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/24
 * Time: 17:17
 */
namespace app\index\model;

use think\Db;
use think\Request;

class Action extends Base
{
    // 返回 Action 单例
    private static $_action = null;
    public static function getInstance()
    {
        if (is_null(self::$_action))
        {
            self::$_action = new Action();
        }
        return self::$_action;
    }

    // 发帖
    public function addPost($param,$id)
    {
        $param['authorID'] = $id;
        $param['postID'] = null;
        $param['postTime'] = time();
        $this->table('res_user_post')->insert($param);
        Base::getModelInstance('Experience')->addExperienceByPost($id);
        return $this->getInsertPostID($id);
    }

    // 获得该用户上次发帖的id
    public function getInsertPostID($id)
    {
        return Db::table('res_user_post')->where('authorID',$id)->order('postID','desc')->find()['postID'];
    }

    // 记录登录失败的操作
    public function logLoginFailAction($id)
    {
        $data = [
            'actionID'    =>      null,
            'id'          =>      $id,
            'actionTime'  =>      time(),
            'actionType'  =>      PWDERROR
        ];
        Db::name('user_action')->insert($data);
        return $this->limitLoginAction($id);
    }

    // 获取1小时内该操作的次数和上限
    public function limitLoginAction($id)
    {
        $actions = Db::name('user_action')->where('actionType',PWDERROR)->where('id',$id)->where('actionTime','between',[time() - 3600 - 2,time() + 2])->limit(5)->order('actionID','asc')->select();
        $nums = count($actions);
        $result = null;
        if ($nums != 5) return ['errorType'=>PWDERROR,'errorTimes'=>$nums,'surplus'=>5-$nums];
        return ['errorType'=>PWDERROR,'errorTimes'=>$nums,'surplus'=>0];
    }

    // 根据用户名获取他已经登录失败的次数
    public function getLoginFailTimesByUser($user)
    {
        $nums = count(Db::table('res_user_action')
                    ->alias('a')
                    ->join('user u','a.id=u.id','LEFT')
                    ->where("u.username",$user)
                    ->where('actionTime','between',[time() - 3600 - 2,time() + 2])
                    ->limit(5)
                    ->select());
        return $nums == 5 ? true : false;
    }
}
?>
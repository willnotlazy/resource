<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/24
 * Time: 17:17
 */
namespace app\index\model;

use think\Db;
use think\Exception;
use think\Request;
use think\Session;

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
        $param['authorID']          = $id;
        $param['postID']            = null;
        $param['isEffective']       = 0;
        $param['checked']           = null;
        $param['checkStatus']       = null;
        $param['couldPost']         = 0;
        $param['postTime'] = time();
        try{
            $this->table('res_user_post')->insert($param);
        } catch (Exception $e){
            return ['code'=>UNLAWFUL_ACTION,'msg'=>map[UNLAWFUL_ACTION]];
        }

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

    // 记录浏览次数
    public function logViewTimes($postId)
    {
        $ip          = getIp();
        $id          = empty(Session::get('id')) ? 0 : Session::get('id');
        $touristView = Db::name('view_history')->where('clientIp',$ip)->where('uid',0)->where('postid',$postId)->find();
        if ($id != 0) $userView    = Db::name('view_history')->where('uid',$id)->where('postid',$postId)->find();
        $flag = (($id != 0 && empty($userView)) || ($id == 0 && empty($touristView))) ? true : false;
        if ($flag === true)
        {
            $data = [
                'uid'         => $id,
                'clientIP'    => $ip,
                'postid'      => $postId,
                'viewtime'    => time()
            ];
            Db::name('view_history')->insert($data);
        }

        return self::getModelInstance('Action');
    }

    public function getViewTimes($postId)
    {
        $touristViews = Db::name('view_history')
                            ->where('clientIP',getIp())
                            ->where('postid',$postId)
                            ->where('uid',0)
                            ->count();
        $userViews    = Db::name('view_history')
                            ->where('uid','<>',0)
                            ->where('postid',$postId)
                            ->count();
        return $touristViews + $userViews;
    }

    public function getAllViewTimes($postId)
    {
        $postId = substr($postId,0,strlen($postId)-1);
        $postArray = explode(',',$postId);
        $viewArray = array();
        foreach ($postArray as $value)
        {
            $viewArray[$value] = $this->getViewTimes($value);
        }
        return $viewArray;
    }
}
?>
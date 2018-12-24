<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/24
 * Time: 17:17
 */
namespace app\index\model\action;

use think\Model;
use think\Db;
use think\Request;
use app\index\model\experience\Experience;

class Action extends Model
{
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
        Experience::getInstance()->addExperienceByPost($id);
        return $this->getInsertPostID($id);
    }

    // 获得该用户上次发帖的id
    public function getInsertPostID($id)
    {
        return Db::table('res_user_post')->where('authorID',$id)->order('postID','desc')->find()['postID'];
    }
}
?>
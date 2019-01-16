<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2019/1/15
 * Time: 10:10
 */
namespace app\index\model;

use think\Db;
use think\Paginator;
class Index extends Base
{
    public function getNewestPost()
    {
        $result = Db::name('user_post')
                    ->field('p.postID,p.authorID,p.title,p.postTime,p.cover,u.username')
                    ->alias('p')
                    ->join('res_user u','p.authorID=u.id')
                    ->order('p.postTime','desc')
                    ->limit(0,5)
                    ->select();
        return $result;
    }

    public function getClassify()
    {
        $result = Db::name('user_resource_classify')->select();
        return classify($result,0, 0);
    }


    public function getClassifyByPidGroup()
    {
        $result = Db::name('user_resource_classify')->select();
        $group  = array();
        foreach ($result as $key =>$value)
        {
            $group[$value['pid']][$value['classifyID']] = $value;
        }
        return $group;
    }
}
?>
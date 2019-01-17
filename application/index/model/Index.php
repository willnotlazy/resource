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
                    ->field('p.*,u.username')
                    ->alias('p')
                    ->join('res_user u','p.authorID=u.id')
                    ->order('p.postTime','desc')
                    ->paginate(6);
        return $result;
    }

    public function getClassify()
    {
        $result = Db::name('user_resource_classify')->select();
        return classify($result);
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

    public function getPostContent($postid)
    {
        $result = Db::name('user_post')
            ->field('p.*,u.username')
            ->alias('p')
            ->join('res_user u','p.authorID=u.id')
            ->where('p.postID', (int) $postid)
            ->find();
        return $result;
    }


    public function getAllClassify()
    {
        $result =  Db::name('user_resource_classify')->select();
        $classify = array();
        foreach ($result as $key =>$value)
        {
            $classify[$value['classifyID']] = $value;
        }
        return $classify;
    }
}
?>
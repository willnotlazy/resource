<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2019/2/21
 * Time: 17:14
 */
namespace app\index\Model;

use think\Db;

class Range extends Base
{
    // 帖子浏览排行榜--总榜记录
    public function allPostViewRange($postID)
    {
        if(!$this->redis->exists('all_post_range')) $this->redis->zadd('all_post_range',1,$postID);
        else $this->redis->zincrby('all_post_range',1,$postID);
        $this->redis->save();
        return true;
    }

    // 帖子浏览排行榜--日版记录
    public function todayPostViewRange($postID)
    {
        if(!$this->redis->exists('day_post_range'))
        {
            $this->redis->zadd('day_post_range',1,$postID);
            $this->redis->expire('day_post_range',strtotime(date('Y-m-d',strtotime('+1 day'))) - time());
        } else {
            $this->redis->zincrby('day_post_range',1,$postID);
        }
        $this->redis->save();
        return true;
    }


    // 获取全站、日、周浏览排行
    public function getAllPostRange($type) : array
    {
        $rangeList = array();
        $i = 0;
        if ($this->redis->exists($type))
        {
            $range = $this->redis->zrange($type,0,9,array('withscores'=>true));
            arsort($range);
            foreach ($range as $key => $value)
            {
                $rangeList[$i] = Db::name('user_post')->field('postID,title')->where('postID',$key)->find();
                $rangeList[$i]['views'] = $value;
                $i++;
            }
        }
        return $rangeList;
    }
}
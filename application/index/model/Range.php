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
    // 帖子浏览排行榜--总榜
    public function allPostViewRange($postID)
    {
        if(!$this->redis->exists('all_post_range')) $this->redis->zadd('all_post_range',1,$postID);
        else $this->redis->zincrby('all_post_range',1,$postID);
        $this->redis->save();
        return true;
    }

    // 帖子浏览排行榜--日版
    public function todayPostViewRange($postID)
    {
        if(!$this->redis->exists('day_post_range'))
        {
            $this->redis->zadd('day_post_range',1,$postID);
            $this->redis->expire('day_post_range',strtotime('+1 day') - time());
        } else {
            $this->redis->zincrby('day_post_range',1,$postID);
        }
        $this->redis->save();
        return true;
    }


    // 获取全站排行
    public function getAllPostRange()
    {
        if ($this->redis->exists('all_post_range'))
        {
            $range = $this->redis->zrange('all_post_range',0,10,array('withscores'=>true));
        }
    }
}
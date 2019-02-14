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
    // 发帖
    public function addPost($param,$id)
    {
        $param['authorID']          = $id;
        $param['postID']            = null;
        $param['isEffective']       = 0;
        $param['checked']           = null;
        $param['checkStatus']       = null;
        $param['couldPost']         = 0;
        $param['postTime']          = time();
        try{
            $this->table('res_user_post')->insert($param);
        } catch (Exception $e){
            return ['code'=>UNLAWFUL_ACTION,'msg'=>map[UNLAWFUL_ACTION]];
        }
        $this->logAddPostBehavior($id);
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
        $this->redis->incr('user_'.$id);
        $this->redis->expire('user_'.$id,3600);
        $this->redis->save();
        return $this->limitLoginAction($id);
    }

    // 获取1小时内该操作的次数和上限
    public function limitLoginAction($id)
    {
        $result = null;
        if (!$this->redis->exists('user_'.$id)) return false;
        $nums = $this->redis->get('user_'.$id);
        if ($nums != 5) return ['errorType'=>PWDERROR,'errorTimes'=>$nums,'surplus'=>5-$nums];

        return ['errorType'=>PWDERROR,'errorTimes'=>$nums,'surplus'=>0];
    }

    // 根据用户名获取他已经登录失败的次数
    public function getLoginFailTimesByUser($id)
    {
        if (!$this->redis->exists('user_'.$id)) return true;
        $nums = $this->redis->get('user_'.$id);
        return $nums == 5 ? true : false;
    }

    // 记录浏览次数
    public function logViewTimes($postId)
    {
        $ip          = getIp();
        $id          = empty(Session::get('id')) ? 0 : Session::get('id');
        $redis_flag = true;
        $mysql_flag = true;
        // 判断在redis中是否存在  true === 不存在
        if ($this->redis->exists('view_history'))
        {
            $this->redisToMySQL();
            $redis_flag = $this->isExistInRedis($postId, $id, $ip);
        }

        // 判断在数据库中是否存在 true === 不存在
        if ($redis_flag === true) $mysql_flag = $this->isExistInMySQL($postId, $id, $ip);
        if ($redis_flag && $mysql_flag)
        {
            $data = [
                'uid'         => $id,
                'clientIP'    => $ip,
                'postid'      => $postId,
                'viewtime'    => time()
            ];
            $this->redis->lpush('view_history',serialize($data));
            $this->redis->save();
        }
        return self::getModelInstance('Action');
    }

    public function getViewTimes($postId)
    {
        $count = 0;
        $touristViews = Db::name('view_history')
                            ->where('clientIP',getIp())
                            ->where('postid',$postId)
                            ->where('uid',0)
                            ->count();
        $userViews    = Db::name('view_history')
                            ->where('uid','<>',0)
                            ->where('postid',$postId)
                            ->count();

        // 统计 redis 里面的浏览历史
        if ($this->redis->exists('view_history'))
        {
            $result = $this->redis->lrange('view_history', 0, 10000);
            foreach ($result as $value)
            {
                $view = unserialize($value);
                if ($view['postid'] == $postId) $count++;
            }
        }
        return $touristViews + $userViews + $count;
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

    // 判断浏览历史是否在数据库中存在
    public function isExistInMySQL($postId, $id, $ip)
    {
        $touristView = Db::name('view_history')
                        ->where('clientIp',$ip)
                        ->where('uid',0)
                        ->where('postid',$postId)
                        ->find();
        if ($id != 0)
            $userView    = Db::name('view_history')
                            ->where('uid',$id)
                            ->where('postid',$postId)
                            ->find();
        $flag = (($id != 0 && empty($userView)) || ($id == 0 && empty($touristView))) ? true : false;
        return $flag;
    }

    // 判断浏览历史是否在redis中存在
    public function isExistInRedis($postId, $id, $ip)
    {
        $result = $this->redis->lrange('view_history', 0, 10000);
        foreach ($result as $key => $value)
        {
            $history = unserialize($value);
            if ((in_array($id,$history)|| in_array($ip,$history)) && in_array($postId, $history)) return false;
            return true;
        }
    }


    // 当redis里面数据数量超过500条时,数据入库
    public function redisToMySQL()
    {
        $result = $this->redis->lrange('view_history', 0, 499);
        if (count($result) < 500) return;
        $list = array();
        foreach ($result as $value) {
            $list[] = unserialize($value);
        }
        Db::name('view_history')->insertAll($list);
        $this->redis->ltrim('view_history', 500, 10000);
        $this->redis->save();
    }


    // 检查是否有回复
    public function isReply($postId, $id)
    {
        $reply = Db::name('user_reply')->where(['postID'=>$postId,'uid'=>$id])->find();
        return empty($reply) ? false : true;
    }


    // 记录当前发帖行为,在redis设置发帖单位时间发帖限时
    public function logAddPostBehavior($id)
    {
        $this->redis->incr('user_addpost_'.$id);
        $this->redis->expire('user_addpost_'.$id,3600);
        $this->redis->save();
    }

    // 获取当前单位时间内发帖数
    public function getPostLimits($id)
    {
        $result = null;
        $limit = Db::name('user')
                    ->field('l.postNums')
                    ->alias('u')
                    ->join('res_user_level l','l.level=u.level')
                    ->where('u.id',$id)
                    ->find();

        if (!$this->redis->exists('user_addpost_'.$id)) return false;
        $nums = $this->redis->get('user_addpost_'.$id);
        if ($nums != $limit['postNums']) return false;

        return true;
    }

    // 保存用户空间修改数据
    public function saveEditData($params, $fileData, $musicName)
    {
        $data = array();
        $data['uid'] = Session::get('id');
        $data['thumbs'] = empty($fileData['thumbs']) ? null : $fileData['thumbs'];
        $data['bgMusics'] = empty($fileData['bgMusics']) ? null : $fileData['bgMusics'];
        $data['bgImages'] = empty($fileData['bgImages']) ? null : $fileData['bgImages'];
        $data['word'] = $params['word'];
        $data['bg_music_name'] = $musicName;

        if ($data['thumbs'] == null) unset($data['thumbs']);
        $oldData = Db::name('user_space_set')->find();
        if (empty($oldData)) return Db::name('user_space_set')->insertGetId($data);

        // 未上传文件且不保留上次上次文件
        if ($params['autosave'] == 'no'){
            if (file_exists(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['bgMusics'])))
                unlink(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['bgMusics']));

            if (file_exists(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['bgImages'])))
                unlink(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['bgImages']));

            if (!isset($data['thumbs'])){
                if ($oldData['thumbs'] != 'http://dev-resource.com/static/common/images/1547625613113565.jpg' && file_exists(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['thumbs']))){
                    unlink(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['thumbs']));
                }
                $data['thumbs'] = 'http://dev-resource.com/static/common/images/1547625613113565.jpg';
            }
            Db::name('user_space_set')->update($data);
        }

        // 未上传文件且保留上次上传文件
        if ($params['autosave'] == 'yes')
        {
            if (isset($data['thumbs']) && $oldData['thumbs'] != 'http://dev-resource.com/static/common/images/1547625613113565.jpg' && file_exists(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['thumbs'])))
                unlink(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['thumbs']));
            if (isset($data['bgImages']) && file_exists(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['bgImages'])))
                unlink(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['bgImages']));
            if (isset($data['bgMusics']) && file_exists(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['bgMusics'])))
                unlink(str_replace('http://dev-resource.com','E:/wamp64/www/resource/public',$oldData['bgMusics']));
            $data = array_filter($data);
            Db::name('user_space_set')->update($data);
        }
        return true;
    }


}
?>
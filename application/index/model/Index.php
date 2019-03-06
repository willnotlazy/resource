<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2019/1/15
 * Time: 10:10
 */
namespace app\index\model;

use think\Db;
use think\Exception;
use think\Paginator;
class Index extends Base
{
    public function getNewestPost()
    {
        $result = Db::name('user_post')
                    ->where('couldPost',1)
                    ->order('postTime','desc')
                    ->paginate(5)
                    ->each(function ($item, $key){
                        if ($item['authorID'] == 0)
                        {
                            $item['username'] = 'admin';
                        }
                        else
                        {
                            $authorID = $item['authorID'];
                            $author = Db::name('user')->where('id',$authorID)->find()['username'];
                            $item['username'] = $author;
                        }
                        return $item;
                    });
        $postid = '';
        foreach ($result as $value)
        {
            $postid .= $value['postID'] . ',';
        }
        $views = self::getModelInstance('Action')->getAllViewTimes($postid);
        return array('result'=>$result,'postId'=>$postid,'views'=>$views);
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
            ->where('postID', (int) $postid)
            ->where('couldPost',1)
            ->find();
        $result['username'] = Db::name('user')->where('id',$result['authorID'])->find()['username'];
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

    public function getByClassify($classify, $second_classify)
    {
        if (!empty($second_classify))
        {
            $result = Db::name('user_post')
                        ->where([
                           'classify'           => $classify
                            ,'second_classify'  => $second_classify
                            ,'couldPost'        => 1
                        ])->order('postTime','desc')
                        ->paginate(6)
                        ->each(function ($item, $key) {
                                $item['pidtext']    = Db::name('user_resource_classify')->where('classifyID',$item['classify'])->find()['name'];
                                $item['childtext']  = Db::name('user_resource_classify')->where('classifyID',$item['second_classify'])->find()['name'];
                                $id = $item['authorID'];
                                if ($id == 0) $item['username'] = 'admin';
                                else $item['username'] = Db::name('user')->field('username')->where('id',$id)->find()['username'];
                            return $item;
                        });
        }
        else
        {
            $result = Db::name('user_post')
                ->where([
                    'classify'         => $classify
                    ,'couldPost'       => 1
                ])->order('postTime','desc')
                ->paginate(6)
                ->each(function ($item, $key){
                    $item['pidtext']    = Db::name('user_resource_classify')->where('classifyID',$item['classify'])->find()['name'];
                    $id = $item['authorID'];
                    if ($id == 0) $item['username'] = 'admin';
                    else $item['username'] = Db::name('user')->field('username')->where('id',$id)->find()['username'];
                    return $item;
                });
        }

        $postid = '';
        foreach ($result as $value)
        {
            $postid .= $value['postID'] . ',';
        }
        $view = self::getModelInstance('Action')->getAllViewTimes($postid);
        return array('result'=>$result,'postId'=>$postid,'views'=>$view);
    }


    // 获取回复
    public function getReply($postid)
    {
        $replys = DB::name('user_reply')
            ->where([
                'postID' => $postid
            ])
            ->order('replyTime','desc')
            ->paginate(6)
            ->each(function ($item, $key){
                $user = Db::name('user')->field('username')->where('id',$item['uid'])->find()['username'];
                $item['user'] = $user;
                return $item;
            });
        return $replys;

    }


    // 返回搜索内容
    public function getSearch($s)
    {
        $result = Db::name('user_post')
            ->where('couldPost',1)
            ->where('title','like','%'.$s.'%')
            ->order('postTime','desc')
            ->paginate(5)
            ->each(function ($item, $key){
                if ($item['authorID'] == 0)
                {
                    $item['username'] = 'admin';
                }
                else
                {
                    $authorID = $item['authorID'];
                    $author = Db::name('user')->where('id',$authorID)->find()['username'];
                    $item['username'] = $author;
                }
                return $item;
            });
        $postid = '';
        foreach ($result as $value)
        {
            $postid .= $value['postID'] . ',';
        }
        $views = self::getModelInstance('Action')->getAllViewTimes($postid);
        return array('result'=>$result,'postId'=>$postid,'views'=>$views);
    }

    public function getVigor()
    {
        $result = Db::name('user_post')
            ->where('couldPost',1)
            ->where('boutique',1)
            ->order('postTime','desc')
            ->paginate(5)
            ->each(function ($item, $key){
                if ($item['authorID'] == 0)
                {
                    $item['username'] = 'admin';
                }
                else
                {
                    $authorID = $item['authorID'];
                    $author = Db::name('user')->where('id',$authorID)->find()['username'];
                    $item['username'] = $author;
                }
                return $item;
            });
        $postid = '';
        foreach ($result as $value)
        {
            $postid .= $value['postID'] . ',';
        }
        $views = self::getModelInstance('Action')->getAllViewTimes($postid);
        return array('result'=>$result,'postId'=>$postid,'views'=>$views);
    }
}
?>
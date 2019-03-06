<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Exception;
use think\Session;
use Predis;
class Index extends Base
{
    public function index($main = '')
    {
        $new = $this->getModelInstance('Index')->getNewestPost();

        $this->assign('model','index');
        $this->assign('new',$new);

        return $this->fetch();
    }

    public function getClassify()
    {
        return $this->getModelInstance('Index')->getClassify();
    }

    public function viewPost($postid)
    {
        $this->assign('model','viewpost');
        $classify       = $this->getModelInstance('Index')->getAllClassify();
        $content        = $this->getModelInstance('Index')->getPostContent($postid);
        $viewTimes      = $this->getModelInstance('Action')->logViewTimes($postid)->getViewTimes($postid);
        $reply          = $this->getModelInstance('Index')->getReply($postid);
        $isLogin        = false;
        $isShowAddress  = false;
        $id = Session::get('id');
        if (!empty($id))
        {
            $isLogin = true;
            $isShowAddress  = $this->getModelInstance('Action')->isReply($postid, $id);
        }
        if ($isShowAddress == false)
        {
            unset($content['postAddress']);
            unset($content['transpond']);
        }
        $this->assign('reply',$reply);
        $this->assign('content',$content);
        $this->assign('viewTimes',$viewTimes);
        $this->assign('classify',$classify);
        $this->assign('isLogin',$isLogin);
        $this->assign('isShowAddress', $isShowAddress);
        return $this->fetch('viewpost');
    }


    public function groupByClassify()
    {
        $classify = $this->request->get('classify') ?: '';
        $second_classify = $this->request->get('second_classify') ?: '';
        if (empty($classify) && empty($second_classify)) throw new Exception();
        $group = $this->getModelInstance('Index')->getByClassify($classify, $second_classify);
        if (count($group['result']) == 0) throw new Exception();
        $classify = $this->getModelInstance('Index')->getClassify();
        $this->assign('model','group');
        $this->assign('classifyPost', $group);
        $this->assign('classify',$classify);
        return $this->fetch('group');
    }


    // 展示等级列表
    public function showLevelList()
    {
        $level = Db::name('user_level')->order('level','asc')->paginate(20);
        $users = $this->getModelInstance('User')->getLevelRank();
        $this->assign('users',$users);
        $this->assign('model', 'level');
        $this->assign('level',$level);
        return $this->fetch('level');
    }

    // 展示最新回复的稿件
    public function showReplyLastly()
    {

        return $this->fetch();
    }

    // 展示精品的帖子
    public function showVigor()
    {
        $result = parent::getModelInstance('index')->getVigor();
        if (empty($result['postId'])) throw new Exception();
        $this->assign('model','index');
        $this->assign('new',$result);
        $this->assign('otherJs','vigor');
        return $this->fetch('index');
    }

    // 投稿指南页面
    public function showPostCompass()
    {
        $this->assign('model','compass');
        return $this->fetch('compass');
    }


    public function search()
    {
        $s = $this->request->get('title');
        if (empty($s)) throw new Exception();

        $result = parent::getModelInstance('index')->getSearch($s);


        if (!$result['postId']) throw new Exception();
        $this->assign('model','index');
        $this->assign('new',$result);

        return $this->fetch('index');
    }
}

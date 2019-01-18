<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;

class Index extends Base
{
    public function index()
    {
        $new = $this->getModelInstance('Index')->getNewestPost();
        $this->assign('classify',$this->getClassify());
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
        $classify = $this->getModelInstance('Index')->getAllClassify();
        $content = $this->getModelInstance('Index')->getPostContent($postid);
        $viewTimes = $this->getModelInstance('Action')->logViewTimes($postid)->getViewTimes($postid);
        $this->assign('content',$content);
        $this->assign('viewTimes',$viewTimes);
        $this->assign('classify',$classify);
        return $this->fetch('viewpost');
    }
}

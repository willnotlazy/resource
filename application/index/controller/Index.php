<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;
use Predis;
class Index extends Base
{
    public function index($main = '')
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


    public function groupByClassify($classify, $second_classify = '')
    {
        $group = $this->getModelInstance('Index')->getByClassify($classify, $second_classify);
        if (count($group['result']) == 0)
        {
            $this->error('未找到该分类','/','','3');
            exit;
        }
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
}

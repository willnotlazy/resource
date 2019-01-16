<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;

class Index extends Base
{
    public function index()
    {
        $week = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $name = empty(Session::get('name')) ? '' : Session::get('name');
        $date = '今天是' . date('Y年m月d') . ','.$week[date('w',time())];
        $new = $this->getModelInstance('Index')->getNewestPost();
        $this->assign('classify',$this->getClassify());
        $this->assign('model','Index');
        $this->assign('new',$new);
        $this->assign('name',$name);
        $this->assign('date',$date);
        return $this->fetch();
    }

    public function getClassify()
    {
        return $this->getModelInstance('Index')->getClassify();
    }

}

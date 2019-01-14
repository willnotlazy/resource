<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;

class Index extends Controller
{
    public function index()
    {
        $week = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
        $name = empty(Session::get('name')) ? '' : Session::get('name');
        $date = '今天是' . date('Y年m月d') . ','.$week[date('w',time())];
        $this->assign('name',$name);
        $this->assign('date',$date);
        return $this->fetch();
    }
}

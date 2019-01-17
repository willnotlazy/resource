<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/20
 * Time: 13:41
 */
namespace app\index\controller;
use think\Controller;
use think\Facade;
use think\Request;
use think\Session;
class Base extends Controller
{
    // 返回模型单例
    private static $__ModelInstance = [];
    protected $week = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
    public function _initialize()
    {
        $name = empty(Session::get('name')) ? '' : Session::get('name');
        $date = '今天是' . date('Y年m月d') . ','.$this->week[date('w',time())];
        $this->assign('name',$name);
        $this->assign('date',$date);
    }

    // 获取模型的唯一实例
    public function getModelInstance($model)
    {
        if (isset(self::$__ModelInstance[$model])) return self::$__ModelInstance[$model];
        $modelclass = "app\\index\\model\\".$model;
        self::$__ModelInstance[$model] = new $modelclass;
        return self::$__ModelInstance[$model];
    }

}
?>
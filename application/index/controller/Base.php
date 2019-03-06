<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/20
 * Time: 13:41
 */
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Facade;
use think\Request;
use think\Session;
use Workerman\Worker;
class Base extends Controller
{
    // 返回模型单例
    private static $__ModelInstance = [];
    protected $week = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
    public function _initialize()
    {
        $name = empty(Session::get('name')) ? '' : Session::get('name');
        $thumb = \think\Db::name('user')->field('thumb')->where('id',Session::get('id'))->find();
        $date = '今天是' . date('Y年m月d') . ','.$this->week[date('w',time())];

        $id = Session::get('id');
        if (!empty($id))
            $new_msg = Db::name('msg_reply')->where('uid',$id)->where('status',0)->count() ?: '';

        $all_range = self::getModelInstance('Range')->getAllPostRange('all_post_range');
        $day_range = self::getModelInstance('Range')->getAllPostRange('day_post_range');

        $announce_range = self::getModelInstance('Range')->getAnnounceRange();

        $this->assign('new_msg',isset($new_msg) ? $new_msg : '');
        $this->assign('all_range',!empty($all_range) ? $all_range : '');
        $this->assign('day_range',!empty($day_range) ? $day_range : '');
        $this->assign('lastest_login',showLastLoginUser());
        $this->assign('announce_range',$announce_range);

        $this->assign('classify',$this->getModelInstance('Index')->getClassify());


        $this->assign('name',$name);
        $this->assign('thumb',$thumb);
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
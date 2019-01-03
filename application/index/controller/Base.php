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
class Base extends Controller
{
    // 返回模型单例
    private static $__ModelInstance = [];

    public function _initialize()
    {
        deleteOutTimeToken();
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
<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/28
 * Time: 10:15
 */
namespace app\index\model;

use think\Model;
class Base extends Model
{
    public function initialize()
    {
        deleteOutTimeToken();
    }

    // 返回模型单例
    private static $model = [];
    public static function getModelInstance($name)
    {
        if (isset(self::$model[$name])) return self::$model[$name];
        $modelName = "app\\index\\model\\$name";
        self::$model[$name] = new $modelName;
        return self::$model[$name];
    }
}
?>
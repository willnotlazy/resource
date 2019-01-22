<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/28
 * Time: 10:15
 */
namespace app\index\model;

use think\Db;
use think\Model;
use Predis;
class Base extends Model
{
    protected $redis = null;
    public function initialize()
    {
        $this->redis = new Predis\Client([
            'host'  => '127.0.0.1',
            'port'  => 6379
        ]);
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

    public function checkTokenTrueAndFalse($token)
    {
        $tokenInfo = Db::name('user_token')->where('userID',$token->data)->find();
        $ip = getIp();
        $now = time() - 2;
        if ($ip != $tokenInfo['clientIp'] || $now < ($tokenInfo['limit']) - 1440 || ($now > $tokenInfo['limit'] - 1440)) return false;
        return true;

    }
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/20
 * Time: 13:41
 */
namespace app\index\controller\user;
use think\Controller;
use think\Facade;
use think\Request;
use app\index\model\user\User as UserModel;
class Base extends Controller
{
    public $user_model;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    public function _initialize()
    {
        $this->user_model =  UserModel::getInstance();
    }
}
?>
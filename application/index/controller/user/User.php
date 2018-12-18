<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/27
 * Time: 10:53
 */
namespace app\index\controller\user;
use think\Controller;
use think\Facade;
use think\Request;
use app\index\model\user\User as UserModel;
class User extends Controller
{
    public $user_model;
    public function __construct()
    {
        $this->user_model = new UserModel();
    }

    public function login(Request $request)
    {
        $param = $request->param();
        $result = $this->user_model->LoginCheck($param);
        return json_message(format($result,[404,200]));
    }
    public function register(Request $request)
    {
        $params = $request->param();
        $result = UserModel::registerUser($params);
        return json_message(format($result,[404,201]));
    }
//    public function checkLogin(Request $request)
//    {
//        $params = $request->param();
//        $result = UserModel::loginIn($params);
//        return json_message(format($result,[404,201]));
//    }
}
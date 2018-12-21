<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/27
 * Time: 10:53
 */
namespace app\index\controller\user;
use app\index\controller\user\Base;
use think\Facade;

class User extends Base
{
    public function login()
    {
        $param = $this->request->param();
        $token = $this->request->header('token');
        $result = $this->user_model->LoginCheck($param);
        return json_message(format($result,[404,200]));
    }
    public function register()
    {
        $params = $this->request->param();
        $result = UserModel::registerUser($params);
        return json_message(format($this->result,[404,201]));
    }

    public function showLevel($id)
    {
        return json_encode($this->user_model->islevelUp($id));
    }

}
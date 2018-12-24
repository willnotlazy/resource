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
    // 登录
    public function login()
    {
        $param = $this->request->param();
        $token = $this->request->header('token');
        $result = $this->user_model->LoginCheck($param);
        return json_message(format($result,[404,200]));
    }

    // 注册
    public function register()
    {
        $params = $this->request->param();
        if ($this->isUserExist($params['username'],$params['email']) === 'email exist') return json_message(format('该邮箱已注册',[404,201]));
        if ($this->isUserExist($params['username'],$params['email']) === 'username exist') return json_message(format('用户名已存在',[404,201]));
        $result = $this->user_model->registerUser($params);
        return json_message(format($result,[404,201]));
    }

    // 判断注册账号是否存在  不存在返回true
    private function isUserExist($username,$email = '')
    {
        if ($this->user_model->getFromUsername($username) && $this->user_model->getFromUserEmail($email)) return true;
        if ($this->user_model->getFromUsername($username) === false) return 'username exist';
        if ($this->user_model->getFromUserEmail($email) === false) return  'email exist';
    }


    // 展示等级测试方法
    public function showLevel($id)
    {
        return json_encode($this->user_model->islevelUp($id));
    }
}
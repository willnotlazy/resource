<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/27
 * Time: 10:53
 */
namespace app\index\controller;
use think\Facade;

class User extends Base
{
    // 登录
    public function login()
    {
        $param = $this->request->param();
        if(empty($param)) return $this->fetch('login');
        $userModel = $this->getModelInstance('User');
        $token = $this->request->header('token');
        $result = $userModel->LoginCheck($param);
        if($result['code'] == USER_NOT_FOUND) $this->error($result['msg'],'/login','','1');
        if($result['code'] == LIMIT_LOGIN_FAIL_TIMES) $this->error($result['msg'],'/login','','1');
        if($result['code'] == PASSWORD_ERROR) $this->error($result['msg'],'/login','','1');
        if($result['code'] == LOGIN_SUCCESS) $this->success($result['msg'],'/login',$result['data'],'1');
        if($result['code'] == ALREADY_LOGIN) $this->error($result['msg'],'/login','','1');
        return json_encode($result);
    }

    // 注册
    public function register()
    {
        $params = $this->request->param();
        if ($this->isUserExist($params['username'],$params['email']) === 'email exist') return json_message(format('该邮箱已注册',[404,201]));
        if ($this->isUserExist($params['username'],$params['email']) === 'username exist') return json_message(format('用户名已存在',[404,201]));
        $result = $this->getModelInstance('User')->registerUser($params);
        return json_message(format($result,[404,201]));
    }

    // 判断注册账号是否存在  不存在返回true
    private function isUserExist($username,$email = '')
    {
        if ($this->getModelInstance('User')->getFromUsername($username) && $this->getModelInstance('User')->getFromUserEmail($email)) return true;
        if ($this->getModelInstance('User')->getFromUsername($username) === false) return 'username exist';
        if ($this->getModelInstance('User')->getFromUserEmail($email) === false) return  'email exist';
    }


    // 展示等级测试方法
    public function showLevel($id)
    {
        return json_encode($this->getModelInstance('User')->islevelUp($id));
    }

    // ajax 判断用户名是否存在
    public function ajaxJudgeUserName()
    {
        $param = $this->request->param('username');
        echo $this->getModelInstance('User')->getFromUsername($param);
    }

    // ajax 判断邮箱是否合法且是否以被注册
    public function ajaxJudgeEmail()
    {

    }

    // ajax 判断密码是否符合要求
}
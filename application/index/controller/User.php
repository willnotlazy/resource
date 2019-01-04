<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/27
 * Time: 10:53
 */
namespace app\index\controller;
use think\Facade;
use think\Request;
use think\Session;
use think\Cookie;
class User extends Base
{
    // 登录
    public function login()
    {
        $param = $this->request->param();
        $name = Session::get('name');
        if (!empty($name)) $this->success($name,'/info');
        if(empty($param)) return $this->fetch('login');
        $userModel = $this->getModelInstance('User');
        $token = $this->request->header('token');
        $result = $userModel->LoginCheck($param);
        return json_encode($result);
//        if($result['code'] == USER_NOT_FOUND) $this->error($result['msg'],'/login','','1');
//        if($result['code'] == LIMIT_LOGIN_FAIL_TIMES) $this->error($result['msg'],'/login','','1');
//        if($result['code'] == PASSWORD_ERROR) $this->error($result['msg'],'/login','','1');
//        if($result['code'] == LOGIN_SUCCESS) $this->success($result['msg'],'/info',$result['data'],'1');
//        if($result['code'] == ALREADY_LOGIN) $this->error($result['msg'],'/login','','1');

    }

    // 展示个人信息
    public function info()
    {
        $name = Session::get('name');
        if (!empty($_POST))
        {
            session_destroy();
            $this->success('您已退出登录','/login');
        }
        if (empty($name)) $this->success('您已退出登录','/login');
        $this->assign('name',$name);
        return $this->fetch();
    }

    // 注册
    public function register()
    {
        $params = $this->request->param();
        $result =  $this->validate($params,'User');
        if ($result !== true) return $result;
        if ($this->isUserExist($params['username'],$params['email']) === 'email exist') return json_encode(['code'=>REGISTER_EMAIL_EXIST,'msg'=>map[REGISTER_EMAIL_EXIST]]);
        if ($this->isUserExist($params['username'],$params['email']) === 'username exist') return json_encode(['code'=>REGISTER_USER_EXIST,'msg'=>map[REGISTER_USER_EXIST]]);
        $result = $this->getModelInstance('User')->registerUser($params);
        return json_encode($result);
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
        $param = $this->request->param('email');
        echo $this->getModelInstance('User')->getFromUserEmail($param);
    }
}
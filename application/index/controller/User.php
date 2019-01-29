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
        if(empty($param))
        {
            $this->assign('model','login');
            return $this->fetch('login');
        }
        if (empty($param['code'])) return json_encode(array('code' => NULL_CAPTCHA, 'msg' => map[NULL_CAPTCHA]));
        if (!captcha_check($param['code'],1)) return json_encode(array('code' => ERROR_CAPTCHA, 'msg' => map[ERROR_CAPTCHA]));
        unset($param['code']);
        $userModel = $this->getModelInstance('User');
        $result = $userModel->LoginCheck($param);
        return json_encode($result);

    }

    // 登出
    public function layout()
    {
        $id = Session::get('id');
        if (empty($id))
        {
            $this->error(map[NOTLOGIN],'login');
            exit;
        }
        $token = $this->request->post();
        $result = $this->validate($token,'Layout');
        if ($result !== true)
        {
            $this->request->token();
            return $result;
        }
        Session::destroy();
        return json_encode(['code'=>EXIT_LOGIN,'msg'=>map[EXIT_LOGIN]]);
    }


    // 展示个人信息
    public function info()
    {
        if (empty(Session::get('id')))
        {
            $this->error(map[NOTLOGIN],'/login');
            exit;
        }
        $name = Session::get('name');
        $this->assign('name',$name);
        $this->assign('model','info');
        return $this->fetch();
    }

    // 注册
    public function register()
    {
        $params = $this->request->param();
        if (empty($params['code'])) return json_encode(array('code' => NULL_CAPTCHA, 'msg' => map[NULL_CAPTCHA]));
        if (!captcha_check($params['code'], 2)) return json_encode(array('code' => ERROR_CAPTCHA, 'msg' => map[ERROR_CAPTCHA]));
        unset($params['code']);
        $result =  $this->validate($params,'Register');
        if ($result !== true) {
            $this->request->token();
            return $result;
        }
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
    
    
    // 我的投稿
    public function viewMyPost()
    {
        $id = Session::get('id');
        $this->assign('model','viewmypost');
        $selfpost = $this->getModelInstance('User')->getSelfPost($id);
        $classify = $this->getModelInstance('Index')->getClassify();
        $this->assign('classify',$classify);
        $this->assign('selfpost',$selfpost);
        return $this->fetch('viewmypost');
    }


    // 查看自己的投稿
    public function viewSelfPost($postId)
    {
        $id = Session::get('id');
        if (empty($id)) return json_encode(['code','msg']);
        $this->assign('model','viewselfpost');
        return $this->fetch('selfcontent');
    }
}
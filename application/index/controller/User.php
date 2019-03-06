<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/27
 * Time: 10:53
 */
namespace app\index\controller;
use think\Db;
use think\Exception;
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
        $token = $this->request->param();
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
        $id         = Session::get('id');
        $info       = self::getModelInstance('User')->getBasicInfo($id);
        $selfPost   = self::getModelInstance('User')->getSelfPost($id, 15);
        $selfSet    = self::getModelInstance('User')->getUserSpaceSet($id);
        $this->assign('selfSet',$selfSet);
        $this->assign('selfPost',$selfPost);
        $this->assign('info',$info);
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


    public function activeCheck($email='', $activation_key='')
    {
        if (empty($email) || empty($activation_key)) $this->error('无效的验证状态','/','','3');
        $result = self::getModelInstance('User')->mailCheck($email, $activation_key);
        if (!$result) $this->error('无效的验证状态','/','','3');
        $this->success('账号激活成功!','/','','3');
    }

    public function editSelfSpace()
    {
        $id = Session::get('id');
        if (empty($id))
        {
            $this->error('页面找不到了','/','','3');
            exit;
        }
        $this->assign('model','editSpace');
        return $this->fetch('editSpace');

    }

    public function showUserInfo()
    {
        $username = $this->request->get('name');
        if ($username == (int)Session::get('name'));
        {
            $this->redirect('/info');
            exit;
        }
        $info       = self::getModelInstance('User')->getBasicInfo($id);
        $selfPost   = self::getModelInstance('User')->getSelfPost($id, 15);
        $selfSet    = self::getModelInstance('User')->getUserSpaceSet($id);
        $this->assign('selfSet',$selfSet);
        $this->assign('selfPost',$selfPost);
        $this->assign('info',$info);
        $this->assign('model','showUser');
        return $this->fetch('showUser');
    }

    // 小黑屋关着的人
    public function darkRoom()
    {
        $this->assign('model','darkroom');
        $prisoner = self::getModelInstance('User')->getPrisoner();
        $this->assign('prisoner',empty($prisoner) ? '' : $prisoner);
        return $this->fetch('darkroom');
    }

    // 显示msg
    public function showMsg()
    {
        if (empty(Session::get('id'))) throw new Exception();
        $id = Session::get('id');
        $msg = parent::getModelInstance('User')->getMsg($id);
        $this->assign('msg',$msg);

        $this->assign('model','msg');
        return $this->fetch('showmsg');
    }

    // 获取评论dialog
    public function ajaxGetReplyDialog()
    {
        $id = $this->request->param('id');
        $uid = Session::get('id');
//        if ((int)$id !== (int)Session::get('id')) throw new Exception();
        $dialog = Db::name('msg_reply')->where('id',$id)->find();
        $nums = Db::name('msg_reply')->where('uid',$uid)->where('status',0)->count();
        if((int)$dialog['status'] === 0 )
        {
            $dialog['status'] = 1;
            Db::name('msg_reply')->update($dialog);
        }

        $dialog['nums'] = $nums;
        return json_encode($dialog);
    }
}
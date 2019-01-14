<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/19
 * Time: 16:41
 */
namespace app\index\controller;
use think\Request;
use think\Session;
class Action extends Base
{

    // 发帖
    public function postSomething()
    {
        if (empty(Session::get('id')))
        {
            $this->error('请先登录','/login');
            exit;
        }
        $this->assign('name',Session::get('name'));
        return $this->fetch('createpost');
    }

    // 添加发布的帖子
    public function addPost()
    {
        if (empty(Session::get('id'))) exit;
        $authorID = Session::get('id');
        $params = $this->request->post();
        $postID = Action::getModelInstance('Action')->addPost($params,$authorID);
        $data['postID'] = $postID;
        return json($data);
    }
}
?>
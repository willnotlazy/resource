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
        $classify = $this->getModelInstance('Index')->getClassifyByPidGroup();
        $this->assign('classify',$classify);
        $this->assign('name',Session::get('name'));
        $this->assign('model','Action');
        return $this->fetch('createpost');
    }

    // 添加发布的帖子
    public function addPost()
    {
        if (empty(Session::get('id'))) exit;
        $authorID = Session::get('id');
        $params = $this->request->post();
        unset($params['__token__']);
        $params['second_classify'] = $params['second-classify'];
        unset($params['second-classify']);
        $params['content'] = $params['editorValue'];
        unset($params['editorValue']);
        $file = $this->request->file('cover');
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                $params['cover'] = str_replace('\\','/','uploads/' . $info->getSaveName());
            }else{
                // 上传失败获取错误信息
                return json($file->getError());
            }
        }
        $postID = Action::getModelInstance('Action')->addPost($params,$authorID);
        $data['postID'] = $postID;
        return json($data);
    }
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/19
 * Time: 16:41
 */
namespace app\index\controller;
use think\Db;
use think\Request;
use think\Session;
class Action extends Base
{

    // 发帖
    public function postSomething()
    {
        $id = Session::get('id');
        if (empty($id))
        {
            $this->error('请先登录','/login');
            exit;
        }

        $reachLimit = $this->getModelInstance('Action')->getPostLimits($id);
        if ($reachLimit) $this->assign('hint',1);
        $classify = $this->getModelInstance('Index')->getClassifyByPidGroup();
        $this->assign('classify',$classify);
        $this->assign('name',Session::get('name'));
        $this->assign('model','createpost');
        return $this->fetch('createpost');
    }

    // 添加发布的帖子
    public function addPost()
    {
        if (empty(Session::get('id'))) exit;
        $authorID = Session::get('id');
        $reachLimit = $this->getModelInstance('Action')->getPostLimits($authorID);
        if ($reachLimit) return json_encode(['code'=>POST_LIMIT,'msg'=>addpostMap[POST_LIMIT]]);
        $params = $this->request->post();
        $valResult = $this->validate($params,'Addpost');
        if ($valResult !== true)
        {
            $this->request->token();
            return $valResult;
        }
        unset($params['__token__']);
        $file = $this->request->file('cover');
        $musicFile = $this->request->file('music');
        if($file){
            $info = $file->validate(['size'=>6291456,'ext'=>'jpg,png,gif,bmp'])->rule('md5')->move(ROOT_PATH . 'public' . DS . 'uploads/images');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                $params['cover'] = $this->request->domain() . '/'. str_replace('\\','/','uploads/images/' . $info->getSaveName());
                $picName = $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                return json_encode($file->getError());
            }
            unset($info);
        }

        if ($musicFile) {
            $musicInfo = $musicFile->validate(['size'=>31457280,'ext'=>'ogg,mp3,wav'])->rule('md5')->move(ROOT_PATH . 'public' . DS . 'uploads/musics');
            if ($musicInfo){
                $params['music'] = $this->request->domain() . '/'. str_replace('\\','/','uploads/musics/' . $musicInfo->getSaveName());
                $musicName = $musicInfo->getSaveName();
            } else{
                unlink(replace('\\','/',ROOT_PATH . 'public/uploads/images' . DS . $picName));
                return json_encode($musicFile->getError());
            }
            unset($musicInfo);
        }
        $result = Action::getModelInstance('Action')->addPost($params,$authorID);
        if (is_array($result))
        {
            $pic   = str_replace('\\','/',ROOT_PATH . 'public/uploads/images' . DS . $picName);
            $musicDir = str_replace('\\','/',ROOT_PATH . 'public/uploads/musics' . DS . $musicName);
            unlink($pic);
            unlink($musicDir);
            $this->request->token();
            return json_encode($result);
        }
        return json_encode(['code'=>POST_SUCCESS,'msg'=>addpostMap[POST_SUCCESS]]);
    }


    public function ajaxGetPostViewTimes()
    {
        $postId = $this->request->post('postid');
        return $this->getModelInstance('Action')->getViewTimes($postId);
    }

    public function ajaxGetAllViewTimes()
    {
        $postId = $this->request->post('postid');
        return $this->getModelInstance('Action')->getAllViewTimes($postId);
    }
    
    
    // 发布留言
    public function addReply()
    {
        $id                 = Session::get('id');
        if (empty($id)) return json_encode(['code' => UNLAWFUL_ACTION, 'msg' => map[UNLAWFUL_ACTION]]);
        $param              = $this->request->post();
        if (empty($param['editorValue'])) return json_encode(['code' => EMPTY_CONTENT, 'msg' => addpostMap[EMPTY_CONTENT]]);
        $param['uid']       = $id;
        $param['replyTime'] = time();
        Db::name('user_reply')->insert($param);
        return json_encode(['code' => REPLY_SUCCESS, 'msg' => addpostMap[REPLY_SUCCESS]]);
    }


}
?>
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

        $move_result = move_upload_file([
            [
                'file'      =>  $file,
                'size'      =>  6291456,
                'ext'       =>  'jpg,png,gif,bmp',
                'dir'       =>  'images'
            ],
            [
                'file'      =>  $musicFile,
                'size'      =>  31457280,
                'ext'       =>  'ogg,mp3,wav',
                'dir'       =>  'musics'
            ]
        ]);

        if (!empty($move_result['errors'])){
            foreach ($move_result['fileNames'] as $v)
            {
                unlink($v);
            }
            unset($params);
            return json_encode($move_result['errors']);
        }

        $params['cover'] = $move_result['fileData']['images'];
        $params['music'] = $move_result['fileData']['musics'];

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

    public function editMySpace()
    {
        $params   = $this->request->param();
        $bg_image = $this->request->file("bg_image");
        $bg_music = $this->request->file("bg_music");
        $thumb    = $this->request->file("thumb");

        $bg_music_name = empty($bg_music) ? '' : $bg_music->getInfo()['name'];
        $moveResult = move_upload_file([
            [
                'file'  =>  $bg_image,
                'size'  =>  6291456,
                'ext'   =>  'jpg,png,gif,bmp',
                'dir'   =>  'bgImages'
            ],
            [
                'file'  =>  $bg_music,
                'size'  =>  31457280,
                'ext'   =>  'ogg,mp3,wav',
                'dir'   =>  'bgMusics'
            ],
            [
                'file'  =>  $thumb,
                'size'  =>  6291456,
                'ext'   =>  'jpg,png,gif,bmp',
                'dir'   =>  'thumbs'
            ]
        ]);

        if (!empty($moveResult['errors']))
        {
            foreach ($moveResult['fileNames'] as $v)
            {
                unlink($v);
            }
            unset($params);
            return json_encode($moveResult['errors']);
        }
        $result = self::getModelInstance('Action')->saveEditData($params,$moveResult['fileData'],$bg_music_name);

        return json_encode(['code'=>20000,'msg'=>'OK']);
    }
}
?>
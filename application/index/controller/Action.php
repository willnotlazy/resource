<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/19
 * Time: 16:41
 */
namespace app\index\controller;
use think\Controller;
use think\Facade;
use think\Request;
use app\index\model\Action as ActionModel;
class Action extends Base
{

    // 发帖
    public function postSomething()
    {
        $token = $this->request->header('token');
        if (!checkToken($token)) return json_encode(['code'=>INVALID_TOKEN,'msg'=>map[INVALID_TOKEN]]);
        $params = $this->request->param();
        $id = checkToken($token)->data;
        $ip = getIp();
        $now = time() - 2;
        $postID = ActionModel::getInstance()->addPost($params,$id);
        $data['postID'] = $postID;
        $data['token'] = $token;
        return json($data);
    }

    // 获取token
    public function getToken($id)
    {
//        return Db::name('user_token')->
    }
}
?>
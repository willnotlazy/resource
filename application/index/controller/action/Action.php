<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/19
 * Time: 16:41
 */
namespace app\index\controller\action;
use think\Controller;
use think\Facade;
use think\Request;
use app\index\model\action\Action as ActionModel;
class Action extends Controller
{

    // 发帖
    public function postSomething()
    {
        $token = $this->request->header('token');
        if (!checkToken($token)) return json_message(format('token错误'),[404,201]);
        $params = $this->request->param();
        $id = checkToken($token)->data;
        $postID = ActionModel::getInstance()->addPost($params,$id);
        $data['postID'] = $postID;
        $data['token'] = $token;
        return json($data);
    }
}
?>
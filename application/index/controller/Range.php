<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2019/2/21
 * Time: 17:12
 */
namespace app\index\controller;

use phpDocumentor\Reflection\Types\Parent_;
use think\Db;
use think\Request;
use think\Session;
class Range extends Base
{
    private $self_model;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->self_model = self::getModelInstance('Range');
    }

    /*
     * ajax更新排行榜,每30s更新一次
     */
    // ajax获取最近登录用户
    public function ajaxGetLoginRange()
    {
//        return
    }

    // ajax获取总、日浏览排行,
    public function ajaxGetNewRange()
    {
        $day_range =  $this->self_model->getAllPostRange('day_post_range');
        $all_range = $this->self_model->getAllPostRange('all_post_range');
        $user_range = showLastLoginUser();
        $announce_range = $this->self_model->getAnnounceRange();
        return json_encode(['day'=>$day_range,'all'=>$all_range,'announce'=>$announce_range,'user'=>$user_range]);
    }

    // ajax获取日浏览排行
    public function ajaxGetDayPostViewRange()
    {

    }


}
<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2019/1/11
 * Time: 11:00
 */
namespace app\index\controller;

use think\Controller;
class Captcha extends Controller
{
    public function index()
    {
        return $this->fetch();
    }


    public function check($code = '')
    {
        $captcha = new \think\captcha\Captcha();
        if (!$captcha->check($code)){
            $this->error('验证码错误');
        }else{
            $this->success('验证码正确');
        }
    }
}
?>
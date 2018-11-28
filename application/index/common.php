<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/11/28
 * Time: 9:02
 */
/*
 *  return json
 */
function json_message($message)
{
    return json_encode($message);
}
function format($data,Array $code)
{
    if(empty($data))
    {
        $message = ['code'=>$code[0],'data'=>$data,'message'=>'账号或密码错误'];
    }
    else
    {
        $message = ['code'=>$code[1],'data'=>$data,'message'=>'登录成功'];
    }
    return $message;
}


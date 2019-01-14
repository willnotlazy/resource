<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件







/*
 *  定义返回的状态码
 */
define('NOTLOGIN',40444);
define('LOGIN_SUCCESS',20210);
define('USER_NOT_FOUND',40424);
define('PASSWORD_ERROR',40426);
define('LIMIT_LOGIN_FAIL_TIMES',40429);
define('ALREADY_LOGIN',40428);
define('INVALID_TOKEN',40427);
define('REGISTER_SUCCESS',20200);
define('EXIT_LOGIN',20199);
define('TOKEN_NULLITY',40500);

define('REGISTER_USER_EXIST',40413);
define('REGISTER_EMAIL_EXIST',40414);

define('EMAIL_ERROR',40412);
define('EMAIL_NOTNULL',40407);
define('USERNAME_TOSHORT',40411);
define('USERNAME_NOTNULL',40410);
define('PASSWORD_TOSHORT',40409);
define('PASSWORD_NOTNULL',40408);

define('TOKEN_ERROR',40422);

define('UNLAWFUL_ACTION',99999);
/*
 *  定义状态码对应的返回信息   PHP VERSION >= 7.0.0
 */
define('map',[
    LOGIN_SUCCESS               => '登录成功',
    USER_NOT_FOUND              => '用户名不存在',
    PASSWORD_ERROR              => '密码错误',
    LIMIT_LOGIN_FAIL_TIMES      => '您已累计登录失败5次,请一小时后重试',
    ALREADY_LOGIN               => '该用户已在其他浏览器登录',
    INVALID_TOKEN               => '无效的登录状态',
    REGISTER_USER_EXIST         => '用户名已存在',
    REGISTER_EMAIL_EXIST        => '邮箱已被注册',
    REGISTER_SUCCESS            => '注册成功',
    EMAIL_ERROR                 => '邮箱格式不正确',
    EMAIL_NOTNULL               => '邮箱不能为空',
    USERNAME_TOSHORT            => '用户名不能短于5个字符',
    USERNAME_NOTNULL            => '用户名不能为空',
    PASSWORD_TOSHORT            => '密码不能短于6个字符',
    PASSWORD_NOTNULL            => '密码不能为空',
    TOKEN_ERROR                 => '您的登录信息有误,请重新登录',
    NOTLOGIN                    => '您还未登录,请先登录',
    EXIT_LOGIN                  => '退出成功',
    TOKEN_ERROR                 => '令牌信息无效',
    UNLAWFUL_ACTION             => '非法操作'
]);


define('PWDERROR','pwdError');

/*
 * decrypt login user and password
 */
function decrypt($data)
{
    openssl_private_decrypt(base64_decode($data),$decryptData,PRIVATEKEY);
//    openssl_private_decrypt(base64_decode($data['key']),$decryptData,PRIVATEKEY);
    $data = openssl_decrypt(base64_decode($data),'AES-128-CBC',$decryptData,true,$decryptData);
    return $data;
//    $data['password'] = md5(PASSWORD_PREFIX . openssl_decrypt(base64_decode($data['password']),'AES-128-CBC',$decryptData,true,$decryptData));
//    return $data;
}


/*
 *  get real ip
 */
// 获取用户真实ip
function getIp()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return ($ip);
}
// 获取用户真实ip
function get_real_ip()
{
    $ip=false;
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ips=explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
        if($ip){ array_unshift($ips, $ip); $ip=FALSE; }
        for ($i=0; $i < count($ips); $i++){
            if(!eregi ('^(10│172.16│192.168).', $ips[$i])){
                $ip=$ips[$i];
                break;
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

function getSalt()
{
    $str = '';
    $str .= getIp();
    $str .= uniqid();
    $str .= time();
    $salt = hash('md5',$str);
    return $salt;
}

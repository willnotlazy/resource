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

// 公钥&私钥暂时存放在common内，方便调用
define('PRIVATEKEY',<<<EOD
-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAMyzyYzLHYP6S8ij
A55u1couJDxpbyH+9OUgmdhw9oQ8KihQFQps+nxhikINdgz0AXE8tKt5KRz5Aqxt
5wG0RgQwic6lmUUE85IaDnL94KPEqsHbFJndkL7JB08oO2ADj1lMHM2UGjudsqLE
Lm1qvKppNVjsp/Ys64tZHj6pyNZ1AgMBAAECgYEAwt9tQoGi6Z+AQdMegNdW45Cl
onVk/OIw1WgBzdFMfXqhT5tdTH2OwJZC/rq95XrtXJXEEXHYt+I+r1Q5FKA//csf
gnfjPkr3+GZg785+c7NPQqiT7cxGWgaJgie0CCNV+ovbyTLTI8aaIKmVVcafo4+l
SZMWjhal5CKLne6PyIkCQQD8ZC/ASCla8Hi4cZAZm/3ZdN7/gSg0UEcNHZY7MI1X
8Qao2l01s1kPKa/W5MAc3vAxyfDR58jOuvXXK/irB8MTAkEAz6EMGfRCdpsZ+pu4
YF1sLeJHb8HdxaEMUPXXJ0yOpD2JV7F3wIZjFk+a9pXxK+9UWDm2Ldad9JTF9Oc7
2eqpVwJAAXyNk3JZXAHClEOG97+ldRxtG9Ak7nnykS81bU/R5Uy0H1Z56hEOWzqB
oKBkSUc+3uwzkOjuk9kiDYxiwI8hJQJBAKMCYJrb33Z47RuJOGdH0Y/wkH9YaIIp
n57MdD/hZjfiLDsSFN+tYov4scQZEoCY5NJjdPll/xsv1n8hMCc1if8CQBHp5Kgz
Vwmn1yPUx1FcaMlsCpP12Q0QeQ6tJ+hJwykpjrq0lG18J/rI4bdeR/gxe9/pEiA+
5xjY6vphyI8hkSI=
-----END PRIVATE KEY-----
EOD
);
define('PUBLICKEY',<<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDMs8mMyx2D+kvIowOebtXKLiQ8
aW8h/vTlIJnYcPaEPCooUBUKbPp8YYpCDXYM9AFxPLSreSkc+QKsbecBtEYEMInO
pZlFBPOSGg5y/eCjxKrB2xSZ3ZC+yQdPKDtgA49ZTBzNlBo7nbKixC5taryqaTVY
7Kf2LOuLWR4+qcjWdQIDAQAB
-----END PUBLIC KEY-----
EOD
);

/*
 *  定义返回的状态码
 */
define('LOGIN_SUCCESS',20210);
define('USER_NOT_FOUND',40424);
define('PASSWORD_ERROR',40426);
define('LIMIT_LOGIN_FAIL_TIMES',40429);
define('ALREADY_LOGIN',40428);
define('INVALID_TOKEN',40427);
define('REGISTER_SUCCESS',20200);


define('REGISTER_USER_EXIST',40413);
define('REGISTER_EMAIL_EXIST',40414);

define('EMAIL_ERROR',40412);
define('EMAIL_NOTNULL',40407);
define('USERNAME_TOSHORT',40411);
define('USERNAME_NOTNULL',40410);
define('PASSWORD_TOSHORT',40409);
define('PASSWORD_NOTNULL',40408);
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
    PASSWORD_NOTNULL            => '密码不能为空'
]);


define('PWDERROR','pwdError');




/*
 *  return json
 */


/*
 * checkToken
 */
function checkToken($token)
{
    try {
        \Firebase\JWT\JWT::$leeway = 60;
        $token = \Firebase\JWT\JWT::decode($token,PUBLICKEY,array('RS256'));
        return $token;
    } catch(Exception $e) {  //其他错误
        return false;
    }
}

/*
 * createToken
 */
function createToken($data, Array $param)
{
    $token = array();
    foreach ($param as $key => $value)
    {
        $token[$key] = $value;
    }
    $token['data'] = $data;
    return \Firebase\JWT\JWT::encode($token,PRIVATEKEY,'RS256');
}

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

// 删除过期的token
function deleteOutTimeToken()
{
    $out = time() - 2;
    $user = \think\Db::name('user_token')->where('limit','<=',$out)->column('userID');
    foreach ($user as $key => $value)
    {
        \think\Db::name('user')->where('id',$value)->update(['isLogin'=>0]);
    }
    \think\Db::name('user_token')->where('limit','<=',$out)->delete();
}
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

define('PASSWORD_PREFIX','resource_519');
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
    openssl_private_decrypt(base64_decode($data['key']),$decryptData,PRIVATEKEY);
    $data['username'] = openssl_decrypt(base64_decode($data['username']),'AES-128-CBC',$decryptData,true,$decryptData);
    $data['password'] = md5(openssl_decrypt(base64_decode($data['password']),'AES-128-CBC',$decryptData,true,$decryptData));
    return $data;
}
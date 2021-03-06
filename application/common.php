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



define('WORKERUSER',[]);



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

# captcha
define('NULL_CAPTCHA', 40001);
define('ERROR_CAPTCHA', 40002);

define('TOKEN_ERROR',40422);
define('UNLAWFUL_ACTION',99999);



/*
 *  定义状态码对应的返回信息   PHP VERSION >= 7.0.0
 */
define('map',[
    LOGIN_SUCCESS               => '登录成功'
    ,USER_NOT_FOUND              => '用户名不存在'
    ,PASSWORD_ERROR              => '密码错误'
    ,LIMIT_LOGIN_FAIL_TIMES      => '您已累计登录失败5次,请一小时后重试'
    ,ALREADY_LOGIN               => '该用户已在其他浏览器登录'
    ,INVALID_TOKEN               => '无效的登录状态'
    ,REGISTER_USER_EXIST         => '用户名已存在'
    ,REGISTER_EMAIL_EXIST        => '邮箱已被注册'
    ,REGISTER_SUCCESS            => '注册成功'
    ,EMAIL_ERROR                 => '邮箱格式不正确'
    ,EMAIL_NOTNULL               => '邮箱不能为空'
    ,USERNAME_TOSHORT            => '用户名不能短于5个字符'
    ,USERNAME_NOTNULL            => '用户名不能为空'
    ,PASSWORD_TOSHORT            => '密码不能短于6个字符'
    ,PASSWORD_NOTNULL            => '密码不能为空'
    ,TOKEN_ERROR                 => '您的登录信息有误,请重新登录'
    ,NOTLOGIN                    => '您还未登录,请先登录'
    ,EXIT_LOGIN                  => '退出成功'
    ,TOKEN_ERROR                 => '令牌信息无效'
    ,UNLAWFUL_ACTION             => '非法操作'
    ,NULL_CAPTCHA                => '验证码不能为空'
    ,ERROR_CAPTCHA               => '验证码错误'
]);


// 定义发帖相关的状态码和提示
define('EMPTY_TITLE',40601);
define('EMPTY_CLASSIFY',40602);
define('EMPTY_CONTENT',40603);
define('POST_SUCCESS',20600);
define('POST_LIMIT',40604);
# reply
define('EMPTY_REPLY', 40099);
define('REPLY_SUCCESS', 20099);


define('addpostMap',[
    EMPTY_TITLE              => '标题不能为空'
    ,EMPTY_CLASSIFY          => '请选择分类'
    ,EMPTY_CONTENT           => '内容不能为空'
    ,POST_SUCCESS            => '发布成功，请耐心等待管理员的审核'
    ,EMPTY_CONTENT           => '回复内容不能为空'
    ,REPLY_SUCCESS           => '回复成功'
    ,POST_LIMIT              => '你已达到当前等级一小时内可发布稿件次数,详情请参考等级列表'
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



// 分类函数
function classify($arr)
{
    $maxNum = 1000;//设置最大循环次数
    $count = -1;//设置计数
    //默认根节点内容
    $root = array(
        'classifyID' => 0,
        'text' => 'root',
    );
    //辅助，主要作用用于检测节点是否存在
    //注：下面使用的技巧都是使用对象的引用，赋值的不是一个具体值，而是一个引用
    $existsMap = array(
        '0' => &$root,
    );
    //结果记录的长度
    $len = count($arr);
    //计数
    $num = 0;
    //遍历结果集
    while ($num < $len) {
        $count++;
        //如果计数器超过了最大循环次数就退出循环
        if ($count > $maxNum) break;
        $i = $count % $len;//取得下标，取莫的作用是防止下标超出边界
        $obj = $arr[$i];//取得当前节点
        if (!$obj) continue;//不存在则跳过
        $pidObj = & $existsMap[$obj['pid']];//检测辅助数组中是否有父节点数据并赋引用值给pidObj
        //     相当于  在pid为 0 的时候 ,$pidObj = & $root，此后,相当于  $pidObj = & $root[][]...[]['children'],改变的是root 的children
        if (!$pidObj) continue;     // 判断 $pidObj 是否存在 (不为空)

        //如果存在pidObj，则设置当前节点在existsMap中   将当前节点存储到 $ existsMap[]  $existsMap = array('0'=>&$root,$obj['classifyID']=>array())
        $existsMap[$obj['classifyID']] = array(
            'classifyID' => $obj['classifyID'],
            'text' => $obj['name'],
        );
        //设置子节点, 相当于  $root[][]...[]['children']
        if (!isset($pidObj['children'])) {
            $pidObj['children'] = array();
        }
        //设置子节点为刚刚存在辅助数组中得引用   将子节点的引用放入到父节点children里面,每次更改 $existsMap[]里面节点的children,都会引起$root里面的变化
        $pidObj['children'][] = & $existsMap[$obj['classifyID']];
        unset($arr[$i]);   // 删除已存在节点,避免产生额外循环代价
        $num++;
    }
    //根据自己的需求，决定是否返回root节点
    return $root['children'];

}

function send_activation_email($to, $title, $content="")
{
    $config = include 'E:/wamp64/www/resource-admin/data/conf/extra/emailconfig.php';
    if(NULL == $config) {
        return ;
    }

    if(empty($content) and empty($config['template'])) {
        return ;
    }

    $content = empty($content) ? $config['template'] : $content;

    $toemail = $to;//定义收件人的邮箱

    $mail = new \PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();// 使用SMTP服务
    $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
    $mail->Host = $config['smtp'];// 发送方的SMTP服务器地址
    $mail->SMTPAuth = true;// 是否使用身份验证
    $mail->Username = $config['username'];// 发送方的QQ邮箱用户名，就是自己的邮箱名
    $mail->Password = $config['password'];// 发送方的邮箱密码，不是登录密码,是qq的第三方授权登录码,要自己去开启,在邮箱的设置->账户->POP3/IMAP/SMTP/Exchange/CardDAV/CalDAV服务 里面
    $mail->SMTPSecure = "ssl";// 使用ssl协议方式,
    $mail->Port = $config['port'];// QQ邮箱的ssl协议方式端口号是465/587

    $mail->setFrom($config['email'],$config['from']);// 设置发件人信息，如邮件格式说明中的发件人,
    $mail->addAddress($toemail,'亲');// 设置收件人信息，如邮件格式说明中的收件人
    $mail->addReplyTo($to,"Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
    $mail->IsHTML(true); //支持html格式内容
    //$mail->addCC("xxx@163.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址(这个人也能收到邮件)
    //$mail->addBCC("pw9188@126.com");// 设置秘密抄送人(这个人也能收到邮件)
    //$mail->addAttachment("bug0.jpg");// 添加附件


    $mail->Subject = $title;// 邮件标题
    $mail->Body = $content;// 邮件正文
    //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用

    if(!$mail->send()){// 发送邮件
        echo "Message could not be sent.";
        var_dump($mail->ErrorInfo);
        return "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
    }else{
        return true;
    }
}


function move_upload_file($files)
{
    $fileNames = array();
    $data = array();
    $errors    = '';
    foreach ($files as $file)
    {
        if($file['file']){
            $info = $file['file']->validate(['size'=>$file['size'],'ext'=>$file['ext']])->move(ROOT_PATH . 'public' . DS . 'uploads/'.$file['dir']);
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                $data["{$file['dir']}"] = \think\Request::instance()->domain() . '/'. str_replace('\\','/','uploads/'.$file['dir'].'/' . $info->getSaveName());
                $fileNames[] = str_replace('\\','/',ROOT_PATH . 'public/uploads/'.$file['dir']. DS . $info->getSaveName());
            }else{
                // 上传失败获取错误信息
                $errors .= $file->getError();
            }
            unset($info);
        } else $data["{$file['dir']}"] = '';
    }

    return array('fileData'=>$data,'fileNames'=>$fileNames,'errors'=>$errors);
}

// 页面状态码
function httpStatus($num){//网页返回码
    static $http = array (
        100 => "HTTP/1.1 100 Continue",
        101 => "HTTP/1.1 101 Switching Protocols",
        200 => "HTTP/1.1 200 OK",
        201 => "HTTP/1.1 201 Created",
        202 => "HTTP/1.1 202 Accepted",
        203 => "HTTP/1.1 203 Non-Authoritative Information",
        204 => "HTTP/1.1 204 No Content",
        205 => "HTTP/1.1 205 Reset Content",
        206 => "HTTP/1.1 206 Partial Content",
        300 => "HTTP/1.1 300 Multiple Choices",
        301 => "HTTP/1.1 301 Moved Permanently",
        302 => "HTTP/1.1 302 Found",
        303 => "HTTP/1.1 303 See Other",
        304 => "HTTP/1.1 304 Not Modified",
        305 => "HTTP/1.1 305 Use Proxy",
        307 => "HTTP/1.1 307 Temporary Redirect",
        400 => "HTTP/1.1 400 Bad Request",
        401 => "HTTP/1.1 401 Unauthorized",
        402 => "HTTP/1.1 402 Payment Required",
        403 => "HTTP/1.1 403 Forbidden",
        404 => "HTTP/1.1 404 Not Found",
        405 => "HTTP/1.1 405 Method Not Allowed",
        406 => "HTTP/1.1 406 Not Acceptable",
        407 => "HTTP/1.1 407 Proxy Authentication Required",
        408 => "HTTP/1.1 408 Request Time-out",
        409 => "HTTP/1.1 409 Conflict",
        410 => "HTTP/1.1 410 Gone",
        411 => "HTTP/1.1 411 Length Required",
        412 => "HTTP/1.1 412 Precondition Failed",
        413 => "HTTP/1.1 413 Request Entity Too Large",
        414 => "HTTP/1.1 414 Request-URI Too Large",
        415 => "HTTP/1.1 415 Unsupported Media Type",
        416 => "HTTP/1.1 416 Requested range not satisfiable",
        417 => "HTTP/1.1 417 Expectation Failed",
        500 => "HTTP/1.1 500 Internal Server Error",
        501 => "HTTP/1.1 501 Not Implemented",
        502 => "HTTP/1.1 502 Bad Gateway",
        503 => "HTTP/1.1 503 Service Unavailable",
        504 => "HTTP/1.1 504 Gateway Time-out"
    );
    header($http[$num]);
    exit();
}


// 找寻最近登录本站的人
function showLastLoginUser()
{
    return \think\Db::name('user')->field('id,username,thumb,last_login_in')
                            ->order('last_login_in','desc')
                            ->limit(0,15)->select();
}
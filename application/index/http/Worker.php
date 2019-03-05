<?php
use Workerman\Worker;
use think\Session;
require_once 'E:/wamp64/www/resource/vendor/workerman/workerman/Autoloader.php';

$global_uid = 0;

$mysqli = new MySQLi('localhost','root','519478450','resource',3306);
$mysqli->set_charset("UTF8");
$result = $mysqli->query("select id,username,thumb from res_user");
while($row = $result->fetch_assoc()) {
    $users[$row['username']] = $row['thumb'];
}
$mysqli->close();
// 当客户端连上来时分配uid，并保存连接，并通知所有客户端
$global_user = array();
function handle_connection($connection)
{
    global $text_worker,$users,$global_uid,$global_user;
    $text_worker->onWebSocketConnect = function () use ($connection,$text_worker,$users,$global_uid,$global_user){
        $user = $_GET['user'];
        global $global_user,$global_uid;
        $global_user[++$global_uid] = $user;
        $connection->uid = $global_uid;
        $msg = json_encode(['img'=>$users[$user],'user'=>$user,'content'=>'连接本站','type'=>'connect']);
      foreach ($text_worker->connections as $conn)
      {

          $conn->send($msg);
      }
    };
    // 为这个连接分配一个uid
}
// 当客户端发送消息过来时，转发给所有人
function handle_message($connection, $data)
{
    global $text_worker;
    global $users;
    if (empty($data)) return ;
    foreach($text_worker->connections as $conn)
    {
        $user = json_decode($data,true);
        $msg = json_encode(['img'=>$users[$user['user']],'user'=>$user['user'],'content'=>$user['data'],'type'=>'said']);
        $conn->send($msg);
    }
}

// 当客户端断开时，广播给所有客户端
function handle_close($connection)
{
    global $text_worker,$global_user;
    $msg = json_encode(['user'=>$global_user[$connection->uid],'content'=>'离开本站','type'=>'layout']);
    foreach($text_worker->connections as $conn)
    {
        $conn->send($msg);
    }
}

// 创建一个文本协议的Worker监听2347接口
$text_worker = new Worker("http://0.0.0.0:2347");

// 只启动1个进程，这样方便客户端之间传输数据
$text_worker->count = 1;

$text_worker->onConnect = 'handle_connection';
$text_worker->onMessage = 'handle_message';
$text_worker->onClose = 'handle_close';

Worker::runAll();
?>
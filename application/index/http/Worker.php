<?php
use Workerman\Worker;
use think\Session;
require_once 'E:/wamp64/www/resource/vendor/workerman/workerman/Autoloader.php';

$global_uid = 0;

$mysqli = new MySQLi('localhost','root','519478450','resource',3306);
$mysqli->set_charset("UTF8");
$result = $mysqli->query("select id,username from res_user");
while($row = $result->fetch_assoc()) {
    $user[$row['id']] = $row['username'];
}
$mysqli->close();
// 当客户端连上来时分配uid，并保存连接，并通知所有客户端
function handle_connection($connection)
{
    global $text_worker;
    // 为这个连接分配一个uid
}
// 当客户端发送消息过来时，转发给所有人
function handle_message($connection, $data)
{
    global $text_worker;
    if (empty($data)) return ;
    foreach($text_worker->connections as $conn)
    {
        $user = json_decode($data,true);
        $conn->send("{$user['user']} said: {$user['data']}");
    }
}

// 当客户端断开时，广播给所有客户端
function handle_close($connection)
{
    global $text_worker;
    foreach($text_worker->connections as $conn)
    {
//        $conn->send("user[{$connection->uid}] logout");
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
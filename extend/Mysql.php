<?php
/**
 * Created by PhpStorm.
 * User: 欢迎
 * Date: 2018/12/29
 * Time: 14:47
 */
namespace think\session\driver;

use SessionHandler;
use think\Db;

class Mysql extends SessionHandler
{
    private $link;
    public function open($savePath, $sessionName)
    {
        $link = Db::connect();
        if($link){
            $this->link = $link;
            return true;
        }else{
            return false;
        }
    }
    public function close()
    {
        $this->link->close();
        return true;
    }
    public function read($id)
    {
        $result = $this->link->name('user_session')->where('session_id',$id)->find();
        if(!$result) return '';
        else return $result['session_data'];
    }
    public function write($id, $data)
    {
        if (!$data)
        {
            return false;
        }
        $DateTime = date('Y-m-d H:i:s');
        $NewDateTime = strtotime($DateTime . '+ 1 hour');
        $row = $this->link->name('user_session')->where('session_id',$id)->find();
        if ($row){
            $this->link->name('user_session')->where('session_id',$id)->update(['session_expires'=>$NewDateTime,'session_data'=>$data]);
            return true;
        }else{
            $this->link->insert(['session_id'=>$id,'session_data'=>$data,'session_expires'=>$NewDateTime]);
            return true;
        }
    }
    public function destroy($id)
    {
        $this->link->name('user_session')->where('session_id',$id)->delete();
        return true;
    }
    public function gc($sessMaxLifeTime)
    {
        $this->link->name('user_session')->where('session_expires','<',time())->delete();
        return true;
    }
}
?>
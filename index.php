<?php 
/** 
*入口文件
* @author   AndyYang 
* @more     www.webyang.net
 */ 

error_reporting(E_ALL ^ E_NOTICE);

include_once "./action/PacketClass.php";
$packet = new PacketClass();

$openid = $packet->_route('userinfo');
if($openid) {
    $status = $packet->_route('wxpacket',$openid);
    echo $status == 'SUCCESS' ? 'send packet success!' : 'send packet fail!';
}

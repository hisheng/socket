<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 2017/10/26
 * Time: 10:15
 */
//参考 http://www.cnblogs.com/loveyoume/p/6076101.html
//http://blog.csdn.net/zhoujn90/article/details/44955137
//swoole websocket 服务器

//创建服务端的socket套接流,net协议为IPv4，protocol协议为TCP
$server = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

/*绑定接收的套接流主机和端口,与客户端相对应*/
socket_bind($server,'127.0.0.1',9933);

//监听套接流,同时处理 4个，超出的放队列
socket_listen($server,4);

var_dump($server);




do{
    /*接收客户端传过来的信息*/
    $accept_resource = socket_accept($server);
    
    if($accept_resource)
    {
        /*读取客户端传过来的资源类型，并转化为字符串*/
        $string = socket_read($accept_resource,1024);
        echo 'server receive is :'.$string.PHP_EOL;//PHP_EOL为php的换行预定义常量
    
        if($string){
            $return_message = 'server receive is : '.$string.PHP_EOL;
            /*向socket_accept的套接流写入信息，也就是回馈信息给socket_bind()所绑定的主机客户端*/
            socket_write($accept_resource,$return_message,strlen($return_message));
            /*socket_write的作用是向socket_create的套接流写入信息，或者向socket_accept的套接流写入信息*/
        }else{
            echo 'socket_read is fail';
        }
    
        socket_close($accept_resource);
        
    }
    
}while(true);





socket_close($server);

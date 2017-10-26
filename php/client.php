<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 2017/10/26
 * Time: 10:51
 */

//创建一个socket套接流
$client = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

//连接服务端的套接流，这一步就是使客户端与服务器端的套接流建立联系
if(socket_connect($client,'127.0.0.1',9933)){
    $message = 'l love you 我爱你 socket';
    //向服务端写入字符串信息
    if(socket_write($client,$message,strlen($message)))
    {
        echo 'client write success'.PHP_EOL;
        while($callback = socket_read($client,1024)){
            echo 'server return message is:'.PHP_EOL.$callback;
        }
    }else{
        echo 'fail to write'.socket_strerror(socket_last_error());
    }
}

socket_close($client);//工作完毕，关闭套接流
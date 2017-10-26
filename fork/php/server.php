<?php

/*created by PhpStorm.
 * User: work
 * Date: 2017/10/26
 * Time: 15:20
 */
//可以用 ps aux \ grep  server.php 查看进程状况


$pid = posix_getpid(); //取得主进程
$user = posix_getlogin() ; //取得用户名

echo  "master pid : {$pid}";

while (true){
    $prompt = "\n{$user} : ";
    $input = readline($prompt);
    
    readline_add_history($input);
    if($input == 'quit'){
        break;
    }
    
    if($input == 'start'){
        echo " -- start --";
    }
    process_execute($input . ';');
    echo 'master';
    
}

exit(0);



function process_execute($input){
    $pid = pcntl_fork(); //创建子进程
    if($pid == 0){//子进程
        sleep(1);
        $pid = posix_getpid();
        $ppid = posix_getppid();
        echo "* child {$pid} was created ,master pid is {$ppid}\n\n";
        echo $input ; //解析命令
        exit;//子进程 任务结束就 退出
    }else{//主进程
        $pid = pcntl_wait($status, WUNTRACED); //取得子进程结束状态
        if (pcntl_wifexited($status)) {
            echo "\n\n* child process: {$pid} exited with {$status} :\n";
        }
    }
}

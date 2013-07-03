<?php

// 接受客户端请求，回复固定的响应内容
function server_listen_socket ($address, $port)
{
    $buffer = "Msg from wangzhengyi server, so kubi...";
    $len = strlen($buffer);
    
    // create, bind and listen to socket
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if (! $socket) {
        echo "failed to create socket:" . socket_strerror($socket) . "\n";
        exit();
    }
    
    $bind_flag = socket_bind($socket, $address, $port);
    if (! $bind_flag) {
        echo "failed to bind socket:" . socket_strerror($bind_flag) . "\n";
        exit();
    }
    
    $backlog = 20;
    $listen_flag = socket_listen($socket, $backlog);
    if (! $listen_flag) {
        echo "failed to listen to socket:" . socket_strerror($listen_flag) . "\n";
        exit();
    }
    
    echo "waiting for clients to connect\n";
    
    while (1) {
        if (($accept_socket = socket_accept($socket)) == FALSE) {
            continue;
        } else {
            socket_write($accept_socket, $buffer, $len);
            socket_close($accept_socket);
        }
    }
}

function run_server ()
{
    $pid1 = pcntl_fork();
    if ($pid1 == 0) {
        // first child process
        
        // 守护进程的一般流程：fork()->setsid()->fork()
        posix_setsid();
        
        if (($pid2 = pcntl_fork()) == 0) {
            $address = "192.168.1.71";
            $port = "8767";
            server_listen_socket($address, $port);
        } else {
            // 防止获得控制终端
            exit();
        }
    } else {
        // wait for first child process exit
        pcntl_wait($status);
    }
}

// server守护进程
run_server();
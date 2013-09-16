<?php

/**
 * 测试&&使用一致性哈希类
 */

function __autoload($strClassName)
{
    require_once './'.str_replace('_', '/', $strClassName).'.php';
}


// redis集群ip
$targets = array(
        '192.168.1.1',
        '192.168.1.2',
        '192.168.1.3',
        '192.168.1.4',
        '127.0.0.1',
);

// 虚拟节点数(防止数据倾斜)
$replicates = 10;

// 存储资源（假设为sql查询结果）
$resource1 = 'sql查询结果1';
$resource2 = 'sql查询结果2';

// 实例化哈希类，获取需要操作的服务器ip
__autoload('ConsistentHash');
$instance = new ConsistentHash($replicates);

// 增加目标服务器
$instance->addTargets($targets);

// 删除指定服务器
$instance->removeTarget('127.0.0.1');

// 获取当前的已经分布的服务器ip
$array = $instance->getAllTargets();

// 获取需要处理资源的服务器ip
$target1 = $instance->lookupList($resource1, 1);

// TODO:进行数据库链接，然后是增删改查等操作
print_r($target1);

$target2 = $instance->lookupList($resource2, 1);

// TODO:进行数据库链接，然后是增删改查等操作
print_r($target2);
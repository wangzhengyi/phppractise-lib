<?php


/**
 * 获取重复次数最多的身份证号码
 * 
 * @param array $unsort_cards            
 */
function getTenCards ($unsort_cards)
{
    // 取前10个出现次数最多的身份证号码
    krsort($unsort_cards, SORT_NUMERIC);
    
    // 打印前10的身份证号码
    $i = 0;
    foreach ($unsort_cards as $key => $value) {
        echo $key . "\n";
        $i ++;
        if ($i == 10)
            break;
    }
}

/**
 * 读取身份证文件
 *
 * @param string $filename            
 */
function readCardFile ($filename)
{
    $unsort_cards = array();
    
    $fd = fopen($filename, 'r');
    
    while (! feof($fd)) {
        $card = fgets($fd);
        $card = trim($card);
        if (isset($unsort_cards[$card])) {
            $unsort_cards[$card] += 1;
        } else {
            $unsort_cards[$card] = 1;
        }
    }
    
    fclose($fd);
    
    getTenCards($unsort_cards);
}

$filename = "card.txt";

readCardFile($filename);

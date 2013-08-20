<?php

/**
 * 顺序查找
 */
function seqSearch ($arr, $needle)
{
    for ($i = 0, $len = count($arr); $i < $len; $i ++) {
        if ($arr[$i] == $needle) {
            return $i;
        }
    }
    return - 1;
}

/**
 * 二分查找
 */
function midSearch ($arr, $start, $end, $needle)
{
    while ($start <= $end) {
        $mid = (int)($start + ($end - $start) / 2); // 防止超出整数表示范围
        
        if ($arr[$mid] == $needle) {
            return $mid;
        } else if ($arr[$mid] > $needle) {
            $end = $mid - 1;
        } else {
            $start = $mid + 1;
        }
    }
    
    return - 1;
}

$arr = array(
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9,
        10
);

$needle = 5;

echo seqSearch($arr, $needle);
echo "<br>";

echo midSearch($arr, 0, count($arr) - 1, $needle);
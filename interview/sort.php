<?php

/**
 * 冒泡排序算法实现(从小到大)
 */
function maopaoSort (&$array)
{
    $count = count($array);
    
    for ($i = 0; $i < $count - 1; $i ++) {
        for ($j = 0; $j < $count - $i - 1; $j ++) {
            if ($array[$j] > $array[$j + 1]) {
                $tmp = $array[$j];
                $array[$j] = $array[$j + 1];
                $array[$j + 1] = $tmp;
            }
        }
    }
}

/**
 * 快速排序
 */
function pivotParation (&$array, $start, $end)
{
    $stand = $array[$start];
    
    while ($start < $end) {
        while ($start < $end && $array[$end] >= $stand) {
            $end --;
        }
        if ($start < $end) {
            $array[$start ++] = $array[$end];
        }
        
        while ($start < $end && $array[$start] <= $stand) {
            $start ++;
        }
        if ($start < $end) {
            $array[$end --] = $array[$start];
        }
    }
    
    $array[$start] = $stand;
    
    return $start;
}

function quickSort (&$array, $begin, $end)
{
    if ($begin < $end) {
        $pivot = pivotParation($array, $begin, $end);
        quickSort($array, $begin, $pivot - 1);
        quickSort($array, $pivot + 1, $end);
    }
}

$arr = array(
        5,
        1,
        3,
        2,
        19,
        11,
        25,
        12,
        100,
        10000,
        12
);

// 冒泡排序
maopaoSort($arr);
print_r($arr);
echo "<br>";

// 快速排序
$count = count($arr);
quickSort($arr, 0, $count - 1);
print_r($arr);
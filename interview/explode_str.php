<?php

/**
 * 每隔3个字符，用逗号进行分隔
 * @param string $str
 * @return string
 */
function splitStrWithComma ($str)
{
    $arr = array();
    $len = strlen($str);
    
    for ($i = $len - 1; $i >= 0;) {
        $new_str = "";
        for ($j = $i; $j > $i - 3 && $j >= 0; $j --) {
            $new_str .= $str[$j];
        }
        $arr[] = $new_str;
        $i = $j;
    }
    
    $string = implode(',', $arr);
    
    // 翻转字符串自己实现
    // $string = strrev($string);
    for ($i = 0, $j = strlen($string) - 1; $i <= $j; $i ++, $j --) {
        $tmp = $string[$i];
        $string[$i] = $string[$j];
        $string[$j] = $tmp;
    }
    
    return $string;
}

$str = "1234567890";
$new_str = splitStrWithComma($str);
echo $new_str . "\n";
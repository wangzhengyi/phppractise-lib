<?php

function strReverse(&$str)
{
    for ($i = 0, $j = strlen($str); $i <= $j; $i ++, $j --) {
        $tmp = $str[$i];
        $str[$i] = $str[$j];
        $str[$j] = $tmp;
    }
}

$str = "wangzhengyi";
strReverse($str);
echo $str;



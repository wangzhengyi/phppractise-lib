<?php

/**
 * 求两个日期之间相差的天数(针对1970年1月1日之后，求之前可以采用泰勒公式)
 * @param string $day1
 * @param string $day2
 * @return number
 */
function diffBetweenTwoDays ($day1, $day2)
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);
    
    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    
    return ($second1 - $second2) / 86400;
}

$day1 = "2013-07-27";
$day2 = "2013-08-04";

$diff = diffBetweenTwoDays($day1, $day2);
echo $diff."\n";
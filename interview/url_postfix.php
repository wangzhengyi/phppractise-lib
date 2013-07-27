<?php

/**
 * 给定url，获取文件后缀
 * @param string $url
 * @return string
 */
function getUrlPostfix ($url)
{
    $url_arr = explode('.', $url);
    $postfix = $url_arr[count($url_arr) - 1];
    
    $substr = substr($postfix, 0, 3);
    return $substr;
}

$url = "http://www.feiyan.info/test.php?c=class&m=method";
$str = getUrlPostfix($url);
echo $str . "\n";
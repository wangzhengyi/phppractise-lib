<?php
/**
 * 五种方式获取指定路径的文件扩展名
 */

$str = "dir/upload.image.jpg";

function one ($str)
{
    $arr = explode('.', $str);
    $count = count($arr);
    
    return $arr[$count - 1];
}

function two ($str)
{
    $len = strlen($str);
    
    for ($i = $len - 1, $name = ''; $str[$i] != '.'; $i --) {
        $name .= $str[$i];
    }
    $name = strrev($name);
    
    return $name;
}

function three($str)
{
    $path = pathinfo($str);
    
    return $path['extension'];
} 

function four($str)
{
    $arr = explode('.', $str);
    
    return array_pop($arr);
}

function five($str)
{
    $start = strrpos($str, '.');
    
    return substr($str, $start + 1);
}

echo one($str);
echo "<br>";

echo two($str);
echo "<br>";

echo three($str);
echo "<br>";

echo four($str);
echo "<br>";

echo five($str);
echo "<br>";
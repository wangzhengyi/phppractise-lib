<?php

/**
 * 求$b相对于$a的相对路径
 * @param string $a
 * @param string $b
 * @return string
 */
function getRelativePath ($a, $b)
{
    $patha = explode('/', $a);
    $pathb = explode('/', $b);
    
    $counta = count($patha) - 1;
    $countb = count($pathb) - 1;
    
    $path = "../";
    if ($countb > $counta) {
        while ($countb > $counta) {
            $path .= "../";
            $countb --;
        }
    }
    
    // 寻找第一个公共结点
    for ($i = $countb - 1; $i >= 0;) {
        if ($patha[$i] != $pathb[$i]) {
            $path .= "../";
            $i --;
        } else { // 判断是否为真正的第一个公共结点，防止出现子目录重名情况
            for ($j = $i - 1, $flag = 1; $j >= 0; $j --) {
                if ($patha[$j] == $pathb[$j]) {
                    continue;
                } else {
                    $flag = 0;
                    break;
                }
            }
            
            if ($flag)
                break;
            else
                $i ++;
        }
    }
    
    for ($i += 1; $i <= $counta; $i ++) {
        $path .= $patha[$i] . "/";
    }
    
    return $path;
}

$a = "/a/c/d/e.php";
$b = "/a/c.php";

$path = getRelativePath($a, $b);
echo $path;

<?php

class TestStatic
{
    public static $c;
    
    
    public function __construct(){
    }
}


$a = new TestStatic();

$b = new TestStatic();

$b->c = 10;

echo $a->c;

?>
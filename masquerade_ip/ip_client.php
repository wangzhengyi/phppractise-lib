<?php
require_once dirname(__FILE__) . "/iplib.php";

$req_url = "http://www.xfcbbs.com/?fromuid=79647";

foreach ($iparr as $forward => $cip) {
    
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $req_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "X-FORWARDED-FOR:$forward",
            "CLIENT-IP:$cip"
    ));
    curl_setopt($ch, CURLOPT_REFERER, 'http://blog.csdn.net/');
    curl_setopt($ch, CURLOPT_HEADER, 1);
    
    curl_exec($ch);
    
    curl_close($ch);
}
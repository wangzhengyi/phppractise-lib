<?php
function curl_vimscheme($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_TRANSFERTEXT, 1);
    $data = curl_exec($url);
    curl_close($curl);
    
    var_dump($data);
}

$url = "http://vimcolorschemetest.googlecode.com/svn/colors/256-jungle.vim";

curl_vimscheme($url);
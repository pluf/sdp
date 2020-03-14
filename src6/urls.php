<?php
$paths = array_filter(glob(__DIR__ . '/urls/*.php'), function($file){
    return is_file($file);
});

$sdpApi = array();

foreach ($paths as $path){
    $myApi = include $path;
    $sdpApi = array_merge($sdpApi, $myApi);
}

return $sdpApi;

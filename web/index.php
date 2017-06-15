<?php

//function microtime_float()
//{
//    list($usec, $sec) = explode(" ", microtime());
//    return ((float)$usec + (float)$sec);
//}
//
//
//$time_start = microtime_float();
//$before = memory_get_usage();

$app = require_once __DIR__.'/../src/app.php';
require_once __DIR__.'/../src/routing.php';

// start
$app->run();


//$after = memory_get_usage();
//$time_end = microtime_float();
//$time = $time_end - $time_start;
//
//echo "<!--Memory usage = ".number_format(ceil(($after - $before)/1000), 0, ',', '.')."kb (".number_format(($after - $before), 0, ',', '.')." bytes) and it took $time seconds to load data-->;";

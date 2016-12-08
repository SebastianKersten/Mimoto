<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';


// init
$app = new \Silex\Application();
$config = require_once(dirname(__FILE__).'/config.php');

// setup
$loader = new \Twig_Loader_Filesystem([__DIR__ . '/../src/userinterface']);
$twig = new Twig_Environment($loader, array(
    // 'cache' => '../app/cache',
));


// connect
$GLOBALS['database'] = new PDO("mysql:host=".$config->mysql->host.";dbname=".$config->mysql->dbname, $config->mysql->username, $config->mysql->password);

// setup
$app['debug'] = true;
$app['twig'] = $twig;
$app['Mimoto'] = new \Mimoto\Mimoto($app);


function output($sTitle, $data, $bScream = false)
{
    // style
    $sTextColor = ($bScream) ? '#ff0000' : '#06afea';
    $sBorderColor = ($bScream) ? '#ff0000' : '#858585';
    $sBackgroundColor = ($bScream) ? '#ffbbbb' : '#f5f5f5';

    echo '<div style="background-color:'.$sBackgroundColor.';border:solid 1px '.$sBorderColor.';padding:20px">';
    echo '<h2><b style="color:'.$sTextColor.'">'.$sTitle.'</b></h2><hr>';
    echo '<pre style="width:100%">';
    print_r($data);
    echo '</pre>';
    echo '</div>';
    echo '<br>';
}

function error($data, $bDumpVar = false)
{
    echo '<div style="background-color:#DF5B57;color:#ffffff;padding:15px 20px 0 20px; width:100%;">';
    echo '<div>';
    echo '<h2><b style="font-size:larger;">Error</b></h2><hr style="border:0;height:1px;background:#ffffff">';
    echo '<pre style="overflow:scroll">';
    ($bDumpVar) ? var_dump($data) : print_r($data);
    echo '</pre>';
    echo '</div>';
    echo '<br>';
    die();
}

return $app;

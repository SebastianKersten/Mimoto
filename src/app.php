<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';


// init
$app = new \Silex\Application();

// setup
$loader = new \Twig_Loader_Filesystem([__DIR__ . '/../src/userinterface']);
$twig = new Twig_Environment($loader, array(
    // 'cache' => '../app/cache',
));


// connect
$GLOBALS['database'] = new PDO("mysql:host=127.0.0.1;dbname=mimoto.cms", 'root', '');

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
    echo '<div style="background-color:#f3f3f3;border:solid 1px #cccccc;padding:0 20px 20px 20px">';
    echo '<div style="display:inline-block;position:relative;">';
    echo '<h2><b style="color:#ff66cc;padding:0 20px 0 0;">Error</b></h2><hr>';
    echo '<pre style="width:100%">';
    ($bDumpVar) ? var_dump($data) : print_r($data);
    echo '</pre>';
    echo '</div>';
    echo '<br>';
    die();
}

return $app;

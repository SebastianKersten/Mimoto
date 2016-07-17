<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

// Mimoto classes
use Mimoto\Event\MimotoEventServiceProvider;
use Mimoto\Aimless\MimotoAimlessServiceProvider;
use Mimoto\Data\MimotoEntityServiceProvider;
use Mimoto\Cache\MimotoCacheServiceProvider;


// init
$app = new \Silex\Application();

// setup
$loader = new \Twig_Loader_Filesystem(
    [
        __DIR__ . '/../src/userinterface/templates'//,
        //__DIR__.'/../src/Mimoto/userinterface/templates'
    ]
);
$twig = new Twig_Environment($loader, array(
    // 'cache' => '../app/cache',
));


// connect
$link = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('maidoprojects') or die('Could not select database');

$pdo = new PDO("mysql:host=127.0.0.1;dbname=maidoprojects", 'root', '');


// ... definitions
$app['debug'] = true;
$app['twig'] = $twig;
//$app['Mimoto'] = new Mimoto();

// setup entities - #todo - combine all in MimotoProvider
$app->register(new MimotoCacheServiceProvider());
$app->register(new MimotoEntityServiceProvider());
$app->register(new MimotoAimlessServiceProvider());
$app->register(new MimotoEventServiceProvider());


function output($sTitle, $data)
{
    echo '<div style="background-color:#f5f5f5;border:solid 1px #858585;padding:0 20px 20px 20px">';
    echo '<h2><b style="color:#06afea">'.$sTitle.'</b></h2><hr>';
    echo '<pre style="width:100%">';
    print_r($data);
    echo '</pre>';
    echo '</div>';
    echo '<br>';
}

function error($sMessage)
{
    echo '<div style="background-color:#f3f3f3;border:solid 1px #cccccc;padding:0 20px 20px 20px">';
    echo '<div style="display:inline-block;position:relative;margin-right:20px;width:220px;height:50px;overflow:hidden;background-image:url(http://mimoto.nl/Mimoto.Applications/Website/img/985c78e82ddadbb8b1197a78d89ca537.png);"></div>';
    echo '<div style="display:inline-block;position:relative;">';
    echo '<h2><b style="color:#ff66cc;padding:0 20px 0 0;">Error</b></h2><hr>';
    echo $sMessage;
    echo '</div>';
    echo '<br>';
    die();
}

return $app;
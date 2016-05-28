<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

// Mimoto classes
use Mimoto\Event\MimotoEventServiceProvider;
use Mimoto\Aimless\MimotoAimlessServiceProvider;
use Mimoto\Data\MimotoEntityServiceProvider;


// init
$app = new \Silex\Application();

// setup
$loader = new \Twig_Loader_Filesystem(
    [
        __DIR__.'/../src/MaidoProjects/userinterface/templates',
        __DIR__.'/../src/Mimoto/userinterface/templates'
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


// setup entities - #todo - combine all in MimotoProvider
$app->register(new MimotoEntityServiceProvider());
$app->register(new MimotoAimlessServiceProvider());
$app->register(new MimotoEventServiceProvider());



return $app;
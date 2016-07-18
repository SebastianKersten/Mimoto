<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';


// init
$app = new \Silex\Application();

// setup
$loader = new \Twig_Loader_Filesystem([__DIR__ . '/../src/userinterface/templates']);
$twig = new Twig_Environment($loader, array(
    // 'cache' => '../app/cache',
));


// connect
$GLOBALS['database'] = new PDO("mysql:host=127.0.0.1;dbname=maidoprojects", 'root', '');

// setup
$app['debug'] = true;
$app['twig'] = $twig;
$app['Mimoto'] = new \Mimoto\CMS\Mimoto($app);


return $app;
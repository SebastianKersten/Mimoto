<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';


// Mimoto classes
use Mimoto\Mimoto;

// configure
Mimoto::setValue('config', include(dirname(__FILE__).'/config.php'));
Mimoto::setValue('ProjectConfig.root', __DIR__ . '/../');
Mimoto::setValue('ProjectConfig.twigroot', 'src/userinterface/');


// init
$app = new \Silex\Application();



// setup
$loader = new \Twig_Loader_Filesystem([Mimoto::value('ProjectConfig.root').Mimoto::value('ProjectConfig.twigroot')]);
$twig = new Twig_Environment($loader, array(
    // 'cache' => '../app/cache',
    'autoescape' => false
));



// connect
Mimoto::setService('database', new PDO("mysql:host=".Mimoto::value('config')->mysql->host.";dbname=".Mimoto::value('config')->mysql->dbname, Mimoto::value('config')->mysql->username, Mimoto::value('config')->mysql->password));
Mimoto::setService('twig', $twig);

// configure
Mimoto::setValue('page.layout.default', 'MimotoCMS_layout_Page');
Mimoto::setValue('popup.layout.default', 'MimotoCMS_layout_Popup'); // uit general 'layouts' sectie

// configure Pusher
Mimoto::setGlobalValue('pusher.auth_key', Mimoto::value('config')->pusher->auth_key);
Mimoto::setGlobalValue('pusher.cluster', Mimoto::value('config')->pusher->cluster);
Mimoto::setGlobalValue('pusher.host', Mimoto::value('config')->pusher->host);
Mimoto::setGlobalValue('pusher.encrypted', Mimoto::value('config')->pusher->encrypted);
Mimoto::setGlobalValue('pusher.authEndpoint', Mimoto::value('config')->pusher->authEndPoint);

//Mimoto::registerService('mail');

// setup
$app['debug'] = true;
$app['twig'] = $twig;
$app['Mimoto'] = new \Mimoto\Mimoto($app, false);

// run in debgu mode
Mimoto::runInDebugMode(true);

// send
return $app;

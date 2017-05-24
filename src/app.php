<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';


// Mimoto classes
use Mimoto\Mimoto;


$config = @include(dirname(__FILE__) . '/config.php');

if (!$config)
{
    echo "
    <h1>Installling Mimoto</h1>
    <ol>
        <li>Make a copy of `config.php.bak` and name it `config.php`</li>
        <li>Add your MySQL credentials to your `config.php`</li>
        <li>Import the database dump in `/database` in your MySQL</li>
        <li>Add at least 1 user to the `_Mimoto_user` table</li>
    </ol>";
    die();
}

// configure
Mimoto::setValue('config', $config);
Mimoto::setValue('ProjectConfig.root', __DIR__ . '/../');
Mimoto::setValue('ProjectConfig.twigroot', 'src/userinterface/');


// init
$app = new \Silex\Application();



// setup
$loader = new \Twig_Loader_Filesystem([Mimoto::value('ProjectConfig.root').Mimoto::value('ProjectConfig.twigroot')]);
$twig = new Twig_Environment($loader, array(
    //'cache' => '../twigcache',
    'autoescape' => false
));



// connect
Mimoto::setService('database', new PDO("mysql:host=".Mimoto::value('config')->mysql->host.";dbname=".Mimoto::value('config')->mysql->dbname, Mimoto::value('config')->mysql->username, Mimoto::value('config')->mysql->password));
Mimoto::setService('twig', $twig);

// configure
Mimoto::setValue('page.layout.default', 'MimotoCMS_layout_Page');
Mimoto::setValue('popup.layout.default', 'MimotoCMS_layout_Popup'); // uit general 'layouts' sectie


//Mimoto::registerService('mail');


// temp solution
Mimoto::setGlobalValue('app', $app);


// setup
$app['debug'] = true;
$app['twig'] = $twig;
$app['Mimoto'] = new \Mimoto\Mimoto($app, false);


// run in debug mode
Mimoto::runInDebugMode(true);
//Mimoto::enableCache(true);

// send
return $app;

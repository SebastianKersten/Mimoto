<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';


// Mimoto classes
use Mimoto\Mimoto;


$sConfigFile = dirname(__FILE__) . '/config.php';
if (file_exists($sConfigFile))
{
    $config = include($sConfigFile);
}
else
{
    echo "
    <h1>Installing Mimoto (step 1 / 2)</h1>
    <ol>
        <li>Make a copy of `config.php.dist` and name it `config.php`</li>
        <li>Add your MySQL credentials to your `config.php`</li>
        <li>Import the database dump in `/database` in your MySQL</li>
    </ol>";
    die();
}

// configure
Mimoto::setValue('config', $config);
Mimoto::setValue('ProjectConfig.root', __DIR__ . '/../');
Mimoto::setValue('ProjectConfig.twigroot', 'src/userinterface/');
Mimoto::setValue('ProjectConfig.serviceroot', 'src/services/');


// init
$app = new \Silex\Application();


// setup
$loader = new \Twig_Loader_Filesystem([Mimoto::value('ProjectConfig.root').Mimoto::value('ProjectConfig.twigroot')]);
$twig = new Twig_Environment($loader, array(
    //'cache' => '../twigcache',
    'autoescape' => false,
    'strict_variables' => true,
));


// https://silex.sensiolabs.org/doc/1.3/providers/translation.html

//$app->register(new Silex\Provider\TranslationServiceProvider(), array(
//    'locale_fallbacks' => array('en'),
//));
//
//use Symfony\Component\Translation\Loader\YamlFileLoader;
//
//$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
//    $translator->addLoader('yaml', new YamlFileLoader());
//
//    $translator->addResource('yaml', __DIR__.'/locales/en.yml', 'en');
//    $translator->addResource('yaml', __DIR__.'/locales/nl.yml', 'nl');
//
//    return $translator;
//}));


// connect
Mimoto::setService('database', new PDO("mysql:host=".Mimoto::value('config')->mysql->host.";dbname=".Mimoto::value('config')->mysql->dbname, Mimoto::value('config')->mysql->username, Mimoto::value('config')->mysql->password));
Mimoto::setService('twig', $twig);



//Mimoto::registerService('mail');


// setup
$app['debug'] = true;
$app['twig'] = $twig;
$app['Mimoto'] = new \Mimoto\Mimoto($app, false);


// run in debug mode
Mimoto::runInDebugMode(true);
//Mimoto::enableCache(true);

// send
return $app;

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



$aViewModels = array(
    'client' => array(
        'ClientListItem' => 'pages/settings/clients/ClientListItem.twig'
    ),
    'agency' => array(
        'AgencyListItem' => 'pages/settings/agencies/AgencyListItem.twig'
    ),
    'projectmanager' => array(
        'ProjectManagerListItem' => 'pages/settings/projectmanagers/ProjectManagerListItem.twig'
    ),
    'subprojectstate' => array(
        'SubprojectStateListItem' => 'pages/settings/subprojectstates/SubprojectStateListItem.twig'
    ),
    'project' => array(
        'ProjectListItem' => 'pages/projects/components/Project.twig'
    )
);



// setup entities
$app->register(new MimotoEntityServiceProvider());
$app->register(new MimotoEventServiceProvider());
$app->register(new MimotoAimlessServiceProvider($aViewModels));


return $app;
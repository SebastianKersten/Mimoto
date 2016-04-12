<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

// Entity configurations
use MaidoProjects\Config\entities\ClientEntityConfig;
use MaidoProjects\Config\entities\AgencyEntityConfig;
use MaidoProjects\Config\entities\ProjectManagerEntityConfig;
use MaidoProjects\Config\entities\ProjectEntityConfig;
use MaidoProjects\Config\entities\SubprojectEntityConfig;
use MaidoProjects\Config\entities\SubprojectStateEntityConfig;

// Mimoto classes
use Mimoto\Event\MimotoEventServiceProvider;
use Mimoto\LiveScreen\MimotoLiveScreenServiceProvider;
use Mimoto\Data\MimotoEntityServiceProvider;
use Mimoto\Config\MimotoEntityConfigServiceProvider;


// init
$app = new \Silex\Application();

// setup
$loader = new \Twig_Loader_Filesystem([__DIR__.'/../src/MaidoProjects/userinterface/templates']);
$twig = new Twig_Environment($loader, array(
    // 'cache' => '../app/cache',
));

// connect
$link = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('maidoprojects') or die('Could not select database');


// ... definitions
$app['debug'] = true;
$app['twig'] = $twig;



// setup entities
$app->register(new MimotoEntityServiceProvider
(
    [
        new ClientEntityConfig(),
        new AgencyEntityConfig(),
        new ProjectManagerEntityConfig(),
        new ProjectEntityConfig(),
        new SubprojectEntityConfig(),
        new SubprojectStateEntityConfig()
    ]
));
$app->register(new MimotoEntityConfigServiceProvider());
$app->register(new MimotoEventServiceProvider());
$app->register(new MimotoLiveScreenServiceProvider // configure ViewModels
(
    [
        'client' => (object) array(
            'service' => 'ClientService',
            'method' => 'getClientById',
            'templates' => array(
                'ClientListItem' => 'pages/settings/clients/ClientListItem.twig'
            )
        ),
        'agency' => (object) array(
            'service' => 'AgencyService',
            'method' => 'getAgencyById',
            'templates' => array(
                'AgencyListItem' => 'pages/settings/agencies/AgencyListItem.twig'
            )
        ),
        'projectmanager' => (object) array(
            'service' => 'ProjectManagerService',
            'method' => 'getProjectManagerById',
            'templates' => array(
                'ProjectManagerListItem' => 'pages/settings/projectmanagers/ProjectManagerListItem.twig'
            )
        ),
        'subprojectstate' => (object) array(
            'service' => 'SubprojectService',
            'method' => 'getSubprojectStateById',
            'templates' => array(
                'SubprojectStateListItem' => 'pages/settings/subprojectstates/SubprojectStateListItem.twig'
            )
        ),
        'project' => (object) array(
            'service' => 'ProjectService',
            'method' => 'getProjectById',
            'templates' => array(
                'Project' => 'pages/projects/components/Project.twig'
            )
        )
    ]
 ));

return $app;
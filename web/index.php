<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

// Momkai classes
use MaidoProjects\Project\ProjectServiceProvider;
use MaidoProjects\Subproject\SubprojectStateEvent;
use MaidoProjects\Subproject\SubprojectServiceProvider;
use MaidoProjects\ProjectManager\ProjectManagerEvent;
use MaidoProjects\ProjectManager\ProjectManagerServiceProvider;
use MaidoProjects\Client\ClientEvent;
use MaidoProjects\Client\ClientServiceProvider;
use MaidoProjects\Agency\AgencyEvent;
use MaidoProjects\Agency\AgencyServiceProvider;

// Mimoto classes
use Mimoto\Event\MimotoEventServiceProvider;
use Mimoto\Livescreen\MimotoLivescreenServiceProvider;


// init
$app = new \Silex\Application();

// setup
$loader = new \Twig_Loader_Filesystem(['../src/MaidoProjects/userinterface/templates']);
$twig = new Twig_Environment($loader, array(
    // 'cache' => '../app/cache',
));

// connect
$link = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('maidoprojects') or die('Could not select database');


// ... definitions
$app['debug'] = true;
$app['twig'] = $twig;


// connect project services
$app->register(new ProjectServiceProvider());
$app->register(new SubprojectServiceProvider());
$app->register(new ProjectManagerServiceProvider());
$app->register(new ClientServiceProvider());
$app->register(new AgencyServiceProvider());

// connect platform services
$app->register(new MimotoEventServiceProvider());
$app->register(new MimotoLivescreenServiceProvider
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
        )
    ]
 ));

//->value('pageName', 'index');

// hoe juiste template ophalen? In repository? ViewService model/twig
// dedicated twigs extenden de base twig
// component en values werken fundamenteel anders


// main pages
$app->get('/', 'MaidoProjects\\UserInterface\\ProjectsController::getProjectOverview');
$app->get('/prognose', 'MaidoProjects\\UserInterface\\ForecastController::getIndex');
$app->get('/resultaat', 'MaidoProjects\\UserInterface\\ResultController::getIndex');

// projects
$app->get('/project/new', 'MaidoProjects\\UserInterface\\ProjectsController::formProject');
$app->get('/project/change/{nId}', 'MaidoProjects\\UserInterface\\ProjectsController::formProject');
$app->post('/project/save', 'MaidoProjects\\UserInterface\\ProjectsController::saveProject');

// subprojects
$app->get('/project/{nProjectId}/subproject/new', 'MaidoProjects\\UserInterface\\ProjectsController::formSubproject');
$app->get('/subproject/change/{nId}', 'MaidoProjects\\UserInterface\\ProjectsController::formSubproject');
$app->post('/subproject/save', 'MaidoProjects\\UserInterface\\ProjectsController::saveSubproject');

// settings
$app->get('/settings', 'MaidoProjects\\UserInterface\\SettingsController::getSettingsOverview');

// settings/projectmanagers
$app->get('/settings/projectmanagers', 'MaidoProjects\\UserInterface\\SettingsController::getProjectManagerOverview');
$app->get('/settings/projectmanager/new', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->get('/settings/projectmanager/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->post('/settings/projectmanager/save', 'MaidoProjects\\UserInterface\\SettingsController::saveProjectManager');

// settings/clients
$app->get('/settings/clients', 'MaidoProjects\\UserInterface\\SettingsController::getClientOverview');
$app->get('/settings/client/new', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->get('/settings/client/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->post('/settings/client/save', 'MaidoProjects\\UserInterface\\SettingsController::saveClient');

// settings/agencies
$app->get('/settings/agencies', 'MaidoProjects\\UserInterface\\SettingsController::getAgencyOverview');
$app->get('/settings/agency/new', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->get('/settings/agency/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->post('/settings/agency/save', 'MaidoProjects\\UserInterface\\SettingsController::saveAgency');

// settings/subprojectstates
$app->get('/settings/subprojectstates', 'MaidoProjects\\UserInterface\\SettingsController::getSubprojectStatesOverview');
$app->get('/settings/subprojectstate/new', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->get('/settings/subprojectstate/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->post('/settings/subprojectstate/save', 'MaidoProjects\\UserInterface\\SettingsController::saveSubprojectState');

// CTFO
$app->get('/ctfo', 'MaidoProjects\\UserInterface\\CTFOController::analyzeBuckaroo');


// start
$app->run();


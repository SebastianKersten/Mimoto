<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

// Momkai classes
use MaidoProjects\Project\ProjectServiceProvider;
use MaidoProjects\Subproject\SubprojectServiceProvider;
use MaidoProjects\ProjectManager\ProjectManagerServiceProvider;
use MaidoProjects\Client\ClientServiceProvider;
use MaidoProjects\Agency\AgencyServiceProvider;
use MaidoProjects\SubprojectState\SubprojectStateServiceProvider;

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
$app->register(new SubprojectStateServiceProvider());

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


//$m = new Memcached();
//$m->addServer('localhost', 11211);
//
//$m->set('int', 99);
//$m->set('string', 'a simple string');
//$m->set('array', array(11, 12));
///* expire 'object' key in 5 minutes */
//$m->set('object', new stdclass, time() + 300);
//
//
//var_dump($m->get('int'));
//var_dump($m->get('string'));
//var_dump($m->get('array'));
//var_dump($m->get('object'));
//



//->value('pageName', 'index');

// hoe juiste template ophalen? In repository? ViewService model/twig
// dedicated twigs extenden de base twig
// component en values werken fundamenteel anders


// main pages
$app->get('/', 'MaidoProjects\\UserInterface\\ProjectsController::getProjectOverview');
$app->get('/forecast', 'MaidoProjects\\UserInterface\\ForecastController::getIndex');
$app->get('/result', 'MaidoProjects\\UserInterface\\ResultController::getIndex');

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
$app->get('/projectmanager/new', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->get('/projectmanager/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->post('/projectmanager/save', 'MaidoProjects\\UserInterface\\SettingsController::saveProjectManager');

// settings/clients
$app->get('/settings/clients', 'MaidoProjects\\UserInterface\\SettingsController::getClientOverview');
$app->get('/client/new', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->get('/client/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->post('/client/save', 'MaidoProjects\\UserInterface\\SettingsController::saveClient');

// settings/agencies
$app->get('/settings/agencies', 'MaidoProjects\\UserInterface\\SettingsController::getAgencyOverview');
$app->get('/agency/new', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->get('/agency/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->post('/agency/save', 'MaidoProjects\\UserInterface\\SettingsController::saveAgency');

// settings/subprojectstates
$app->get('/settings/subprojectstates', 'MaidoProjects\\UserInterface\\SettingsController::getSubprojectStatesOverview');
$app->get('/subprojectstate/new', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->get('/subprojectstate/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->post('/subprojectstate/save', 'MaidoProjects\\UserInterface\\SettingsController::saveSubprojectState');

// CTFO
$app->get('/ctfo', 'MaidoProjects\\UserInterface\\CTFOController::analyzeBuckaroo');


// start
$app->run();


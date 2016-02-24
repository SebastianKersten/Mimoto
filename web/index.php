<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';


use MaidoProjects\Project\ProjectServiceProvider;
use MaidoProjects\Subproject\SubprojectServiceProvider;
use MaidoProjects\ProjectManager\ProjectManagerServiceProvider;
use MaidoProjects\Client\ClientServiceProvider;
use MaidoProjects\Agency\AgencyServiceProvider;


$app = new \Silex\Application();

$loader = new \Twig_Loader_Filesystem(['../src/MaidoProjects/userinterface/templates']);
$twig = new Twig_Environment($loader, array(
//    'cache' => '../app/cache',
));


$link = mysql_connect('127.0.0.1', 'root', '') or die('Could not connect: ' . mysql_error());
mysql_select_db('maidoprojects') or die('Could not select database');


// ... definitions
$app['debug'] = true;
$app['twig'] = $twig;


// Connect service
$app->register(new ProjectServiceProvider());
$app->register(new SubprojectServiceProvider());
$app->register(new ProjectManagerServiceProvider());
$app->register(new ClientServiceProvider());
$app->register(new AgencyServiceProvider());




$app->get('/', 'MaidoProjects\\UserInterface\\ProjectsController::getProjectOverview');
$app->get('/prognose', 'MaidoProjects\\UserInterface\\ForecastController::getIndex');
$app->get('/resultaat', 'MaidoProjects\\UserInterface\\ResultController::getIndex');

$app->get('/project/new', 'MaidoProjects\\UserInterface\\ProjectsController::formProject');
$app->get('/project/change/{id}', 'MaidoProjects\\UserInterface\\ProjectsController::formProject');
$app->post('/project/save', 'MaidoProjects\\UserInterface\\ProjectsController::saveProject');

$app->get('/project/{project_id}/subproject/new', 'MaidoProjects\\UserInterface\\ProjectsController::formSubproject');


$app->get('/settings', 'MaidoProjects\\UserInterface\\SettingsController::getSettingsOverview');

$app->get('/settings/projectmanagers', 'MaidoProjects\\UserInterface\\SettingsController::getProjectManagerOverview');
$app->get('/settings/projectmanager/new', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->get('/settings/projectmanager/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->post('/settings/projectmanager/save', 'MaidoProjects\\UserInterface\\SettingsController::saveProjectManager');

$app->get('/settings/clients', 'MaidoProjects\\UserInterface\\SettingsController::getClientOverview');
$app->get('/settings/client/new', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->get('/settings/client/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->post('/settings/client/save', 'MaidoProjects\\UserInterface\\SettingsController::saveClient');

$app->get('/settings/agencies', 'MaidoProjects\\UserInterface\\SettingsController::getAgencyOverview');
$app->get('/settings/agency/new', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->get('/settings/agency/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->post('/settings/agency/save', 'MaidoProjects\\UserInterface\\SettingsController::saveAgency');

$app->get('/settings/subprojectstates', 'MaidoProjects\\UserInterface\\SettingsController::getSubprojectStatesOverview');
$app->get('/settings/subprojectstate/new', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->get('/settings/subprojectstate/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->post('/settings/subprojectstate/save', 'MaidoProjects\\UserInterface\\SettingsController::saveSubprojectState');

$app->get('/ctfo', 'MaidoProjects\\UserInterface\\CTFOController::analyzeBuckaroo');


$app->run();
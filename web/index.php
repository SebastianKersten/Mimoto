<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';


$app = new Silex\Application();

$loader = new Twig_Loader_Filesystem(['../src/MaidoProjects/view','../src/MaidoProjects/view']);
$twig = new Twig_Environment($loader, array(
//    'cache' => '../app/cache',
));


$link = mysql_connect('127.0.0.1', 'root', '') or die('Could not connect: ' . mysql_error());
mysql_select_db('maidoprojects') or die('Could not select database');


// ... definitions
$app['debug'] = true;
$app['twig'] = $twig;


$app->get('/', 'MaidoProjects\\Controller\\pages\\ProjectsController::getIndex');
$app->get('/prognose', 'MaidoProjects\\Controller\\pages\\ForecastController::getIndex');
$app->get('/resultaat', 'MaidoProjects\\Controller\\pages\\ResultController::getIndex');

$app->get('/project/new', 'MaidoProjects\\Controller\\pages\\ProjectsController::formNewProject');
$app->post('/project/save', 'MaidoProjects\\Controller\\pages\\ProjectsController::saveProject');

$app->get('/client/new', 'MaidoProjects\\Controller\\ClientController::new');
$app->post('/client/change', 'MaidoProjects\\Controller\\ClientController::change');

$app->get('/settings', 'MaidoProjects\\Controller\\pages\\SettingsController::getOverview');
$app->get('/settings/projectmanagers', 'MaidoProjects\\Controller\\pages\\SettingsController::getProjectManagerOverview');
$app->get('/settings/projectmanager/new', 'MaidoProjects\\Controller\\pages\\SettingsController::formNewProjectManager');
$app->post('/settings/projectmanager/save', 'MaidoProjects\\Controller\\pages\\SettingsController::saveProjectManager');
$app->get('/settings/clients', 'MaidoProjects\\Controller\\pages\\SettingsController::getClientOverview');
$app->get('/settings/client/new', 'MaidoProjects\\Controller\\pages\\SettingsController::formNewClient');
$app->post('/settings/client/save', 'MaidoProjects\\Controller\\pages\\SettingsController::saveClient');
$app->get('/settings/agencies', 'MaidoProjects\\Controller\\pages\\SettingsController::getAgencyOverview');
$app->get('/settings/agency/new', 'MaidoProjects\\Controller\\pages\\SettingsController::formNewAgency');
$app->post('/settings/agency/save', 'MaidoProjects\\Controller\\pages\\SettingsController::saveAgency');

$app->get('/ctfo', 'MaidoProjects\\Controller\\pages\\CTFOController::analyzeBuckaroo');


$app->run();
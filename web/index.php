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

$app->get('/client/add', 'MaidoProjects\\Controller\\ClientController::add');
$app->post('/client/edit', 'MaidoProjects\\Controller\\ClientController::edit');

$app->post('/pages/{id}/{slug}/add/{ownerid}', 'MimotoCMS\\Controller\\EditorController::addNode');
$app->get('/pages/{id}/{slug}', 'MaidoProjects\\Controller\\EditorController::getDataset');

$app->run();
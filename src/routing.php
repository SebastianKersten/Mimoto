<?php

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
$app->get('/settings/clients', 'MaidoProjects\\UserInterface\\SettingsController::viewClients');
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


// Silent Partner Ventures
$app->get('/silent', 'MaidoProjects\\UserInterface\\SilentController::getIndex');


$app->get('/example1', 'MaidoProjects\\UserInterface\\ExampleController::viewExample1');
$app->get('/example2', 'MaidoProjects\\UserInterface\\ExampleController::viewExample2');
$app->get('/example3', 'MaidoProjects\\UserInterface\\ExampleController::viewExample3');
$app->get('/example4', 'MaidoProjects\\UserInterface\\ExampleController::viewExample4');
$app->get('/example5', 'MaidoProjects\\UserInterface\\ExampleController::viewExample5');


$app->get('/articles', 'MaidoProjects\\UserInterface\\ExampleController::viewArticleOverview');
$app->get('/article/{nArticleId}', 'MaidoProjects\\UserInterface\\ExampleController::viewArticle');

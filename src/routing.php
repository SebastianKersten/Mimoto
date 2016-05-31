<?php

// main pages
$app->get('/', 'MaidoProjects\\UserInterface\\ProjectsController::viewProjects');
$app->get('/forecast', 'MaidoProjects\\UserInterface\\ForecastController::viewForecast');
$app->get('/result', 'MaidoProjects\\UserInterface\\ResultController::viewResult');

// projects
$app->get('/project/new', 'MaidoProjects\\UserInterface\\ProjectsController::formProject');
$app->get('/project/change/{nId}', 'MaidoProjects\\UserInterface\\ProjectsController::formProject');
$app->post('/project/save', 'MaidoProjects\\UserInterface\\ProjectsController::saveProject');

// subprojects
$app->get('/project/{nProjectId}/subproject/new', 'MaidoProjects\\UserInterface\\ProjectsController::formSubproject');
$app->get('/subproject/change/{nId}', 'MaidoProjects\\UserInterface\\ProjectsController::formSubproject');
$app->post('/subproject/save', 'MaidoProjects\\UserInterface\\ProjectsController::saveSubproject');

// settings
$app->get('/settings', 'MaidoProjects\\UserInterface\\SettingsController::viewOverview');

// settings/clients
$app->get('/settings/clients', 'MaidoProjects\\UserInterface\\SettingsController::viewClients');
$app->get('/client/new', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->get('/client/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->post('/client/save', 'MaidoProjects\\UserInterface\\SettingsController::saveClient');

// settings/agencies
$app->get('/settings/agencies', 'MaidoProjects\\UserInterface\\SettingsController::viewAgencies');
$app->get('/agency/new', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->get('/agency/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->post('/agency/save', 'MaidoProjects\\UserInterface\\SettingsController::saveAgency');

// settings/projectmanagers
$app->get('/settings/projectmanagers', 'MaidoProjects\\UserInterface\\SettingsController::viewProjectManagers');
$app->get('/projectmanager/new', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->get('/projectmanager/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->post('/projectmanager/save', 'MaidoProjects\\UserInterface\\SettingsController::saveProjectManager');

// settings/subprojectstates
$app->get('/settings/subprojectstates', 'MaidoProjects\\UserInterface\\SettingsController::viewSubprojectStates');
$app->get('/subprojectstate/new', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->get('/subprojectstate/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->post('/subprojectstate/save', 'MaidoProjects\\UserInterface\\SettingsController::saveSubprojectState');


// Silent Partner Ventures
$app->get('/silent', 'MaidoProjects\\UserInterface\\SilentController::viewSilent');


$app->get('/example1', 'MaidoProjects\\UserInterface\\ExampleController::viewExample1');
$app->get('/example2', 'MaidoProjects\\UserInterface\\ExampleController::viewExample2');
$app->get('/example3', 'MaidoProjects\\UserInterface\\ExampleController::viewExample3');
$app->get('/example4', 'MaidoProjects\\UserInterface\\ExampleController::viewExample4');
$app->get('/example5', 'MaidoProjects\\UserInterface\\ExampleController::viewExample5');
$app->get('/example6', 'MaidoProjects\\UserInterface\\ExampleController::viewExample6');
$app->get('/example7', 'MaidoProjects\\UserInterface\\ExampleController::viewExample7');
$app->get('/example8', 'MaidoProjects\\UserInterface\\ExampleController::viewExample8');


$app->get('/articles', 'MaidoProjects\\UserInterface\\ExampleController::viewArticleOverview');
$app->get('/article/{nArticleId}', 'MaidoProjects\\UserInterface\\ExampleController::viewArticle');

$app->get('/memcache', 'MaidoProjects\\UserInterface\\ExampleController::viewMemcacheExample');
$app->get('/memcachemonitor/{sEntityType}', 'MaidoProjects\\UserInterface\\ExampleController::viewAllArticlesInMemcache');

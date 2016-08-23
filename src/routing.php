<?php

// main pages
$app->get('/', 'MaidoProjects\\UserInterface\\ProjectsController::viewProjects');
$app->get('/forecast', 'MaidoProjects\\UserInterface\\ForecastController::viewForecast');
$app->get('/result', 'MaidoProjects\\UserInterface\\ResultController::viewResult');

// ___projects
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
$app->get('/example9', 'MaidoProjects\\UserInterface\\ExampleController::viewExample9');
$app->get('/example10', 'MaidoProjects\\UserInterface\\ExampleController::viewExample10');

$app->get('/example11', 'MaidoProjects\\UserInterface\\ExampleController::viewExample11');
$app->get('/example12', 'MaidoProjects\\UserInterface\\ExampleController::viewExample12');
$app->get('/example13', 'MaidoProjects\\UserInterface\\ExampleController::viewExample13');

$app->get('/example14', 'MaidoProjects\\UserInterface\\ExampleController::viewExample14');
$app->get('/example15', 'MaidoProjects\\UserInterface\\ExampleController::viewExample15');
$app->get('/example16', 'MaidoProjects\\UserInterface\\ExampleController::viewExample16');
$app->get('/example17', 'MaidoProjects\\UserInterface\\ExampleController::viewExample17');
$app->get('/example18', 'MaidoProjects\\UserInterface\\ExampleController::viewExample18');
$app->get('/example19', 'MaidoProjects\\UserInterface\\ExampleController::viewExample19');
$app->get('/example20', 'MaidoProjects\\UserInterface\\ExampleController::viewExample20');
$app->get('/example21', 'MaidoProjects\\UserInterface\\ExampleController::viewExample21');
$app->get('/example22', 'MaidoProjects\\UserInterface\\ExampleController::viewExample22');



$app->get('/exampleform1', 'MaidoProjects\\UserInterface\\ExampleFormController::viewExampleForm1');


$app->get('/admin/entity/example1', 'MaidoProjects\\UserInterface\\ExampleEntityAdminController::createEntity');
$app->get('/admin/entity/example2', 'MaidoProjects\\UserInterface\\ExampleEntityAdminController::editEntity');
$app->get('/admin/entity/example3', 'MaidoProjects\\UserInterface\\ExampleEntityAdminController::removeEntity');


$app->get('/articles', 'MaidoProjects\\UserInterface\\ExampleController::viewArticleOverview');
$app->get('/article/{nArticleId}', 'MaidoProjects\\UserInterface\\ExampleController::viewArticle');

$app->get('/memcache', 'MaidoProjects\\UserInterface\\ExampleController::viewMemcacheExample');
$app->get('/memcachemonitor/{sEntityType}', 'MaidoProjects\\UserInterface\\ExampleController::viewAllArticlesInMemcache');


$app->get('/notifications', 'MaidoProjects\\UserInterface\\NotificationCenterController::viewNotificationCenter');
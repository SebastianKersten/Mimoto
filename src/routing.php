<?php

// Silent Partner Ventures
$app->get('/silent', 'Mimoto\\UserInterface\\SilentController::viewSilent');


$app->get('/example1', 'Mimoto\\UserInterface\\ExampleController::viewExample1');
$app->get('/example2', 'Mimoto\\UserInterface\\ExampleController::viewExample2');
$app->get('/example3', 'Mimoto\\UserInterface\\ExampleController::viewExample3');
$app->get('/example4', 'Mimoto\\UserInterface\\ExampleController::viewExample4');
$app->get('/example5', 'Mimoto\\UserInterface\\ExampleController::viewExample5');
$app->get('/example6', 'Mimoto\\UserInterface\\ExampleController::viewExample6');
$app->get('/example7', 'Mimoto\\UserInterface\\ExampleController::viewExample7');

$app->get('/example8', 'Mimoto\\UserInterface\\ExampleController::viewExample8');
$app->get('/example9', 'Mimoto\\UserInterface\\ExampleController::viewExample9');
$app->get('/example10', 'Mimoto\\UserInterface\\ExampleController::viewExample10');

$app->get('/example11', 'Mimoto\\UserInterface\\ExampleController::viewExample11');
$app->get('/example12', 'Mimoto\\UserInterface\\ExampleController::viewExample12');
$app->get('/example13', 'Mimoto\\UserInterface\\ExampleController::viewExample13');

$app->get('/example14', 'Mimoto\\UserInterface\\ExampleController::viewExample14');
$app->get('/example15', 'Mimoto\\UserInterface\\ExampleController::viewExample15');
$app->get('/example16', 'Mimoto\\UserInterface\\ExampleController::viewExample16');
$app->get('/example17', 'Mimoto\\UserInterface\\ExampleController::viewExample17');
$app->get('/example18', 'Mimoto\\UserInterface\\ExampleController::viewExample18');
$app->get('/example19', 'Mimoto\\UserInterface\\ExampleController::viewExample19');
$app->get('/example20', 'Mimoto\\UserInterface\\ExampleController::viewExample20');
$app->get('/example21', 'Mimoto\\UserInterface\\ExampleController::viewExample21');
$app->get('/example22', 'Mimoto\\UserInterface\\ExampleController::viewExample22');



$app->get('/exampleform1', 'Mimoto\\UserInterface\\ExampleFormController::viewExampleForm1');


$app->get('/admin/entity/example1', 'Mimoto\\UserInterface\\ExampleEntityAdminController::createEntity');
$app->get('/admin/entity/example2', 'Mimoto\\UserInterface\\ExampleEntityAdminController::editEntity');
$app->get('/admin/entity/example3', 'Mimoto\\UserInterface\\ExampleEntityAdminController::removeEntity');


$app->get('/articles', 'Mimoto\\UserInterface\\ExampleController::viewArticleOverview');
$app->get('/article/{nArticleId}', 'Mimoto\\UserInterface\\ExampleController::viewArticle');

$app->get('/memcache', 'Mimoto\\UserInterface\\ExampleController::viewMemcacheExample');
$app->get('/memcachemonitor/{sEntityType}', 'Mimoto\\UserInterface\\ExampleController::viewAllArticlesInMemcache');


$app->get('/notifications', 'Mimoto\\UserInterface\\NotificationCenterController::viewNotificationCenter');
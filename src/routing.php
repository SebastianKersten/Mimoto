<?php

// Silent Partner Ventures
$app->get('/silent', 'Mimoto\\UserInterface\\SilentController::viewSilent');


$app->get('/example1', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample1');
$app->get('/example2', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample2');
$app->get('/example3', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample3');
$app->get('/example4', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample4');
$app->get('/example5', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample5');
$app->get('/example6', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample6');
$app->get('/example7', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample7');

$app->get('/example8', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample8');
$app->get('/example8a', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample8a');
$app->get('/example8b', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample8b');

$app->get('/example9', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample9');
$app->get('/example9a', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample9a');
$app->get('/example9b', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample9b');

$app->get('/example10', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample10');
$app->get('/example10a', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample10a');
$app->get('/example10b', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample10b');

$app->get('/example11', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample11');
$app->get('/example11a', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample11a');
$app->get('/example11b', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample11b');
$app->get('/example11c', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample11c');
$app->get('/example11d', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample11d');

$app->get('/example12', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample12');
$app->get('/example13', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample13');
$app->get('/example14', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample14');
$app->get('/example15', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample15');



$app->get('/input/textline', 'Mimoto\\UserInterface\\examples\\ExampleController::viewInputTextline');
$app->get('/input/dropdown', 'Mimoto\\UserInterface\\examples\\ExampleController::viewInputDropdown');
$app->get('/input/checkbox', 'Mimoto\\UserInterface\\examples\\ExampleController::viewInputCheckbox');
$app->get('/input/radiobutton', 'Mimoto\\UserInterface\\examples\\ExampleController::viewInputRadiobutton');




$app->get('/exampleform1', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm1');


$app->get('/admin/entity/example1', 'Mimoto\\UserInterface\\ExampleEntityAdminController::createEntity');
$app->get('/admin/entity/example2', 'Mimoto\\UserInterface\\ExampleEntityAdminController::editEntity');
$app->get('/admin/entity/example3', 'Mimoto\\UserInterface\\ExampleEntityAdminController::removeEntity');


$app->get('/articles', 'Mimoto\\UserInterface\\examples\\ExampleController::viewArticleOverview');
$app->get('/article/{nArticleId}', 'Mimoto\\UserInterface\\examples\\ExampleController::viewArticle');

$app->get('/memcache', 'Mimoto\\UserInterface\\examples\\ExampleController::viewMemcacheExample');
$app->get('/memcachemonitor/{sEntityType}', 'Mimoto\\UserInterface\\examples\\ExampleController::viewAllArticlesInMemcache');


$app->get('/notifications', 'Mimoto\\UserInterface\\MimotoNotificationCenter\\NotificationCenterController::viewNotificationCenter');

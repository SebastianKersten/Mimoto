<?php

    // Silent Partner Ventures
    $app->get('/silent', 'Mimoto\\UserInterface\\MimotoCMS\\SilentController::viewSilent');

    $app->get('/', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExamples');

    $app->get('/formvalidation', 'Mimoto\\UserInterface\\examples\\FormValidationController::showForm');

    // --- actions ---

    $app->get('/action1', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction1');
    $app->get('/action2', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction2');
    $app->get('/action3', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction3');
    $app->get('/action4', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction4');
    $app->get('/action5', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction5');
    $app->get('/action6', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction6');
    $app->get('/action7', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction7');
    $app->get('/action8', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction8');
    $app->get('/action9', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction9');
    $app->get('/action10', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction10');
    $app->get('/action11', 'Mimoto\\UserInterface\\examples\\ExampleController::triggerAction11');


    // --- interface examples ---

    $app->get('/example1', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample1');
    $app->get('/example2', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample2');
    $app->get('/example3', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample3');
    $app->get('/example4', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample4');
    $app->get('/example5', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample5');
    $app->get('/example6', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample6');
    $app->get('/example7', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample7');
    $app->get('/example8', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample8');
    $app->get('/example9', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample9');
    $app->get('/example10', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample10');
    $app->get('/example11', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample11');

    $app->get('/image/{nPersonId}', 'Mimoto\\UserInterface\\examples\\ExampleController::viewImageExample');
    $app->get('/selection/{nSelectionId}', 'Mimoto\\UserInterface\\examples\\ExampleController::viewSelectionExample');

    // --- service tests ---
    $app->get('/test/pusher', 'Mimoto\\UserInterface\\examples\\ExampleController::testPusher');



//    $app->get('/example12', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample12');
//    $app->get('/example13', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample13');
//    $app->get('/example14', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample14');
//    $app->get('/example15', 'Mimoto\\UserInterface\\examples\\ExampleController::viewExample15');

    $app->get('/debug1/{nEntityId}', 'Mimoto\\UserInterface\\examples\\ExampleController::viewDebug1');




    $app->get('/exampleform1', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm1');
    $app->get('/exampleform2', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm2');
    $app->get('/exampleform3', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm3');
    $app->get('/exampleform4', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm4');
    $app->get('/exampleform5', 'Mimoto\\UserInterface\\examples\\ExampleFormController::viewExampleForm5');


    $app->get('/articles', 'Mimoto\\UserInterface\\examples\\ExampleController::viewArticleOverview');
    $app->get('/article/{nArticleId}', 'Mimoto\\UserInterface\\examples\\ExampleController::viewArticle');

    $app->get('/memcache', 'Mimoto\\UserInterface\\examples\\ExampleController::viewMemcacheExample');
    $app->get('/memcachemonitor/{sEntityType}', 'Mimoto\\UserInterface\\examples\\ExampleController::viewAllArticlesInMemcache');

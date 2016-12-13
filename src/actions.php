<?php

    Mimoto::addAction('Mimoto\\UserInterface\\examples\\ExampleController::viewArticle');


    $app->get('/article/{nArticleId}', 'Mimoto\\UserInterface\\examples\\ExampleController::viewArticle');

    $app->get('/memcache', 'Mimoto\\UserInterface\\examples\\ExampleController::viewMemcacheExample');
    $app->get('/memcachemonitor/{sEntityType}', 'Mimoto\\UserInterface\\examples\\ExampleController::viewAllArticlesInMemcache');

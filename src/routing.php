<?php

    // Mimoto.Publisher
//    $app->get ('/publisher', 'Mimoto\\UserInterface\\publisher\\PublisherController::viewFeed');
//    $app->get ('/publisher/article/{nArticleId}', 'Mimoto\\UserInterface\\publisher\\PublisherController::viewArticle');
    $app->post('/publisher/article/{nArticleId}/comment/add', 'Mimoto\\UserInterface\\publisher\\PublisherController::addComment');
    $app->post('/publisher/comment/{nCommentId}/remove', 'Mimoto\\UserInterface\\publisher\\PublisherController::removeComment');
//    $app->post('/publisher/comment/{nCommentId}/highlight', 'Mimoto\\UserInterface\\publisher\\PublisherController::highlightComment');
//    $app->post('/publisher/comment/{nCommentId}/unhiglight', 'Mimoto\\UserInterface\\publisher\\PublisherController::unhighlightComment');
//    $app->get ('/publisher/editor/{nArticleId}', 'Mimoto\\UserInterface\\publisher\\PublisherController::viewEditor');
//
//
//    $app->get ('/publisher/people', 'Mimoto\\UserInterface\\publisher\\PublisherController::viewPeople');


    // The Timeline
    $app->get ('/thetimeline/{nTimelineId}', 'Mimoto\\UserInterface\\thetimeline\\TimelineController::viewTimeline');

    // Mimoto.Docs
    $app->get ('/docs', 'Mimoto\\UserInterface\\docs\\DocsController::viewDocs');


    $app->get('/defaultvalue', 'Mimoto\\UserInterface\docs\DocsController::testDefaultValue');

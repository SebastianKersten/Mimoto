<?php

    // Mimoto.Publisher
    $app->post('/publisher/article/{nArticleId}/comment/add', 'Mimoto\\UserInterface\\publisher\\PublisherController::addComment');
    $app->post('/publisher/comment/{nCommentId}/remove', 'Mimoto\\UserInterface\\publisher\\PublisherController::removeComment');
//    $app->post('/publisher/comment/{nCommentId}/highlight', 'Mimoto\\UserInterface\\publisher\\PublisherController::highlightComment');
//    $app->post('/publisher/comment/{nCommentId}/unhiglight', 'Mimoto\\UserInterface\\publisher\\PublisherController::unhighlightComment');
//    $app->get ('/publisher/editor/{nArticleId}', 'Mimoto\\UserInterface\\publisher\\PublisherController::viewEditor');
    // authors
    // ideas
    // groups


    $app->get('/publisher/page/{nPageId}', 'Mimoto\\UserInterface\\publisher\\PublisherController::showPages');


    // The Timeline
    $app->get ('/thetimeline/{nTimelineId}', 'Mimoto\\UserInterface\\thetimeline\\TimelineController::viewTimeline');

    // Mimoto.Docs
    $app->get ('/docs', 'Mimoto\\UserInterface\\docs\\DocsController::viewDocs');

    // under development
    $app->get('/selector', 'Mimoto\\UserInterface\\MimotoCMS\\HeartbeatController::devSelection');
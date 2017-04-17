<?php

    $config = (object) array
    (
        'general' => (object) array
        (
            'project_root' => dirname(dirname(__FILE__)).'/',
            'web_root' => dirname(dirname(__FILE__)).'/web/',
            'public_root' => '/'
        ),
        'mysql' => (object) array
        (
            'host' => '127.0.0.1',
            'dbname' => 'mimoto.cms',
            'username' => 'root',
            'password' => ''
        ),
        'pusher' => (object) array
        (
            'auth_key' => '19c5b7fbb5340fe48402',
            'secret' => 'f35bb4069448073dbaee',
            'app_id' => '284931',
            'cluster' => 'eu',
            'host' => 'api-eu.pusher.com',
            'encrypted' => true,
            'authEndPoint' => '/Mimoto.Aimless/realtime/collaboration'
        ),
        'slack' => (object) array
        (
            'webhook' => ''
        ),
        'media' => (object) array
        (
            'upload_dir' => 'dynamic/'
        )
    );

    return $config;


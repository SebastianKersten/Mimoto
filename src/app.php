<?php

    error_reporting(E_ALL ^ E_DEPRECATED);

    // web/index.php
    require_once __DIR__.'/../vendor/autoload.php';

    // Mimoto classes
    use Mimoto\Mimoto;

    // init and send
    $mimoto = new Mimoto(dirname(dirname(__FILE__)), dirname(dirname(__FILE__)).'/mimoto.json');

    // send
    return $mimoto->getSilexApp();

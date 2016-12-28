<?php


// Pusher classes
require_once(dirname(dirname(dirname(__FILE__))).'/vendor/pusher/pusher-php-server/lib/pusher.php');

//echo gearman_version();


$config = require_once(dirname(dirname(__FILE__)).'/config.php');


// init
$worker= new GearmanWorker();

// setup
$worker->addServer();
$worker->addFunction("sendUpdate", "sendUpdate");



// configure    
$options = array(
    'cluster' => $config->pusher->cluster,
    'encrypted' => $config->pusher->encrypted,
    'host' => $config->pusher->host
);

$GLOBALS['pusher'] = new \Pusher(
    $config->pusher->auth_key,
    $config->pusher->secret,
    $config->pusher->app_id,
    $options
);


while ($worker->work());


function sendUpdate($job)
{
    // read
    $workload = json_decode($job->workload());

    // send
    $GLOBALS['pusher']->trigger($workload->sChannel, $workload->sEvent, $workload->data);
}

<?php

//gearman_version();


// init
$worker= new GearmanWorker();

// setup
$worker->addServer();
$worker->addFunction("sendSlackNotification", "sendSlackNotification");

while ($worker->work());


function sendSlackNotification($job)
{
    // load
    $config = require(dirname(dirname(__FILE__)).'/config.php');

    // read
    $workload = json_decode($job->workload());

    // compose
    $data = "payload=".json_encode(array
        (
            "channel"       =>  "#".$workload->channel,
            "text"          =>  $workload->message,
            "username"      => "Mimoto.Aimless",
            "icon_emoji"    =>  ":ant:"
        ));


    // You can get your webhook endpoint from your Slack settings
    $ch = curl_init($config->slack->webhook);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
}

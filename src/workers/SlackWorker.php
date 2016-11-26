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
    // read
    $workload = json_decode($job->workload());

    $data = "payload=".json_encode(array
        (
            "channel"       =>  "#".$workload->channel,
            "text"          =>  $workload->message,
            "username"      => "Mimoto.Aimless",
            "icon_emoji"    =>  ":ant:"
        ));

    // You can get your webhook endpoint from your Slack settings
    $ch = curl_init("https://hooks.slack.com/services/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");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
}

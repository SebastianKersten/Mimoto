<?php


////gearman_version();
//
//
//$config = require_once(dirname(dirname(__FILE__)).'/config.php');
//
//
//// init
//$worker= new GearmanWorker();
//
//// setup
//$worker->addServer();
//$worker->addFunction("sendUpdate", "sendUpdate");
//
//
//
//// configure
//$options = array(
//    $config->pusher->cluster,
//    $config->pusher->encrypted
//);
//
//$GLOBALS['pusher'] = new \Pusher(
//    $config->pusher->auth_key,
//    $config->pusher->secret,
//    $config->pusher->app_id,
//    $options
//);
//
//
//while ($worker->work());
//
//
//function sendUpdate($job)
//{
//
//
//    // read
//    $workload = json_decode($job->workload());
//
//    print_r($workload);
//
//    // send
//    $GLOBALS['pusher']->trigger($workload->sChannel, $workload->sEvent, $workload->data);
//}




function membership_mail($job) {
    $workload = unserialize($job->workload());
    if ($workload === false || !isset($workload['renewalLogId']) || !is_int($workload['renewalLogId']) || $workload['renewalLogId'] < 1) {
        return false;
    }
    $call = 'renewal/membershipMail/' . $workload['renewalLogId'];
    if (isset($workload['test']) && $workload['test'] === true) {
        return $call;
    }
    executeCli($call);
    return true;
}

<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';


// Mimoto classes
use Mimoto\Mimoto;

// configure
Mimoto::setValue('config', include(dirname(__FILE__).'/config.php'));
Mimoto::setValue('ProjectConfig.root', __DIR__ . '/../');
Mimoto::setValue('ProjectConfig.twigroot', 'src/userinterface/');


// init
$app = new \Silex\Application();



// setup
$loader = new \Twig_Loader_Filesystem([Mimoto::value('ProjectConfig.root').Mimoto::value('ProjectConfig.twigroot')]);
$twig = new Twig_Environment($loader, array(
    // 'cache' => '../app/cache',
    'autoescape' => false
));



// connect
Mimoto::setService('database', new PDO("mysql:host=".Mimoto::value('config')->mysql->host.";dbname=".Mimoto::value('config')->mysql->dbname, Mimoto::value('config')->mysql->username, Mimoto::value('config')->mysql->password));
Mimoto::setService('twig', $twig);

// setup
$app['debug'] = true;
$app['twig'] = $twig;
$app['Mimoto'] = new \Mimoto\Mimoto($app, false);



//function Mimoto('data') of als singleton Mimoto::data->create
// add actions folder


function output($sTitle, $data = null, $bScream = false)
{
    // style
    $sTextColor = ($bScream) ? '#ff0000' : '#06afea';
    $sBorderColor = ($bScream) ? '#ff0000' : '#858585';
    $sBackgroundColor = ($bScream) ? '#ffbbbb' : '#f5f5f5';

    echo '<div style="background-color:'.$sBackgroundColor.';border:solid 1px '.$sBorderColor.';padding:20px">';
    echo '<h2><b style="color:'.$sTextColor.'">'.$sTitle.'</b></h2><hr>';
    echo '<pre style="width:100%">';
    if (!empty($data)) print_r($data);
    echo '</pre>';
    echo '</div>';
    echo '<br>';
}

function error($data, $bDumpVar = false)
{
    echo '<div style="background-color:#DF5B57;color:#ffffff;padding:15px 20px 0 20px; width:100%;">';
    echo '<div>';
    echo '<h2><b style="font-size:larger;">Error</b></h2><hr style="border:0;height:1px;background:#ffffff">';
    echo '<pre style="overflow:scroll">';
    if (empty($data))
    {
        echo "<i style='font-style:italic'>No data provided</i>";
    }
    else
    {
        ($bDumpVar) ? var_dump($data) : print_r($data);
    }
    echo '</pre>';
    echo '</div>';
    echo '<br>';

    //throw new Exception('oh oh, computer says oops!');
    die();
}

return $app;

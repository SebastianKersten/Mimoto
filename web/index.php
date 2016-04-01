<?php

$app = require_once __DIR__.'/../src/app.php';
require_once __DIR__.'/../src/routing.php';



//$m = new Memcached();
//$m->addServer('localhost', 11211);
//
//$m->set('int', 99);
//$m->set('string', 'a simple string');
//$m->set('array', array(11, 12));
///* expire 'object' key in 5 minutes */
//$m->set('object', new stdclass, time() + 300);
//
//
//var_dump($m->get('int'));
//var_dump($m->get('string'));
//var_dump($m->get('array'));
//var_dump($m->get('object'));
//



//->value('pageName', 'index');

// hoe juiste template ophalen? In repository? ViewService model/twig
// dedicated twigs extenden de base twig
// component en values werken fundamenteel anders




// start
$app->run();


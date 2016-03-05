<?php

error_reporting(E_ALL ^ E_DEPRECATED);

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

// Momkai classes
use MaidoProjects\Project\ProjectServiceProvider;
use MaidoProjects\Subproject\SubprojectStateEvent;
use MaidoProjects\Subproject\SubprojectServiceProvider;
use MaidoProjects\ProjectManager\ProjectManagerEvent;
use MaidoProjects\ProjectManager\ProjectManagerServiceProvider;
use MaidoProjects\Client\ClientEvent;
use MaidoProjects\Client\ClientServiceProvider;
use MaidoProjects\Agency\AgencyEvent;
use MaidoProjects\Agency\AgencyServiceProvider;

// Momkai classes
use Momkai\Event\EventServiceProvider;


// init
$app = new \Silex\Application();

// setup
$loader = new \Twig_Loader_Filesystem(['../src/MaidoProjects/userinterface/templates']);
$twig = new Twig_Environment($loader, array(
    // 'cache' => '../app/cache',
));

// connect
$link = mysql_connect('127.0.0.1', 'root', '');
mysql_select_db('maidoprojects') or die('Could not select database');


// ... definitions
$app['debug'] = true;
$app['twig'] = $twig;


// connect project services
$app->register(new ProjectServiceProvider());
$app->register(new SubprojectServiceProvider());
$app->register(new ProjectManagerServiceProvider());
$app->register(new ClientServiceProvider());
$app->register(new AgencyServiceProvider());

// connect platform services
$app->register(new EventServiceProvider());



function sendPusherEvent($sChannel, $sEvent, $data) {
    
    require_once('Pusher.php');
    
    $options = array(
        'cluster' => 'eu',
        'encrypted' => true
    );
    
    $pusher = new Pusher(
        '55152f70c4cec27de21d',
        '7e72297e347e339cd241',
        '185150',
        $options
    );
    
    //$data['message'] = $sMessage;
    $pusher->trigger($sChannel, $sEvent, $data);
}

$app['dispatcher']->addListener(ClientEvent::UPDATED, function($clientEvent) {
    
    $data = (object) array();
    
    $data->type = 'livescreen';
    
    $data->ajax = (object) array();
    $data->ajax->url = '/livescreen/client/'.$clientEvent->getClient()->getId();
    $data->ajax->method = 'GET';
    //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
    $data->ajax->dataType = 'html';
    
    $data->dom = (object) array();
    $data->dom->containerId = '#simplelist';
    $data->dom->objectId = '#simplelist_item_'.$clientEvent->getClient()->getId();
    
    // dom, internal template id's direct live update, of replace entire element
    
    sendPusherEvent('clients', 'client.updated', $data);
});

$app['dispatcher']->addListener(ClientEvent::CREATED, function($clientEvent) {
    
    $data = (object) array();
    
    $data->type = 'livescreen';
    
    $data->ajax = (object) array();
    $data->ajax->url = '/livescreen/client/'.$clientEvent->getClient()->getId();
    $data->ajax->method = 'GET';
    //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
    $data->ajax->dataType = 'html';
    
    $data->dom = (object) array();
    $data->dom->containerId = '#simplelist';
    $data->dom->objectId = '#simplelist_item_'.$clientEvent->getClient()->getId();
    
    // dom, internal template id's direct live update, of replace entire element
    
    sendPusherEvent('clients', 'client.created', $data);
});



$app['dispatcher']->addListener(AgencyEvent::UPDATED, function($agencyEvent) {
    
    $data = (object) array();
    
    $data->type = 'livescreen';
    
    $data->ajax = (object) array();
    $data->ajax->url = '/livescreen/agency/'.$agencyEvent->getAgency()->getId();
    $data->ajax->method = 'GET';
    //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
    $data->ajax->dataType = 'html';
    
    $data->dom = (object) array();
    $data->dom->containerId = '#simplelist';
    $data->dom->objectId = '#simplelist_item_'.$agencyEvent->getAgency()->getId();
    
    // dom, internal template id's direct live update, of replace entire element
    
    sendPusherEvent('agencies', 'agency.updated', $data);
});

$app['dispatcher']->addListener(AgencyEvent::CREATED, function($agencyEvent) {
    
    $data = (object) array();
    
    $data->type = 'livescreen';
    
    $data->ajax = (object) array();
    $data->ajax->url = '/livescreen/agency/'.$agencyEvent->getAgency()->getId();
    $data->ajax->method = 'GET';
    //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
    $data->ajax->dataType = 'html';
    
    $data->dom = (object) array();
    $data->dom->containerId = '#simplelist';
    $data->dom->objectId = '#simplelist_item_'.$agencyEvent->getAgency()->getId();
    
    // dom, internal template id's direct live update, of replace entire element
    
    sendPusherEvent('agencies', 'agency.created', $data);
});



$app['dispatcher']->addListener(ProjectManagerEvent::UPDATED, function($projectmanagerEvent) {
    
    $data = (object) array();
    
    $data->type = 'livescreen';
    
    $data->ajax = (object) array();
    $data->ajax->url = '/livescreen/projectmanager/'.$projectmanagerEvent->getProjectManager()->getId();
    $data->ajax->method = 'GET';
    //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
    $data->ajax->dataType = 'html';
    
    $data->dom = (object) array();
    $data->dom->containerId = '#simplelist';
    $data->dom->objectId = '#simplelist_item_'.$projectmanagerEvent->getProjectManager()->getId();
    
    // dom, internal template id's direct live update, of replace entire element
    
    sendPusherEvent('projectmanagers', 'projectmanager.updated', $data);
});

$app['dispatcher']->addListener(ProjectManagerEvent::CREATED, function($projectmanagerEvent) {
    
    $data = (object) array();
    
    $data->type = 'livescreen';
    
    $data->ajax = (object) array();
    $data->ajax->url = '/livescreen/projectmanager/'.$projectmanagerEvent->getProjectManager()->getId();
    $data->ajax->method = 'GET';
    //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
    $data->ajax->dataType = 'html';
    
    $data->dom = (object) array();
    $data->dom->containerId = '#simplelist';
    $data->dom->objectId = '#simplelist_item_'.$projectmanagerEvent->getProjectManager()->getId();
    
    // dom, internal template id's direct live update, of replace entire element
    
    sendPusherEvent('projectmanagers', 'projectmanager.created', $data);
});


$app['dispatcher']->addListener(SubprojectStateEvent::UPDATED, function($subprojectstateEvent) {
    
    $data = (object) array();
    
    $data->type = 'livescreen';
    
    $data->ajax = (object) array();
    $data->ajax->url = '/livescreen/subprojectstate/'.$subprojectstateEvent->getSubprojectState()->getId();
    $data->ajax->method = 'GET';
    //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
    $data->ajax->dataType = 'html';
    
    $data->dom = (object) array();
    $data->dom->containerId = '#simplelist';
    $data->dom->objectId = '#simplelist_item_'.$subprojectstateEvent->getSubprojectState()->getId();
    
    // dom, internal template id's direct live update, of replace entire element
    
    sendPusherEvent('subprojectstates', 'subprojectstate.updated', $data);
});

$app['dispatcher']->addListener(SubprojectStateEvent::CREATED, function($subprojectstateEvent) {
    
    $data = (object) array();
    
    $data->type = 'livescreen';
    
    $data->ajax = (object) array();
    $data->ajax->url = '/livescreen/subprojectstate/'.$subprojectstateEvent->getSubprojectState()->getId();
    $data->ajax->method = 'GET';
    //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
    $data->ajax->dataType = 'html';
    
    $data->dom = (object) array();
    $data->dom->containerId = '#simplelist';
    $data->dom->objectId = '#simplelist_item_'.$subprojectstateEvent->getSubprojectState()->getId();
    
    // dom, internal template id's direct live update, of replace entire element
    
    sendPusherEvent('subprojectstates', 'subprojectstate.created', $data);
});




// connect elements from template -> send content, voorzien van meta data
// auto update, connect field with event -> mapping ->type = component (via url) of field (via direct value)

// ----------> ListComponent
// gearman -> type-async -> in jobserver
// listener class -> start van sequence
// generaliseer PusherEventHandler en pas toe op de 4 pagina's
// scheduled requests/actions (ActionSequence)
// Queue met statusupdates, bijwerking en monitoring



// validate validity of the client monitor (auto-reboot)



// #todo listeners
//$app['dispatcher']->addListener('xxx', 'MaidoProjects\\UserInterface\\ProjectsController::getProjectOverview');
// 
// - repositories gooien update events uit
// - op deze events worden sequences getriggerd
// - deze sequences kunnen op basis van config worden opgezet
//      bijv. klaarzetten van diverse mail requests in timed queue -> welkom, eerste handleiding dag later
//      de request (of command) wordt opgeslagen, niet de feitelijke mail. Zo kan nog op het laatste moment
//      een update worden meegenomen in die mail
//      RequestQueue -> wordt aangestuurd door cronjob die kijkt of een request aan de beurt is en gooit deze
//      weer het systeem in (bijv. via jobserver of direct
//      Config: ON(user.new) -> sendMail with params (template, User)

/*
 * #todo - EventService
 * sync/async - recipies - action flows
 * sendRequest
 * sendUpdate
 * sendWelcomeMail
 * 
 * -------> sequence ON(event) stap 1, 2, 3 -> register steps, zoals in Mimoto TaskManager
 * 
 * createUser -> UPDATE: user.new
 * send welcome mail
 * wie stelt de mail op? MailService interface -> type, data
 * MailService->sendMail($sTermplate);
 * 
 * commando -> commandHandler (CommandBus pattern)
 * 
$app['dispatcher']->addListener(UserEvents::AFTER_INSERT, function(UserEvent $event) use ($app) {
    $user = $event->getUser();
    $app['logger']->info('Created user ' . $user->getId());
});
*/




// main pages
$app->get('/', 'MaidoProjects\\UserInterface\\ProjectsController::getProjectOverview');
$app->get('/prognose', 'MaidoProjects\\UserInterface\\ForecastController::getIndex');
$app->get('/resultaat', 'MaidoProjects\\UserInterface\\ResultController::getIndex');

// projects
$app->get('/project/new', 'MaidoProjects\\UserInterface\\ProjectsController::formProject');
$app->get('/project/change/{nId}', 'MaidoProjects\\UserInterface\\ProjectsController::formProject');
$app->post('/project/save', 'MaidoProjects\\UserInterface\\ProjectsController::saveProject');

// subprojects
$app->get('/project/{nProjectId}/subproject/new', 'MaidoProjects\\UserInterface\\ProjectsController::formSubproject');
$app->get('/subproject/change/{nId}', 'MaidoProjects\\UserInterface\\ProjectsController::formSubproject');
$app->post('/subproject/save', 'MaidoProjects\\UserInterface\\ProjectsController::saveSubproject');

// settings
$app->get('/settings', 'MaidoProjects\\UserInterface\\SettingsController::getSettingsOverview');

// settings/projectmanagers
$app->get('/settings/projectmanagers', 'MaidoProjects\\UserInterface\\SettingsController::getProjectManagerOverview');
$app->get('/settings/projectmanager/new', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->get('/settings/projectmanager/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formProjectManager');
$app->post('/settings/projectmanager/save', 'MaidoProjects\\UserInterface\\SettingsController::saveProjectManager');

// settings/clients
$app->get('/settings/clients', 'MaidoProjects\\UserInterface\\SettingsController::getClientOverview');
$app->get('/settings/client/new', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->get('/settings/client/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formClient');
$app->post('/settings/client/save', 'MaidoProjects\\UserInterface\\SettingsController::saveClient');

// settings/agencies
$app->get('/settings/agencies', 'MaidoProjects\\UserInterface\\SettingsController::getAgencyOverview');
$app->get('/settings/agency/new', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->get('/settings/agency/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formAgency');
$app->post('/settings/agency/save', 'MaidoProjects\\UserInterface\\SettingsController::saveAgency');

// settings/subprojectstates
$app->get('/settings/subprojectstates', 'MaidoProjects\\UserInterface\\SettingsController::getSubprojectStatesOverview');
$app->get('/settings/subprojectstate/new', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->get('/settings/subprojectstate/change/{nId}', 'MaidoProjects\\UserInterface\\SettingsController::formSubprojectState');
$app->post('/settings/subprojectstate/save', 'MaidoProjects\\UserInterface\\SettingsController::saveSubprojectState');


$app->get('/livescreen/client/{nId}', 'MaidoProjects\\UserInterface\\LivescreenController::getClient');
$app->get('/livescreen/agency/{nId}', 'MaidoProjects\\UserInterface\\LivescreenController::getAgency');
$app->get('/livescreen/projectmanager/{nId}', 'MaidoProjects\\UserInterface\\LivescreenController::getProjectManager');
$app->get('/livescreen/subprojectstate/{nId}', 'MaidoProjects\\UserInterface\\LivescreenController::getSubprojectState');


// CTFO
$app->get('/ctfo', 'MaidoProjects\\UserInterface\\CTFOController::analyzeBuckaroo');


// start
$app->run();


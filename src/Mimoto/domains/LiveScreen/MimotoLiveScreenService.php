<?php

// classpath
namespace Mimoto\LiveScreen;

// Mimoto classes
use Mimoto\LiveScreen\MimotoLiveScreenUtils;
use Mimoto\library\entities\MimotoEntity;
use Mimoto\library\entities\MimotoEntityUtils;


/**
 * MimotoLiveScreenService
 *
 * @author Sebastian Kersten
 */
class MimotoLiveScreenService
{
    
    // config
    var $_aEntities;
    
    var $_app;
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($aEntities, $app)
    {
        
        // register
        $this->_aEntities = $aEntities;
        
        // TEMP - register - #todo - FIX THIS!!!
        $this->_app = $app;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Handle event
     */
    public function handleRequest($sRequest, $data, $config)
    {
        
        switch($sRequest)
        {
            case 'dataUpdate':
                
                $this->dataUpdate($data, $config);
                break;
            
            case 'dataCreate':
                
                $this->dataCreate($data, $config);
                break;
            
            
            default:
                
                die("MimotoLiveScreenService: Unknown request '".$sRequest."'");
        }
    }
    
    /**
     * Get entity by type and id
     * @param string $sEntityType
     * @param int $nEntityId
     * @return entity
     */
    public function getEntityByTypeAndId($sEntityType, $nEntityId)
    {
        // validate
        if (!isset($this->_aEntities[$sEntityType])) { return; }
        
        
        // register
        $entityConfig = $this->_aEntities[$sEntityType];
        $entityService = $this->_app[$entityConfig->service];
        $entityMethod = $entityConfig->method;
        
        // #todo - exception afvangen, etc etc
        
        // load
        $entity = $entityService->$entityMethod($nEntityId);
        
        // send
        return $entity;
    }
    
    /**
     * Get entity template by type and id
     * @param string $sEntityType
     * @param string $sTemplateId
     * @return string The location to the twig template
     */
    public function getEntityTemplateTypeAndId($sEntityType, $sTemplateId)
    {
        // validate
        if (!isset($this->_aEntities[$sEntityType])) { return; }
        
        
        // register
        $entityConfig = $this->_aEntities[$sEntityType];
        
        // load
        $sTemplate = $entityConfig->templates[$sTemplateId];
        
        // send
        return $sTemplate;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Manage data update
     * @param MimotoEntity $entity
     * @param object $config
     */
    private function dataUpdate(MimotoEntity $entity, $config)
    {

        // register
        $nEntityId = $entity->getId();
        $sEntityType = $entity->getEntityType();
        
        // init
        $data = (object) array();
        
        // setup
        $data->entityId = $nEntityId;
        $data->entityType = $sEntityType;
        
        // init
        $data->values = array();
        $aModifiedValues = $entity->getModifiedValues();        
        
        // verify
        if (isset($config->properties))
        {

            // register
            $aConfigProperties = $config->properties;
            $nConfigPropertyCount = count($aConfigProperties);
            
            // load properties
            for ($nConfigPropertyIndex = 0; $nConfigPropertyIndex < $nConfigPropertyCount; $nConfigPropertyIndex++)
            {
                // read
                $sPropertyName = $aConfigProperties[$nConfigPropertyIndex];
                
                
                // find
                $nSeperatorPos = strpos($sPropertyName, '.');
                
                // separate
                $sMainPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, 0, $nSeperatorPos) : $sPropertyName;
                $sSubPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, $nSeperatorPos + 1) : '';
                
                
                // check if property exists and value modified
                if (!$entity->hasProperty($sMainPropertyName) || !isset($aModifiedValues[$sMainPropertyName])) continue;
                
                
                // init
                $valueForBroadcast = (object) array();
                
                // compose
                $valueForBroadcast->value = $entity->getValue($sMainPropertyName);
                $valueForBroadcast->mls_value = MimotoLiveScreenUtils::formatAimlessValue($entity->getEntityType(), $entity->getId(), $sMainPropertyName);
                

                // verify
                if (!empty($sSubPropertyName))
                {
                    // load
                    $subentity = $entity->getValue($sMainPropertyName);
                    
                    // validate
                    if (MimotoEntityUtils::isEntity($subentity))
                    {
                        
                        // check if property exists
                        if ($subentity->hasProperty($sSubPropertyName))
                        {
                            // compose
                            $valueForBroadcast->value = $subentity->getValue($sSubPropertyName);
                            $valueForBroadcast->mls_value_entity = MimotoLiveScreenUtils::formatAimlessSubvalue($subentity->getEntityType(), $subentity->getId(), $sSubPropertyName);
                        }
                    }
                }
                
                // store
                $data->values[] = $valueForBroadcast;
            }
        }
        
        
        // 1. dit gaat via async, het is efficienter om de rest af te handelen via deze directe route (denk aan "modified")
        // 2. handel eerst alles rondom de nieuwe data af!
        
        
        if (!empty($data->values)) { $this->sendPusherEvent('Aimless', 'data.update', $data); }
        
        //$this->sendPusherEvent('livescreen', 'popup.open', (object) array('url' => '/project/new'));
        //$this->sendPusherEvent('livescreen', 'page.change', (object) array('url' => '/forecast'));
    }
    
    /**
     * Manage data create
     * @param MimotoEntity $entity
     * @param object $config (unused for now)
     */
    private function dataCreate(MimotoEntity $entity, $config)
    {

        // register
        $nEntityId = $entity->getId();
        $sEntityType = $entity->getEntityType();
        
        // init
        $data = (object) array();
        
        // setup
        $data->entityId = $nEntityId;
        $data->entityType = $sEntityType;
        
        // send
        $this->sendPusherEvent('livescreen', 'data.create', $data);
    }
    
    /**
     * Send Pusher event - #todo - async
     * @param type $sChannel
     * @param type $sEvent
     * @param type $data
     */
    private function sendPusherEvent($sChannel, $sEvent, $data)
    {
        
//        require_once('pusher.php');
//        
//        $options = array(
//            'cluster' => 'eu',
//            'encrypted' => true
//        );
//
//        $pusher = new \Pusher(
//            '55152f70c4cec27de21d',
//            '7e72297e347e339cd241',
//            '185150',
//            $options
//        );

        //$data['message'] = $sMessage;
//        $pusher->trigger($sChannel, $sEvent, $data);
        
        
        $client= new \GearmanClient();
        $client->addServer();
        
        $result = $client->doBackground("sendUpdate", json_encode(array(
            'sChannel' => $sChannel,
            'sEvent' => $sEvent,
            'data' => $data
        )));
    }
    
}



        
        
        
        
        //stuur
        
        // gooi in Gearman
        
        
        //LivescreenMessage (model) #todo
        
        
        // generieke livescreen API ingang, met ID voor object o.i.d.
        // #YES: mapping -> url vs welk model, id etc
        // of fields kan directe data zijn
        
        
        
        
        // only broadcast changed properties ->
        // model set -> save to modified -> track changes, default aan na uitgeven entity
        
        //if has values -> replace values
        //if component && id -> reload component
        //if (componen && new-id -> load and add 
        

//            
//                // entity.getModifiedFields
//                
//                // if (no poperties changed) -> update, "force component update" als setting
//                
//                echo 'eventType = '.$event->getType()."\n";
//                
//                
//            // configs zijn low effort (event -> action, load config gegevens)
//
//
//            entity = 'client'
//            id = extracted from entity
//            property -> get from mapping
//        
//       



// connect elements from template -> send content, voorzien van meta data
// auto update, connect field with event -> mapping ->type = component (via url) of field (via direct value)

// ----------> ListComponent
// gearman -> type-async -> in jobserver
// listener class -> start van sequence
// generaliseer PusherEventHandler en pas toe op de 4 pagina's
// scheduled requests/actions (ActionSequence)
// Queue met statusupdates, bijwerking en monitoring



// validate validity of the client monitor (auto-reboot)
// data event
// component event
// page event
// popup event -> auto popup with message of reboot
// vraag huidige staat op bij de server (save state zoals de client monitor)
// State per gebruiker. start waar je was gebleven.



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
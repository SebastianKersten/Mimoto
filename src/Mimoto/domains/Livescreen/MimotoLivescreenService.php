<?php

// classpath
namespace Mimoto\Livescreen;

// Mimoto classes
use Mimoto\Entity\MimotoEntity;


/**
 * MimotoLivescreenService
 *
 * @author Sebastian Kersten
 */
class MimotoLivescreenService
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
                
                die("MimotoLivescreenService: Unknown request '".$sRequest."'");
        }
    }
    
    
    
    private function dataUpdate(MimotoEntity $entity, $config)
    {

        // register
        $nEntityId = $entity->getId();
        $sEntityType = $entity->getEntityType();
        
        // init
        $data = (object) array();
        
        // setup
        $data->type = 'livescreen'; // LivescreenMessage apart model)
        $data->entityId = $nEntityId;
        $data->entityType = $sEntityType;
        
        
        $data->values = array();
        
        
        // verify
        if (isset($config->mapping))
        {

            // register
            $mapping = $config->mapping;
            $nMappingCount = count($mapping);


            // load properties
            for ($nMappingIndex = 0; $nMappingIndex < $nMappingCount; $nMappingIndex++)
            {
                // read
                $map = $mapping[$nMappingIndex];

                // prepare
                $getter = 'get'.$map->property;
                
                $data->values[$map->valueName] = $entity->$getter();
            }
        }
        
        // dom, internal template id's direct live update, of replace entire element

        $this->sendPusherEvent('livescreen', 'data.update', $data);
        //$this->sendPusherEvent('livescreen', 'popup.open', (object) array('url' => '/project/new'));
    }
     
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
     * Get entity by type and id
     * @param type $sEntityType
     * @param type $nId
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
    
    
    private function sendPusherEvent($sChannel, $sEvent, $data)
    {
        
        require_once('pusher.php');
        
        $options = array(
            'cluster' => 'eu',
            'encrypted' => true
        );

        $pusher = new \Pusher(
            '55152f70c4cec27de21d',
            '7e72297e347e339cd241',
            '185150',
            $options
        );

        //$data['message'] = $sMessage;
        $pusher->trigger($sChannel, $sEvent, $data);
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
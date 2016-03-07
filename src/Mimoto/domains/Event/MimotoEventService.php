<?php

// classpath
namespace Mimoto\Event;


/**
 * EventService
 *
 * @author Sebastian Kersten
 */
class MimotoEventService
{
    
    // services
    private $_dispatcher;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($dispatcher)
    {
        // register
        $this->_dispatcher = $dispatcher;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Send update
     * @param string $sEvent
     * @param event $event
     */
    public function sendUpdate($sEvent, $data)
    {
        // if ($data == Symfony event) -> forward
        $event = $data;
        // broadcast to system
        $this->_dispatcher->dispatch($sEvent, $event);
        
        // else if implements/extends MimotoEntity -> check for actions
        $entity = $data;
        
        
        $sEntityName = $entity->getEntityName();
        
        
        // load
        $aActions = $this->getActionsByEvent($sEvent); //$this->_ActionService->getActionsByEvent($sEvent);
        $nActionCount = count($aActions);
        
        
        for ($i = 0; $i < $nActionCount; $i++)
        {
            // register
            $action = $aActions[$i];
            
            $sService = $action->service; // 'LivescreenService';
            $sRequest = $action->request; // 'updateUserInterface';
            //$config
            
            
            
            
            
            // init
            /*$trigger = (object) array();

            $trigger->event = 'client.updated';

            $trigger->action = (object) array();
            $trigger->action->service = 'LivescreenService';
            $trigger->action->entity = 'client'; // get from entity
            $trigger->action->mapping = [
                (object) array('property' => 'Name', 'livescreenid' => 'name')
            ];

            
            $data = (object) array();
            
            $data->type = 'livescreen';

            $data->ajax = (object) array();
            $data->ajax->url = '/livescreen/'.$sEntityName.'/'.$entity->getId();
            $data->ajax->method = 'GET';
            //$data->ajax->data = (object) array('bla' => 'yeahBlaYeah!');
            $data->ajax->dataType = 'html';

            $data->dom = (object) array();
            $data->dom->containerId = '#simplelist';
            $data->dom->objectId = '#simplelist_item_'.$agencyEvent->getAgency()->getId();

            
            
            

            // #todo - property map Model

            // id = vast gegeven
            // configs zijn low effort (event -> action, load config gegevens)


            


            resulteert in:

            $trigger->livescreenid = 'client.id';


            entity = 'client'
            id = extracted from entity
            property -> get from mapping

            */
            
            
        }
        
        /* volg
        
        $sEvent
        
        
        
        MimotoEvent->getEntity (volgt MimotoEntity / MimotoModel)
        
        
        // init
        $aTriggers = array();
        
        
        // --- trigger 1 ---
        
        // init
        $trigger = (object) array();
        
        $trigger->event = 'client.created';
        
        $trigger->action = (object) array();
        $trigger->action->service = 'MailService';
        
        $trigger->action->config = array();
        $trigger->action->config['template.html'] = '/src/MaidoProjects/userinterface/templates/emails/welcome_html.twig';
        $trigger->action->config['template.plaintext'] = '/src/MaidoProjects/userinterface/templates/emails/welcome_plaintext.twig';
        
        // simple . seperated syntax
        
        // store
        $aTriggers[] = $trigger;
        
        
        load eventlisteners json-configs in memcache
        aparte classes voor maken
        
        
        // init
        $trigger = (object) array();
        
        $trigger->event = 'client.created';
        
        $trigger->action = (object) array();
        $trigger->action->service = 'webevent';
        $trigger->action->mapping = ;
        
        $trigger->livescreenid = 'client.id';
        
        
        
                
        // store
        $aTriggers[] = $trigger;
                
                
        
        // --- trigger 2 ---
        
        // init
        $trigger = (object) array();
        
        $trigger->event = 'client.updated';
        
        $trigger->action = (object) array();
        $trigger->action->service = 'webevent';
        
        
        $trigger->action->entity = 'client';
        
        
        // #todo - property map Model
        
        // id = vast gegeven
        // configs zijn low effort (event -> action, load config gegevens)
        
        
        $trigger->action->mapping = [
            (object) array('property' => 'Name', 'livescreenid' => 'name')
        ];
        
        
        resulteert in:
        
        $trigger->livescreenid = 'client.id';
        
        
        entity = 'client'
        id = extracted from entity
        property -> get from mapping
        
        
        
        */
                
                
        //$aTriggers[] = $trigger;
        
        
         //generiek data event met types geschikt voor sequence handling
        
        //$this->_dispatcher->dispatch($sEvent, $event); // type in event, MimotoEvent
        
        
        // schedule once (bijv. daily digest)
        // tasklist heeft id, en individuele tasks worden individueel getracked
        // uniek ID of niet (overwrite -> use Redis)
        // WebeventService of in EventService
        // sync, async, public
        
        //generieke EventListener handelt configs af
        
        //Hoe ziet een config eruit:
    }
    
     /**
     * Send request
     * @param string $sEvent
     * @param event $event
     */
    public function sendRequest($sEvent, $event)
    {
        $this->_dispatcher->dispatch('REQUEST', $event);
    }
    
    
    
    private function getActionsByEvent($sEvent)
    {
        
        // FOR NOW - only respond to client.update
        
        // init
        $aActions = [];
        
        // for dev puposes, focus on 1 event and action first
        if ($sEvent != 'client.updated') { return $aActions; }
        
        
        
        $action = (object) array();
        
        $action->service = 'LivescreenService';
        $action->request = 'updateUserInterface';
        
        
        $action->config = (object) array(
            'mapping' => [
                (object) array('property' => 'Name', 'livescreenid' => 'name')
            ]
        );
        
        
        // register
        $aActions[] = $action;
    }
    
}


// track changes array met key values (boolean setter)
// dispatch pass regular event which extends MimotoEvent
// met setEntity (via constructor) en getEntity
// entitynaam uit classnaam halen (getNameOfClass)
// dispatch forward regular event (ClientEvent extends MimotoEvent etc)
// handle actions / sequence etc
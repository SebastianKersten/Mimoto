<?php

// classpath
namespace Mimoto\Event;

// Mimoto classes
use Mimoto\Event\MimotoEvent;

// Symfony classes
use Symfony\Component\EventDispatcher\Event;


/**
 * EventService
 *
 * @author Sebastian Kersten
 */
class MimotoEventService
{
    
    // utils
    private $_dispatcher;
    
    // services
    private $_aServices;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($dispatcher, $LivescreenService)
    {
        // register
        $this->_dispatcher = $dispatcher;
        
        // register services
        $this->_aServices = [
            'LivescreenService' => $LivescreenService//,
            //'MailService' => $MailService
        ];
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Send update
     * @param string $sEvent
     * @param event $event
     */
    public function sendUpdate($sEvent, $event)
    {
        
        // broadcast to system
        if ($event instanceof Event) { $this->_dispatcher->dispatch($sEvent, $event); }
        
        
        // validate
        if (!($event instanceof MimotoEvent)) return;
        
        
        $entity = $event->getEntity();
        $sEntityType = $entity->getEntityType();
        
        
        // load
        $aActions = $this->getActionsByEvent($sEvent); //$this->_ActionService->getActionsByEvent($sEvent);
        $nActionCount = count($aActions);
        
        
        for ($i = 0; $i < $nActionCount; $i++)
        {
            // register
            $action = $aActions[$i];
            
            // verify
            if (isset($this->_aServices[$action->service]))
            {
                
                // call
                $this->_aServices[$action->service]->handleRequest($action->request, $event->getEntity(), $action->config);
            }
            
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
        //if ($sEvent != 'client.updated') { return $aActions; }
        
        
        $action = (object) array();
        
        $action->trigger = 'client.updated';
        $action->trigger = ['client.updated', 'agency.updated'];
        
        $action->service = 'LivescreenService';
        $action->request = 'updateUserInterface';
        
        
        $action->config = (object) array(
            'mapping' => [
                (object) array('property' => 'Name', 'livescreenid' => 'name')
            ]
        );
        
        
        // register
        $aActions[] = $action;
        
        
        
        // send
        return $aActions;
    }
    
}

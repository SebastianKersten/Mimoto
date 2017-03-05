<?php

// classpath
namespace Mimoto\Event;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Event\MimotoEvent;

// Symfony classes
use Symfony\Component\EventDispatcher\Event;


/**
 * EventService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EventService
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
    public function __construct($dispatcher) //, $AimlessService)
    {
        // register
        $this->_dispatcher = $dispatcher;
        
        // register services
        $this->_aServices = [
            'AimlessService' => ''//,
            //'MailService' => $MailService
        ];
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    public function handleEvent()
    {
        
        // 1. handle async or direct events
        
        
//        $client= new \GearmanClient();
//        $client->addServer();
//        
//        $result = $client->doBackground("sendUpdate", json_encode(array(
//            'sChannel' => $sChannel,
//            'sEvent' => $sEvent,
//            'data' => $data
//        )));
    }
    
    
    
    /**
     * Send update
     * @param string $sEvent
     * @param event $event
     */
    public function sendUpdate($sEvent, $event) // 1. rename to async, or rewire
    {
        
        // broadcast to system
        if ($event instanceof Event) { $this->_dispatcher->dispatch($sEvent, $event); }

        // validate
        if (!($event instanceof MimotoEvent)) { return; }
        
        // load
        $aActions = $this->getActionsByEvent($sEvent); //$this->_ActionService->getActionsByEvent($sEvent);

        // trigger all actions
        $nActionCount = count($aActions);
        for ($nActionIndex = 0; $nActionIndex < $nActionCount; $nActionIndex++)
        {
            // register
            $action = $aActions[$nActionIndex];

            // verify
            //if (isset($this->_aServices[$action->service]))
            //{
                // setup
                $config = (isset($action->config)) ? $action->config : (object) array();
                
                if ($action->service == 'Aimless')
                {
                    // call
                    //$this->_aServices[$action->service]->handleRequest($action->request, $event->getEntity(), $config);
                    Mimoto::service('aimless')->handleRequest($action->request, $event->getEntity(), $config);
                }
            //}
            
        }

        
        /* 
        
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
        
  
        

        
        // #todo - property map Model
        
        // id = vast gegeven
        // configs zijn low effort (event -> action, load config gegevens)
        
        */
                
        
        
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
        // register
        $aAllActions = Mimoto::service('actions')->getAllActions();


        
        // --- filter ---
        
        
        // prepare
        $aEventParts = explode('.', $sEvent);
        
        
        // init
        $aFilteredActions = [];
        
        // search
        $nAllActionsItemCount = count($aAllActions);
        for ($i = 0; $i < $nAllActionsItemCount; $i++)
        {
            
            // register
            $action = $aAllActions[$i];

            // init
            $bIsValidTrigger = true;
            
            // read
            $aTriggers = (is_array($action->trigger)) ? $action->trigger : [$action->trigger];
            
            $nTriggerCount = count($aTriggers);
            for ($j = 0; $j < $nTriggerCount; $j++)
            {
                // register
                $sTrigger = $aTriggers[$j];
                
                // prepare
                $aTriggerParts = explode('.', $sTrigger);
                
                // init
                $bIsValidTrigger = true;
                
                // validate
                if (count($aTriggerParts) != count($aEventParts))
                {
                    $bIsValidTrigger = false;
                }
                else
                {
                    $nTriggerPartCount = count($aTriggerParts);
                    for ($k = 0; $k < $nTriggerPartCount; $k++)
                    {
                        if ($aTriggerParts[$k] != '*' && $aTriggerParts[$k] !== $aEventParts[$k])
                        {
                            $bIsValidTrigger = false;
                            break;
                        }
                    }
                }
                
                // valid trigger found, so stop looking
                if ($bIsValidTrigger) { break; }
            }
            
            // register
            if ($bIsValidTrigger) { $aFilteredActions[] = $action; }
        }

        // send
        return $aFilteredActions;
    }
    
}

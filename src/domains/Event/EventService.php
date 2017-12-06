<?php

// classpath
namespace Mimoto\Event;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Event\ConditionalTypes;
use Mimoto\Event\MimotoEvent;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;

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
    public function __construct($dispatcher) //, $OutputService)
    {
        // register
        $this->_dispatcher = $dispatcher;
        
        // register services
        $this->_aServices = [
            'OutputService' => ''//,
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
        $aActions = $this->getActionsByEvent($sEvent);


        // trigger all actions
        $nActionCount = count($aActions);
        for ($nActionIndex = 0; $nActionIndex < $nActionCount; $nActionIndex++)
        {
            // register
            $action = $aActions[$nActionIndex];


            // --- filter


            if (isset($action->conditionals) && is_array($action->conditionals) && count($action->conditionals) > 0)
            {
                // init
                $bValidated = true;

                // register
                $eInstance = $event->getEntity();

                // filter
                $nConditionalCount = count($action->conditionals);
                for ($nConditionalIndex = 0; $nConditionalIndex < $nConditionalCount; $nConditionalIndex++)
                {
                    // register
                    $conditional = $action->conditionals[$nConditionalIndex];

                    // verify
                    if (
                        empty($conditional->propertyName) || empty($conditional->type)
                        || !$eInstance->hasProperty($conditional->propertyName)
                        || $eInstance->getPropertyType($conditional->propertyName) != MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE
                    )
                    {
                        $bValidated = false;
                        break;
                    }

                    // register
                    $sPreviousValue = $eInstance->get($conditional->propertyName, false, true);
                    $sNewValue = $eInstance->get($conditional->propertyName);

                    // prepare
                    $sValue1ToCompare = (!empty($conditional->value1)) ? $conditional->value1 : '';
                    $sValue2ToCompare = (!empty($conditional->value2)) ? $conditional->value2 : '';

                    // verify
                    switch($conditional->type)
                    {
                        case ConditionalTypes::CHANGED:

                            if ($sNewValue == $sPreviousValue) $bValidated = false;
                            break;

                        case ConditionalTypes::CHANGED_INTO:

                            if ($sNewValue == $sPreviousValue || $sNewValue != $sValue1ToCompare) $bValidated = false;
                            break;

                        case ConditionalTypes::CHANGED_FROM:

                            if ($sNewValue == $sPreviousValue || $sPreviousValue != $sValue1ToCompare) $bValidated = false;
                            break;

                        case ConditionalTypes::CHANGED_FROM_INTO:

                            if ($sNewValue == $sPreviousValue || $sPreviousValue != $sValue1ToCompare || $sNewValue != $sValue2ToCompare) $bValidated = false;
                            break;

                        case ConditionalTypes::EQUALS:

                            if ($sNewValue != $sValue1ToCompare) $bValidated = false;
                            break;

                        case ConditionalTypes::DOES_NOT_EQUAL:

                            if ($sNewValue == $sValue1ToCompare) $bValidated = false;
                            break;

                        case ConditionalTypes::CONTAINS:

                            if (!preg_match('/'.$sValue1ToCompare.'/U', $sNewValue, $aMatches)) $bValidated = false;
                            break;

                        case ConditionalTypes::DID_NOT_CHANGE:

                            if ($sNewValue != $sPreviousValue) $bValidated = false;
                            break;
                    }
                }

                // verify
                if (!$bValidated) continue;
            }


            // --- filter (end) ---


            // setup
            $config = (isset($action->config)) ? $action->config : (object) array();

            if ($action->service == 'Aimless')
            {
                // call
                //$this->_aServices[$action->service]->handleRequest($action->request, $event->getEntity(), $config);
                Mimoto::service('output')->handleRequest($action->request, $event->getEntity(), $config);
            }
            else if (isset($action->owner)  && ($action->owner == 'project' ||  $action->owner == Mimoto::MIMOTO))
            {
                switch($action->owner)
                {
                    case Mimoto::MIMOTO:

                        $sServicesPath = dirname(dirname(dirname(__FILE__))).'/services/';
                        break;

                    case 'project':

                        $sServicesPath = Mimoto::value('ProjectConfig.root').Mimoto::value('ProjectConfig.serviceroot');
                        break;
                }


                if (!empty($sServicesPath) && isset($action->service) && isset($action->service->name) && isset($action->function))
                {
                    // 1. verify
                    if (!class_exists($action->service->name))
                    {
                        // a. prepare
                        $sClassFile = $sServicesPath.$action->service->file;

                        // b. verify
                        if (file_exists($sClassFile))
                        {
                            // load
                            require_once($sClassFile);
                        }
                    }

                    // 2. init class
                    $service = new $action->service->name;

                    // 3. verify
                    if (method_exists($service, $action->function))
                    {
                        // a. clone
                        $settings = unserialize(serialize($action->settings));

                        // b. apply variables (the & allows for direct editing of the value)
                        foreach($settings as &$setting)
                        {
                            // 2. replace enter or init
                            if (!empty($setting)) $setting = preg_replace('/\\\n/', chr(13), $setting);

                            // 3. get variables
                            if (preg_match_all('/({{.*?}})/', $setting, $aMatches))
                            {
                                // remove full match
                                array_splice($aMatches, 0, 1);


                                $nSubmatchCount = count($aMatches);
                                for ($nSubmatchIndex = 0; $nSubmatchIndex < $nSubmatchCount; $nSubmatchIndex++)
                                {
                                    // register
                                    $aSubmatches = $aMatches[$nSubmatchIndex];

                                    $nVarCount = count($aSubmatches);
                                    for ($nVarIndex = 0; $nVarIndex < $nVarCount; $nVarIndex++)
                                    {
                                        // a. register
                                        $sMatch = $aSubmatches[$nVarIndex];

                                        // b. isolate
                                        $sPropertyName = trim(substr($sMatch, 2, strlen($sMatch) - 4));

                                        // c. validate
                                        if (!MimotoDataUtils::validatePropertyName($sPropertyName) || !$event->getEntity()->hasProperty($sPropertyName)) continue;

                                        // d. inject
                                        $setting = preg_replace('/'.$sMatch.'/', $event->getEntity()->get($sPropertyName), $setting);
                                    }
                                }


                            }
                        }

                        // a. call and pass clone of settings (unserialize/serialize)
                        call_user_func([$service, $action->function], $event->getEntity(), $settings);
                    }
                }

            }

        }
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
            $bHasValidTrigger = false;
            
            // read
            $aTriggers = (is_array($action->trigger)) ? $action->trigger : [$action->trigger];
            
            $nTriggerCount = count($aTriggers);
            for ($j = 0; $j < $nTriggerCount; $j++)
            {
                // register
                $sTrigger = $aTriggers[$j];

                // prepare
                $aTriggerParts = explode('.', $sTrigger);
                
                // validate
                if (count($aTriggerParts) != count($aEventParts)) continue;

                // search
                $nTriggerPartCount = count($aTriggerParts);
                $bIsValidTrigger = true;
                for ($k = 0; $k < $nTriggerPartCount; $k++)
                {
                    if ($aTriggerParts[$k] != '*' && $aTriggerParts[$k] !== $aEventParts[$k])
                    {
                        $bIsValidTrigger = false;
                        break;
                    }
                }
                
                // valid trigger found, so register and stop looking
                if ($bIsValidTrigger)
                {
                    $bHasValidTrigger = true;
                    break;
                }
            }
            
            // register
            if ($bHasValidTrigger) { $aFilteredActions[] = $action; }
        }

        // send
        return $aFilteredActions;
    }
    
}

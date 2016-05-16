<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\MimotoAimlessUtils;
use Mimoto\Data\MimotoEntity;
use Mimoto\library\entities\MimotoEntityUtils;


/**
 * MimotoAimlessService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoAimlessService
{
    
    // config
    var $_aViewModels;
    
    var $_app;
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($aViewModels, $app)
    {
        
        // register
        $this->_aViewModels = $aViewModels;
        
        // TEMP - register - #todo - FIX THIS!!!
        $this->_app = $app;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    public function renderEntityView(MimotoEntity $entity, $sTemplateId)
    {
        
        try {
            $sEntityTemplate = $this->_aViewModels[$entity->getEntityType()][$sTemplateId];
        }
        catch (\Exception $e)
        {
            // #todo
        }            
        
        //echo $sEntityTemplate;
        
        // 1. viewmodels hebben template + platte json data
        // 2. platte json data = cached
        // 3. ViewModelService prepareert de data
        // 4. Aimless is enkel een util die gebruikt wordt
        // 5. zo read-only data, editable in juiste omgezing, en toch snel heel snel/efficient
        // 6. Aimless service rendert volledig
        
        
        
        // output
        return $this->_app['twig']->render(
            $sEntityTemplate,
            array(
                'data' => $entity
            )
        );
    }
    
    
    // --- events ---
    
    
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
                
                die("MimotoAimlessService: Unknown request '".$sRequest."'");
        }
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
        $data->updated = array();
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
                $valueForBroadcast->property = $sPropertyName;
                

                // verify
                if (!empty($sSubPropertyName))
                {
                    // load
                    $subentity = $entity->getValue($sMainPropertyName);
                    
                    // init
                    $valueForBroadcast->origin = (object) array();
                    
                    // validate
                    if (MimotoEntityUtils::isEntity($subentity))
                    {
                        // check if property exists
                        if ($subentity->hasProperty($sSubPropertyName))
                        {
                            // compose
                            $valueForBroadcast->value = $subentity->getValue($sSubPropertyName);   
                            $valueForBroadcast->origin->entityType = $subentity->getEntityType();
                            $valueForBroadcast->origin->entityId = $subentity->getId();
                            $valueForBroadcast->origin->property = $sSubPropertyName;
                        }
                    }
                    else
                    {
                        // compose
                        $valueForBroadcast->origin->entityType = $sMainPropertyName;
                        $valueForBroadcast->origin->property = $sSubPropertyName;
                    }
                }
                
                // store
                $data->updated[] = $valueForBroadcast;
            }
        }
        
        
        // 1. dit gaat via async, het is efficienter om de rest af te handelen via deze directe route (denk aan "modified")
        // 2. handel eerst alles rondom de nieuwe data af!
        
        
        if (!empty($data->updated)) { $this->sendPusherEvent('Aimless', 'data.update', $data); }
        
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
        $this->sendPusherEvent('Aimless', 'data.create', $data);
    }
    
    /**
     * Send Pusher event - #todo - async
     * @param type $sChannel
     * @param type $sEvent
     * @param type $data
     */
    private function sendPusherEvent($sChannel, $sEvent, $data)
    {
        // init
        $client= new \GearmanClient();
        
        // setup
        $client->addServer();
        
        // $result =
        // execute
        $client->doBackground("sendUpdate", json_encode(array(
            'sChannel' => $sChannel,
            'sEvent' => $sEvent,
            'data' => $data
        )));
    }
    
}

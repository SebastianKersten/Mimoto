<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\MimotoAimlessUtils;
use Mimoto\Data\MimotoEntity;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\library\entities\MimotoEntityUtils;

// Silex classes
use Silex\Application;


/**
 * MimotoAimlessService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoAimlessService
{
    
    // services
    private $_MimotoEntityService;
    private $_MimotoAimlessService;
    private $_TwigService;
    
    // config
    var $_aComponents;
    
    
    
    const DBTABLE_COMPONENT = '_mimoto_component';
    const DBTABLE_COMPONENTCONDITIONAL = '_mimoto_componentconditional';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($MimotoEntityService, $TwigService)
    {
        // register
        $this->_MimotoEntityService = $MimotoEntityService;
        $this->_MimotoAimlessService = $this;
        $this->_TwigService = $TwigService;
        
        // load and register
        $this->_aComponents = $this->loadComponents();
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Create component
     * @param string $sComponentName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessComponent
     */
    public function createComponent($sComponentName, $entity = null)
    {
        // init and send
        return $component = new AimlessComponent($sComponentName, $entity, $this->_MimotoAimlessService, $this->_MimotoEntityService, $this->_TwigService);
    }
    
    /**
     * Create form
     * @param string $sTemplateName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessForm
     */
    public function createForm($sFormName, $entity = null)
    {
        // init and send
        return $form = new AimlessForm($sFormName, $entity, $this->_MimotoAimlessService, $this->_MimotoEntityService, $this->_TwigService);
    }






    public function getTemplate($sTemplateName, $entity = null)
    {
        for ($i = 0; $i < count($this->_aComponents); $i++)
        {
            $template = $this->_aComponents[$i];
            
            if ($template->name === $sTemplateName)
            {
                if (count($template->conditionals) > 0 && $entity !== null)
                {
                    $bValidated = true;
                    for ($j = 0; $j < count($template->conditionals); $j++)
                    {
                        $conditional = $template->conditionals[$j];
                        
                        if ($entity->getValue($conditional->key) !== $conditional->value)
                        {
                            $bValidated = false;
                            break;
                        }
                    }
                    
                    if ($bValidated) { return $template->file; }
                }
                else
                {
                    return $template->file;
                }
            }
        }
        
        
        die("MimotoAimlessService says: Template '$sTemplateName' not found");
        
        // 1. broadcast webevent for debugging purposes
        // 2. standaard report error (error level)
        
    }
    
    
    
    private function loadComponents()
    {
        
        // check if in memory, else load from mysql:
        
        
        // init
        $aTemplates = [];


        // load all templates
        $sql = 'SELECT * FROM '.self::DBTABLE_COMPONENT;
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $entity = (object) array(
                'id' => $row['id'],
                'name' => $row['name'],
                'file' => $row['file'],
                'created' => $row['created'],
                'conditionals' => []
            );

            // store
            $aTemplates[] = $entity;
        }

        // load all conditionals
        $sql = 'SELECT * FROM '.self::DBTABLE_COMPONENTCONDITIONAL;
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            $conditional = (object) array(
                'id' => $row['id'],
                'template_id' => $row['template_id'],
                'key' => $row['key'],
                'value' => $row['value'],
                'created' => $row['created']
            );
            
            for ($j = 0; $j < count($aTemplates); $j++)
            {
                $template = $aTemplates[$j];
                
                if ($template->id === $conditional->template_id)
                {
                    $template->conditionals[] = $conditional;
                }
            }
        }
        
        return $aTemplates;
    }
    
    
    // --- events ---
    
    
    /**
     * Handle event
     */
    public function handleRequest($sRequest, $data, $config)
    {
        
//        output('$sRequest', $sRequest);
//        output('$data', $data);
//        output('$config', $config);
        
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
        $aModifiedValues = $entity->getChanges();
        
        
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
                $valueForBroadcast->property = $sPropertyName;
                
                
                // read
                $sPropertyType = $entity->getPropertyType($sMainPropertyName);
                
                
                switch($sPropertyType)
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                        
                        $valueForBroadcast->value = $entity->getValue($sMainPropertyName);
                        
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
                        
                        break;
                        
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:
                        
                        // compose
                        $valueForBroadcast->collection = $aModifiedValues[$sMainPropertyName];
                        
                        // add properties for realtime filtered adding
                        for ($iAdded = 0; $iAdded < count($valueForBroadcast->collection->added); $iAdded++)
                        {
                            // register
                            $addedItem = $valueForBroadcast->collection->added[$iAdded];
                            
                            // setup
                            $addedItem->values = array();
                            
                            // load
                            $collectionItem = $this->_MimotoEntityService->get($addedItem->childEntityType->name, $addedItem->childId);
                            
                            
                            $aCollectionItemPropertyNames = $collectionItem->getPropertyNames();
                            
                            
                            for ($iPropertyName = 0; $iPropertyName < count($aCollectionItemPropertyNames); $iPropertyName++)
                            {
                                // register
                                $sCollectionItemPropertyName = $aCollectionItemPropertyNames[$iPropertyName];
                                
                                $addedItem->values[$sCollectionItemPropertyName] = $collectionItem->getValue($sCollectionItemPropertyName, true);
                            }
                            
                        }
                        
                        break;
                        
                }
                
                // store
                $data->updated[] = $valueForBroadcast;
            }
        }


        //output('Data to broadcast', $data);
        
        
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

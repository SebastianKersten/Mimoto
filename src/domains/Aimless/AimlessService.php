<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\entities\Component;
use Mimoto\Data\MimotoEntity;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Form\FormService;
use Mimoto\Log\LogService;


/**
 * AimlessService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class AimlessService
{
    
    // services
    private $_EntityService;
    private $_AimlessService;
    private $_LogService;
    private $_TwigService;
    private $_FormService;

    // config
    private $_aComponents;
    

    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($EntityService, FormService $FormService, LogService $LogService, $TwigService)
    {
        // register
        $this->_EntityService = $EntityService;
        $this->_FormService = $FormService;
        $this->_AimlessService = $this;
        $this->_LogService = $LogService;
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
    public function createComponent($sComponentName, $entity = null, $connection = null)
    {
        // init and send
        return new AimlessComponent($sComponentName, $entity, $connection, null, $this->_AimlessService, $this->_EntityService, $this->_LogService, $this->_TwigService);
    }

    /**
     * Create component wrapper
     * @param string $sComponentName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessComponentWrapper
     */
    public function createWrapper($sWrapperName, $sComponentName = null, $entity = null, $connection = null)
    {
        // init and send
        return new AimlessComponent($sComponentName, $entity, $connection, $sWrapperName, $this->_AimlessService, $this->_EntityService, $this->_LogService, $this->_TwigService);
    }

    /**
     * Create input
     * @param string $sComponentName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessInput
     */
    public function createInput($sComponentName, $entity = null, $connection = null, $sFieldName = null, $value = null)
    {
        // init and send
        return new AimlessInput($sComponentName, $entity, $connection, $sFieldName, $value, $this->_AimlessService, $this->_EntityService, $this->_LogService, $this->_TwigService);
    }

    /**
     * Create form
     * @param string $sTemplateName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessForm
     */
    public function createForm($sFormName, $xData, $options = null)
    {
        // init and send
        return new AimlessForm($sFormName, $xData, $options, $this->_AimlessService, $this->_EntityService, $this->_FormService, $this->_LogService, $this->_TwigService);
    }




    public function getComponentFile($sComponentName, MimotoEntity $entity = null)
    {
        $nComponentCount = count($this->_aComponents);
        for ($i = 0; $i < $nComponentCount; $i++)
        {
            $template = $this->_aComponents[$i];
            
            if ($template->name === $sComponentName)
            {
                if (count($template->conditionals) > 0 && $entity !== null)
                {
                    $bValidated = true;
                    $nConditionalCount = count($template->conditionals);
                    for ($j = 0; $j < $nConditionalCount; $j++)
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
        
        throw new \Exception("AimlessService says: Template '$sComponentName' not found");
        die("AimlessService says: Template '$sComponentName' not found");
        
        // 1. broadcast webevent for debugging purposes
        // 2. standaard report error (error level)
        
    }



    // --- aimless - dom util



    public function getComponentConditionalsAsString($sComponentName)
    {
        // 1. init
        $sComponentConditionals = '';

        // 2. find requested component
        $nComponentCount = count($this->_aComponents);
        for ($nComponentIndex = 0; $nComponentIndex < $nComponentCount; $nComponentIndex++)
        {
            $template = $this->_aComponents[$nComponentIndex];

            if ($template->name === $sComponentName)
            {
                if (count($template->conditionals) > 0)
                {
                    // init
                    $sComponentConditionals = '[';

                    // compose
                    $nConditionalCount = count($template->conditionals);
                    for ($nConditionalIndex = 0; $nConditionalIndex < $nConditionalCount; $nConditionalIndex++)
                    {
                        // register
                        $conditional = $template->conditionals[$nConditionalIndex];

                        // store
                        $sComponentConditionals .= $conditional->key;

                        // compose
                        if ($nConditionalIndex < $nConditionalCount - 1) $sComponentConditionals .= ',';
                    }

                    // compose
                    $sComponentConditionals .= ']';
                }

                break;
            }
        }

        // send
        return $sComponentConditionals;
    }




    private function loadComponents()
    {
        
        // check if in memory, else load from mysql:
        
        
        // init
        $aTemplates = [];


        // load all templates
        $stmt = Mimoto::service('database')->prepare('SELECT * FROM '.CoreConfig::MIMOTO_COMPONENT);
        $params = array();
        $stmt->execute($params);


        foreach ($stmt as $row)
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
        $stmt = Mimoto::service('database')->prepare('SELECT * FROM '.CoreConfig::MIMOTO_COMPONENTCONDITIONAL);
        $params = array();
        $stmt->execute($params);

        foreach ($stmt as $row)
        {
            $conditional = (object) array(
                'id' => $row['id'],
                'template_id' => $row['template_id'],
                'key' => $row['key'],
                'value' => $row['value'],
                'created' => $row['created']
            );

            $nTemplateCount = count($aTemplates);
            for ($j = 0; $j < $nTemplateCount; $j++)
            {
                $template = $aTemplates[$j];
                
                if ($template->id === $conditional->template_id)
                {
                    $template->conditionals[] = $conditional;
                }
            }
        }

        // add core components
        $aTemplates = array_merge($aTemplates, Component::getData());

        // send
        return $aTemplates;
    }


    
    // --- events ---
    
    
    /**
     * Handle event
     */
    public function handleRequest($sRequest, $data, $config)
    {
        switch($sRequest)
        {
            case 'dataUpdate':              $this->dataUpdate($data, $config); break;
            case 'dataCreate':              $this->dataCreate($data, $config); break;
            case 'sendSlackNotification':   $this->sendSlackNotification($data, $config); break;
            case 'createEntityTable':       Mimoto::service('config')->entityCreateTable($data); break;
            case 'updateEntityTable':       Mimoto::service('config')->entityUpdateTable($data); break;
            case 'onEntityPropertyCreated': Mimoto::service('config')->onEntityPropertyCreated($data); break;
            case 'onEntityPropertyUpdated': Mimoto::service('config')->onEntityPropertyUpdated($data); break;

            default:
                
                die("AimlessService: Unknown request '".$sRequest."'");
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
        $sEntityType = $entity->getEntityTypeName();
        
        // init
        $data = (object) array();
        
        // setup
        $data->entityId = $nEntityId;
        $data->entityType = $sEntityType;
        
        // init
        $data->changes = array();
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
                $valueForBroadcast->propertyName = $sPropertyName;

                
                
                // read
                $sPropertyType = $entity->getPropertyType($sMainPropertyName);
                
                
                switch($sPropertyType)
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                        // init
                        $valueForBroadcast->type = MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE;

                        $valueForBroadcast->value = $entity->getValue($sMainPropertyName);
                        
                        // verify
                        if (!empty($sSubPropertyName))
                        {
                            // load
                            $subentity = $entity->getValue($sMainPropertyName);

                            // init
                            $valueForBroadcast->origin = (object) array();

                            // validate
                            if (MimotoDataUtils::isEntity($subentity))
                            {
                                // check if property exists
                                if ($subentity->hasProperty($sSubPropertyName))
                                {
                                    // compose
                                    $valueForBroadcast->value = $subentity->getValue($sSubPropertyName);
                                    $valueForBroadcast->origin->entityType = $subentity->getEntityTypeName();
                                    $valueForBroadcast->origin->entityId = $subentity->getId();
                                    $valueForBroadcast->origin->propertyName = $sSubPropertyName;
                                }
                            }
                            else
                            {
                                // compose
                                $valueForBroadcast->origin->entityType = $sMainPropertyName;
                                $valueForBroadcast->origin->propertyName = $sSubPropertyName;
                            }
                        }
                        
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // init
                        $valueForBroadcast->type = MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY;

                        // compose
                        $valueForBroadcast->entity = null;

                        // validate
                        if (!empty($aModifiedValues[$sMainPropertyName]->added))
                        {
                            // register
                            $valueForBroadcast->entity = (object)array
                            (
                                'connection' => $aModifiedValues[$sMainPropertyName]->added[0]->toJSON(),
                                'data' => []
                            );
                        }

                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // init
                        $valueForBroadcast->type = MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION;

                        // compose
                        $valueForBroadcast->collection = (object) array();
                        $valueForBroadcast->collection->count = $aModifiedValues[$sMainPropertyName]->count;

                        // validate
                        if (!empty($aModifiedValues[$sMainPropertyName]->added))
                        {
                            // register
                            $aConnections = $aModifiedValues[$sMainPropertyName]->added;

                            // init
                            $valueForBroadcast->collection->added = [];


                            // add properties for realtime filtered removal
                            $nConnectionCount = count($aConnections);
                            for ($nAddedIndex = 0; $nAddedIndex < $nConnectionCount; $nAddedIndex++)
                            {
                                // register
                                $connection = $aConnections[$nAddedIndex];

                                // setup
                                $item = (object)array(
                                    'connection' => $connection->toJSON(),
                                    'data' => []
                                );



                                // load
                                $entity = $this->_EntityService->get($connection->getChildEntityTypeName(), $connection->getChildId());

                                // load
                                $aCollectionItemPropertyNames = $entity->getPropertyNames();

                                $aCollectionItemPropertyNameCount = count($aCollectionItemPropertyNames);
                                for ($nPropertyNameIndex = 0; $nPropertyNameIndex < $aCollectionItemPropertyNameCount; $nPropertyNameIndex++)
                                {
                                    // register
                                    $sCollectionItemPropertyName = $aCollectionItemPropertyNames[$nPropertyNameIndex];

                                    $item->data[$sCollectionItemPropertyName] = $entity->getValue($sCollectionItemPropertyName);
                                }


                                // store
                                $valueForBroadcast->collection->added[] = $item;
                            }
                        }



                        // validate
                        if (!empty($aModifiedValues[$sMainPropertyName]->removed))
                        {
                            // register
                            $aConnections = $aModifiedValues[$sMainPropertyName]->removed;

                            // init
                            $valueForBroadcast->collection->removed = [];


                            // add properties for realtime filtered removal
                            $aConnectionCount = count($aConnections);
                            for ($nRemovedIndex = 0; $nRemovedIndex < $aConnectionCount; $nRemovedIndex++)
                            {
                                // register
                                $connection = $aConnections[$nRemovedIndex];

                                // setup
                                $item = (object) array(
                                    'connection' => $connection->toJSON()
                                );

                                // store
                                $valueForBroadcast->collection->removed[] = $item;
                            }
                        };

                        
                        break;
                        
                }
                
                // store
                $data->changes[] = $valueForBroadcast;
            }
        }


        // --- connections

        // init
        $aConnections = [];

        $xChildEntityTypeId = Mimoto::service('config')->getEntityIdByName($entity->getEntityTypeName());


        // load all connections
        $sql =
            'SELECT * FROM '.CoreConfig::MIMOTO_CONNECTIONS_PROJECT.
            ' WHERE child_entity_type_id="'.$xChildEntityTypeId.'" && child_id="'.$entity->getId().'"'.
            ' ORDER BY parent_id ASC, sortindex ASC';


        foreach (Mimoto::service('database')->query($sql) as $row)
        {
            // compose
            $connection = (object) array(
                'connectionId' => $row['id'],
                'parentEntityType' => Mimoto::service('config')->getEntityNameById($row['parent_entity_type_id']),
                'parentPropertyName' => Mimoto::service('config')->getPropertyNameById($row['parent_property_id']),
                'parentId' => $row['parent_id']
            );

            // store
            $aConnections[] = $connection;
        }

        // connect
        if (!empty($aConnections)) $data->connections = $aConnections;
        
        
        // 1. dit gaat via async, het is efficienter om de rest af te handelen via deze directe route (denk aan "modified")
        // 2. handel eerst alles rondom de nieuwe data af!
        

        if (!empty($data->changes)) { $this->sendPusherEvent('Aimless', 'data.changed', $data); }
        
        /**
         * Exaamples:
         * $this->sendPusherEvent('livescreen', 'popup.open', (object) array('url' => '/project/new'));
         * $this->sendPusherEvent('livescreen', 'page.change', (object) array('url' => '/forecast'));
         */
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
        $sEntityType = $entity->getEntityTypeName();
        
        // init
        $data = (object) array();
        
        // setup
        $data->entityId = $nEntityId;
        $data->entityType = $sEntityType;
        
        // send
        $this->sendPusherEvent('Aimless', 'data.created', $data);
    }
    
    /**
     * Send Pusher event - #todo - async
     * @param type $sChannel
     * @param type $sEvent
     * @param type $data
     */
    private function sendPusherEvent($sChannel, $sEvent, $data)
    {
        // 1. only works if Gearman properly set up
        if (!class_exists('\GearmanClient')) return;


        // init
        $client= new \GearmanClient();

        try
        {
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
        catch (\Exception $e)
        {
            return;
        }
    }

    /**
     * Send Pusher event - #todo - async
     * @param type $sChannel
     * @param type $sEvent
     * @param type $data
     */
    private function sendSlackNotification($entity, $config)
    {
        // 1. only works if Gearman properly set up
        if (!class_exists('\GearmanClient')) return;

        // init
        $client= new \GearmanClient();

        try
        {
            // setup
            $client->addServer();


            // register
            $sTitle = $entity->getValue('title');
            $sDispatcher = $entity->getValue('dispatcher');
            $sMessage = $entity->getValue('message');

            // convert
            $sMessage = str_replace('<b>', '"', $sMessage);
            $sMessage = str_replace('</b>', '"', $sMessage);

            // compose
            $sSlackMessage = ">*$sTitle*\n>```$sMessage```\n>_From: $sDispatcher"."_";


            // $result =
            // execute
            $client->doBackground("sendSlackNotification", json_encode(array(
                'channel' => $config->channel,
                'message' => $sSlackMessage
            )));
            }
            catch (\Exception $e)
            {
                return;
            }
    }
}

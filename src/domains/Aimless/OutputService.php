<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Core\entities\ComponentConditional;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\FormattingUtils;
use Mimoto\Core\entities\Component;
use Mimoto\Data\MimotoEntity;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\EntityConfigUtils;
use Mimoto\Data\MimotoDataUtils;

use Mimoto\Form\FormService;
use Mimoto\Log\LogService;



/**
 * OutputService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class OutputService
{
    
    // services
    private $_DataService;
    private $_OutputService;
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
    public function __construct($DataService, FormService $FormService, LogService $LogService, $TwigService)
    {
        // register
        $this->_DataService = $DataService;
        $this->_FormService = $FormService;
        $this->_OutputService = $this;
        $this->_LogService = $LogService;
        $this->_TwigService = $TwigService;
        
        // load and register
        $this->_aComponents = $this->loadComponents();
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Create page
     * @param string $sComponentName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessComponent
     */
    public function createPage($param1 = null, $param2 = null)
    {
        // default
        $sComponentName = Mimoto::value('page.layout.default');
        $entity = null;

        //
        if (!empty($param1) && $param1 instanceof MimotoEntity) $entity = $param1;
        if (!empty($param2) && $param2 instanceof MimotoEntity) $entity = $param2;

        if (!empty($param1) && is_string($param1)) $sComponentName = $param1;
        if (!empty($param2) && is_string($param2)) $sComponentName = $param2;

        // verify
        if (empty($sComponentName)) Mimoto::error("Please read the Mimoto::service('output')->createPage() documentation [link]");

        // init and send
        return new AimlessComponent($sComponentName, $entity, null, null, null, $this->_OutputService, $this->_DataService, $this->_LogService, $this->_TwigService);
    }

    /**
     * Create popup
     * @param string $sComponentName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessComponent
     */
    public function createPopup($param1 = null, $param2 = null)
    {
        // default
        $sComponentName = Mimoto::value('popup.layout.default');
        $entity = null;

        //
        if (!empty($param1) && $param1 instanceof MimotoEntity) $entity = $param1;
        if (!empty($param2) && $param2 instanceof MimotoEntity) $entity = $param2;

        if (!empty($param1) && is_string($param1)) $sComponentName = $param1;
        if (!empty($param2) && is_string($param2)) $sComponentName = $param2;

        // verify
        if (empty($sComponentName)) Mimoto::error("Please read the Mimoto::service('output')->createPopup() documentation [link]");

        // init and send
        return new AimlessComponent($sComponentName, $entity, null, null, null, $this->_OutputService, $this->_DataService, $this->_LogService, $this->_TwigService);
    }

    /**
     * Create component
     * @param string $sComponentName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessComponent
     */
    public function create($sComponentName, $entity = null, $connection = null, $nItemIndex = null)
    {
        // init and send
        return new AimlessComponent($sComponentName, $entity, $connection, null, $nItemIndex, $this->_OutputService, $this->_DataService, $this->_LogService, $this->_TwigService);
    }

    /**
     * Create component
     * @param string $sComponentName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessComponent
     */
    public function createComponent($sComponentName, $entity = null, $connection = null, $nItemIndex = null)
    {
        // init and send
        return self::create($sComponentName, $entity, $connection, $nItemIndex);
    }

    /**
     * Create component wrapper
     * @param string $sComponentName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessComponent
     */
    public function createWrapper($sWrapperName, $sComponentName = null, $entity = null, $connection = null, $nItemIndex = null)
    {
        // init and send
        return new AimlessComponent($sComponentName, $entity, $connection, $sWrapperName, $nItemIndex, $this->_OutputService, $this->_DataService, $this->_LogService, $this->_TwigService);
    }

    /**
     * Create input
     * @param string $sComponentName The name of the registered template
     * @param MimotoEntity $entity The data to be combined with the template
     * @return AimlessInput
     */
    public function createInput($sComponentName, $entity = null, $connection = null, $sFieldName = null, $value = null, $nItemIndex = null)
    {
        // init and send
        return new AimlessInput($sComponentName, $entity, $connection, $sFieldName, $value, $nItemIndex, $this->_OutputService, $this->_DataService, $this->_LogService, $this->_TwigService);
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
        return new AimlessForm($sFormName, $xData, $options, $this->_OutputService, $this->_DataService, $this->_FormService, $this->_LogService, $this->_TwigService);
    }




    public function getComponentFile($sComponentName, MimotoEntity $entity = null)
    {
        // search
        $nComponentCount = count($this->_aComponents);
        for ($nComponentIndex = 0; $nComponentIndex < $nComponentCount; $nComponentIndex++)
        {
            // register
            $component = $this->_aComponents[$nComponentIndex];

            // verify
            if ($component->name === $sComponentName)
            {
                // read
                $aTemplates = $component->templates;

                // search
                $nTemplateCount = count($aTemplates);
                for ($nTemplateIndex = 0; $nTemplateIndex < $nTemplateCount; $nTemplateIndex++)
                {
                    // register
                    $template = $aTemplates[$nTemplateIndex];

                    // verify
                    if (count($template->conditionals) > 0 && $entity !== null)
                    {
                        // init
                        $bValidated = true;

                        // search
                        $nConditionalCount = count($template->conditionals);
                        for ($nConditionalIndex = 0; $nConditionalIndex < $nConditionalCount; $nConditionalIndex++)
                        {
                            // register
                            $conditional = $template->conditionals[$nConditionalIndex];

                            // toggle
                            switch ($conditional->type)
                            {
                                case ComponentConditional::ENTITY_TYPE:

                                    if (!empty($entity)) {
                                        if ($entity->getEntityTypeName() !== $conditional->entityName)
                                        {
                                            $bValidated = false;
                                            break;
                                        }
                                    }
                                    break;

                                case ComponentConditional::PROPERTY_VALUE:

                                    if ($entity->getValue($conditional->propertyName) !== $conditional->value)
                                    {
                                        $bValidated = false;
                                        break;
                                    }
                                    break;
                            }


                        }

                        // verify and send
                        if ($bValidated) return $template->file;
                    }
                    else
                    {
                        // send
                        return $template->file;
                    }
                }
            }
        }

        Mimoto::service('log')->error("Template `$sComponentName` not found", "I can't find the template you are looking for", true);
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
            // register
            $component = $this->_aComponents[$nComponentIndex];

            // verify
            if ($component->name === $sComponentName)
            {
                // read
                $aTemplates = $component->templates;

                // search
                $nTemplateCount = count($aTemplates);
                for ($nTemplateIndex = 0; $nTemplateIndex < $nTemplateCount; $nTemplateIndex++)
                {
                    // register
                    $template = $aTemplates[$nTemplateIndex];


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
                            $sComponentConditionals .= $conditional->propertyName;

                            // compose
                            if ($nConditionalIndex < $nConditionalCount - 1) $sComponentConditionals .= ',';
                        }

                        // compose
                        $sComponentConditionals .= ']';
                    }

                    break;
                }
            }
        }

        // send
        return $sComponentConditionals;
    }


    public function renderRoute($sPath)
    {

        // load
        $aRoutes = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_ROUTE]);


        $nRouteCount = count($aRoutes);
        for ($nRouteIndex = 0; $nRouteIndex < $nRouteCount; $nRouteIndex++)
        {
            // register
            $eRoute = $aRoutes[$nRouteIndex];

            // read
            $aPathElements = $eRoute->getValue('path');

            // validate
            if (empty($aPathElements)) continue;



            // init
            $sPathRegExp = '';

            // compose
            $nPathElementCount = count($aPathElements);
            for ($nPathElementIndex = 0; $nPathElementIndex < $nPathElementCount; $nPathElementIndex++)
            {
                // register
                $ePathElement = $aPathElements[$nPathElementIndex];

                //Mimoto::output('$ePathElement '.$nPathElementIndex, $ePathElement);

                switch($ePathElement->getValue('type'))
                {
                    case 'static':

                        $sPathRegExp .= '('.preg_replace('/\//', '\/', $ePathElement->getValue('staticValue')).')';
                        break;

                    case 'slash':

                        $sPathRegExp .= '(\/)';
                        break;

                    case 'var':

                        $sPathRegExp .= '(.*+)';
                        break;
                }
            }


            // verify
            if (preg_match('/^\/'.$sPathRegExp.'$/U', $sPath, $aMatches))
            {
                // remove full match
                array_splice($aMatches, 0, 1);

                // init
                $eInstance = null;


                // read
                $eOutput = $eRoute->getValue('output');


                // validate #todo - notify in debug mode
                if (empty($eOutput)) return false;


                $eLayout = $eOutput->getValue('component');
                $eSelection = $eOutput->getValue('selection');
                $eDataset = $eOutput->getValue('dataset');


                // validate #todo - notify in debug mode
                if (empty($eLayout)) return false;


                // verify
                if (!empty($eSelection))
                {
                    // create
                    $selection = Mimoto::service('selection')->create($eSelection);

                    // find variables
                    $nMatchCount = count($aMatches);
                    for ($nMatchIndex = 0; $nMatchIndex < $nMatchCount; $nMatchIndex++)
                    {
                        // register
                        $sMatchValue = $aMatches[$nMatchIndex];

                        // register
                        $ePathElement = $aPathElements[$nMatchIndex];


                        if ($ePathElement->getValue('type') == 'var')
                        {
                            $selection->applyVar($ePathElement->getValue('varName'), $sMatchValue);
                        }
                    }



                    // load
                    $aItems = Mimoto::service('data')->select($selection);

                    // get first
                    $eInstance = (count($aItems) > 0) ? $aItems[0] : null; // #todo - don't allow multiple items or notify
                }

                if (!empty($eDataset))
                {
                    $eInstance = $eDataset;
                }


                //Mimoto::error($eLayout->getValue('name'));

                // init
                $layout = Mimoto::service('output')->create($eLayout->getValue('name'), $eInstance);


                // read
                $aContainers = $eOutput->get('containers');

                if (!empty($aContainers))
                {
                    // parse
                    $nContainerCount = count($aContainers);
                    for ($nContainerIndex = 0; $nContainerIndex < $nContainerCount; $nContainerIndex++)
                    {
                        // register
                        $eContainer = $aContainers[$nContainerIndex];

                        // read
                        $sContainerName = $eContainer->get('name');

                        // validate
                        if (!empty($sContainerName))
                        {
                            // read
                            $eComponent = $eContainer->get('component');

                            // validate
                            if (!empty($eComponent))
                            {
                                // read
                                $eSelection = $eContainer->get('selection');

                                // validate
                                if (!empty($eSelection))
                                {
                                    // register
                                    $sComponentName = $eComponent->get('name');
                                    $aInstances = Mimoto::service('data')->select($eSelection);

                                    // add
                                    $layout->fillContainer($sContainerName, $aInstances, $sComponentName);
                                }
                            }
                        }
                    }
                }

                // output
                return $layout->render();
            }


        }

        return false;
    }


    private function loadComponents()
    {
        
        // check if in memory, else load from mysql:
        
        
        // 1. init
        $aComponents = [];


        // 2. load all components
        $aRawComponents = EntityConfigUtils::loadRawEntityData(CoreConfig::MIMOTO_COMPONENT);
        $aRawTemplates = EntityConfigUtils::loadRawEntityData(CoreConfig::MIMOTO_COMPONENT_TEMPLATE);
        $aRawConditionals = EntityConfigUtils::loadRawEntityData(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL);

        // 3. load all connections
        $aComponentTemplateConnections = EntityConfigUtils::loadRawConnectionData(CoreConfig::MIMOTO_COMPONENT);
        $aTemplateConditionalConnections = EntityConfigUtils::loadRawConnectionData(CoreConfig::MIMOTO_COMPONENT_TEMPLATE);



        // 4. build components data
        $nComponentCount = count($aRawComponents);
        for ($nComponentIndex = 0; $nComponentIndex < $nComponentCount; $nComponentIndex++)
        {
            // register
            $rawComponent = $aRawComponents[$nComponentIndex];

            // build
            $aComponents[] = $component = (object) array(
                'name' => $rawComponent->name,
                'templates' => []
            );

            // verify
            if (isset($aComponentTemplateConnections[$rawComponent->id]))
            {
                // search
                $nTemplateConnectionCount = count($aComponentTemplateConnections[$rawComponent->id]);
                for ($nTemplateConnectionIndex = 0; $nTemplateConnectionIndex < $nTemplateConnectionCount; $nTemplateConnectionIndex++)
                {
                    // register
                    $rawTemplateConnection = $aComponentTemplateConnections[$rawComponent->id][$nTemplateConnectionIndex];

                    // find
                    $nTemplateCount = count($aRawTemplates);
                    for ($nTemplateIndex = 0; $nTemplateIndex < $nTemplateCount; $nTemplateIndex++)
                    {
                        // register
                        $rawTemplate = $aRawTemplates[$nTemplateIndex];

                        // verify
                        if ($rawTemplate->id == $rawTemplateConnection->child_id)
                        {
                            // add
                            $template = $component->templates[] = (object) array(
                                'file' => $rawTemplate->file,
                                'conditionals' => []
                            );

                            // verify
                            if (isset($aTemplateConditionalConnections[$rawTemplate->id]))
                            {
                                // search
                                $nConditionalConnectionCount = count($aTemplateConditionalConnections[$rawTemplate->id]);
                                for ($nConditionalConnectionIndex = 0; $nConditionalConnectionIndex < $nConditionalConnectionCount; $nConditionalConnectionIndex++)
                                {
                                    // register
                                    $rawConditionalConnection = $aTemplateConditionalConnections[$rawTemplate->id][$nConditionalConnectionIndex];

                                    // find
                                    $nConditionalCount = count($aRawConditionals);
                                    for ($nConditionalIndex = 0; $nConditionalIndex < $nConditionalCount; $nConditionalIndex++)
                                    {
                                        // register
                                        $rawConditional = $aRawConditionals[$nConditionalIndex];

                                        // verify or skip
                                        if ($rawConditionalConnection->child_id != $rawConditional->id) continue;

                                        // add
                                        $conditional = $template->conditionals[] = (object) array(
                                            'type' => $rawConditional->type
                                        );

                                        if (
                                            $rawConditional->type == ComponentConditional::ENTITY_TYPE
                                        ) {
                                            // load
                                            $eConditional = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL, $rawConditional->id);

                                            // setup
                                            $conditional->entityName = $eConditional->get('entityType.name');
                                            break;
                                        }

                                        if (
                                            $rawConditional->type == ComponentConditional::PROPERTY_VALUE
                                        ) {

                                            // setup
                                            $conditional->propertyName = Mimoto::service('config')->getPropertyNameById($rawConditionalConnection->child_id);
                                            $conditional->value = $rawConditional->value;
                                            break;
                                        }
                                    }
                                }
                            }

                            array_splice($aRawTemplates, $nTemplateIndex, 1);
                            break;
                        }
                    }
                }


            }

        }
        //Mimoto::error($aComponents);

        // add core components
        $aComponents = array_merge($aComponents, Component::getData());

        // send
        return $aComponents;
    }


    
    // --- events ---
    
    
    /**
     * Handle event
     */
    public function handleRequest($sRequest, $data, $config)
    {
        switch($sRequest)
        {
            case 'dataUpdate':                      $this->dataUpdate($data, $config); break;
            case 'dataCreate':                      $this->dataCreate($data, $config); break;

            case 'sendSlackNotification':           $this->sendSlackNotification($data, $config); break;

            default:
                
                die("OutputService: Unknown request '".$sRequest."'");
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

        // config
        $data->messageID = Mimoto::service('messages')->getMessageUID();

        // setup
        $data->entityId = $nEntityId;
        $data->entityType = $sEntityType;
        
        // init
        $data->changes = array();
        $aModifiedValues = $entity->getChanges();

        // temp override
        $config->properties = [];
        foreach ($aModifiedValues as $sKey => $value) $config->properties[] = $sKey;


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
                $sPropertySubtype = $entity->getPropertySubtype($sMainPropertyName);

                
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
                        $valueForBroadcast->type = $sPropertyType;
                        $valueForBroadcast->subtype = $sPropertySubtype;

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


                            // --- add value properties

                            // register
                            $eChildEntity = $aModifiedValues[$sMainPropertyName]->added[0]->getEntity();

                            // register
                            $aChildEntityProperties = $eChildEntity->getPropertyNames();

                            // parse values
                            $nChildPropertyCount = count($aChildEntityProperties);
                            for ($nChildPropertyIndex = 0; $nChildPropertyIndex < $nChildPropertyCount; $nChildPropertyIndex++)
                            {
                                // register
                                $sChildProperty = $aChildEntityProperties[$nChildPropertyIndex];

                                // filter
                                if ($eChildEntity->getPropertyType($sChildProperty) == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
                                {
                                    $valueForBroadcast->entity->data[$sChildProperty] = $eChildEntity->get($sChildProperty);
                                }
                            }


                            // ---


                            // broadcast media
                            switch($sPropertySubtype)
                            {
                                case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE:
                                case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO:
                                case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_AUDIO:
                                case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_FILE:

                                    // read
                                    $eFile = $entity->getValue($sMainPropertyName);

                                    if (!empty($eFile))
                                    {
                                        $valueForBroadcast->entity->file = (object) array(
                                            'path' => Mimoto::value('config')->general->public_root.$eFile->getValue('path'),
                                            'name' => $eFile->getValue('name')
                                        );
                                    }
                                    break;
                            }
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
                                $entity = $this->_DataService->get($connection->getChildEntityTypeName(), $connection->getChildId());

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


                        // --- get connections


                        if (!empty($aModifiedValues[$sMainPropertyName]->updated))
                        {
                            // init
                            $aUnsortedConnections = [];

                            // read
                            $aConnectionsToSort = $entity->getValue($sMainPropertyName, true);

                            // collect
                            $nUnsortedConnectionCount = count($aConnectionsToSort);
                            for ($nUnsortedConnectionIndex = 0; $nUnsortedConnectionIndex < $nUnsortedConnectionCount; $nUnsortedConnectionIndex++)
                            {
                                // register
                                $unsortedConnection = $aConnectionsToSort[$nUnsortedConnectionIndex];

                                // compose
                                $aUnsortedConnections[] = (object) array(
                                    'id' => $unsortedConnection->getId(),
                                    'sortindex' => $unsortedConnection->getSortindex()
                                );
                            }

                            // init
                            $valueForBroadcast->collection->connections = [];

                            // sort
                            while (count($valueForBroadcast->collection->connections) < count($aUnsortedConnections))
                            {
                                for ($nConnectionIndex = 0; $nConnectionIndex < count($aUnsortedConnections); $nConnectionIndex++)
                                {
                                    // register
                                    $connection = $aUnsortedConnections[$nConnectionIndex];

                                    // verify
                                    if ($connection->sortindex == count($valueForBroadcast->collection->connections))
                                    {
                                        // store
                                        $valueForBroadcast->collection->connections[] = $connection;
                                        break;
                                    }
                                }
                            }
                        }

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
            'SELECT * FROM `'.CoreConfig::MIMOTO_CONNECTION.'`'.
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


        // register
        Mimoto::service('messages')->registerModification('data.changed', $data);


        if (!empty($data->changes)) { $this->sendSocketIOEvent('Aimless', 'data.changed', $data); }
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

        // config
        $data->messageID = Mimoto::service('messages')->getMessageUID();

        // setup
        $data->entityId = $nEntityId;
        $data->entityType = $sEntityType;

        // register
        Mimoto::service('messages')->registerModification('data.created', $data);

        // send
        $this->sendSocketIOEvent('Aimless', 'data.created', $data);
    }
    
    /**
     * Send Pusher event - #todo - async
     * @param type $sChannel
     * @param type $sEvent
     * @param type $data
     */
    private function sendSocketIOEvent($sChannel, $sEvent, $data)
    {
        // 1. only works if Gearman properly set up
        if (!class_exists('\GearmanClient')) return;

        // 2. verify or disable
        if (isset(Mimoto::value('config')->socketio) && isset(Mimoto::value('config')->socketio->disabled) && Mimoto::value('config')->socketio->disabled === true) return;

        // init
        $client= new \GearmanClient();

        try
        {
            // setup
            $client->addServer(Mimoto::value('config')->gearman->server_address);

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
    private function sendSlackNotification(MimotoEntity $entity, $config)
    {
        // 1. only works if Gearman properly set up
        if (!class_exists('\GearmanClient')) return;

        // init
        $client= new \GearmanClient();

        try
        {
            // setup
            $client->addServer(Mimoto::value('config')->gearman->server_address);


            // register
            $sTitle = $entity->getValue('title');
            $sDispatcher = $entity->getValue('dispatcher');
            $sMessage = $entity->getValue('message');

            // convert
            $sMessage = str_replace('<b>', '"', $sMessage);
            $sMessage = str_replace('</b>', '"', $sMessage);

            // compose
            $sSlackMessage = ">*$sTitle*\n>```$sMessage```\n>_From: $sDispatcher"."_";


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

<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Aimless\MimotoAimlessUtils;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * MimotoEntity
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntity
{

    /**
     * The entity's id
     * @var int
     */
    private $_nId;

    /**
     * The moment of creation
     * @var \DateTime
     */
    private $_datetimeCreated;

    /**
     * The entity's config, containing the entityTypeId and entityTypeName
     * @var string
     */
    private $_config;


    /**
     * The properties connected to this data node
     * 
     * @var array
     */
    private $_aProperties;
    
    /**
     * Track change mode
     * 
     * @var boolean
     */
    private $_bTrackChanges;
    
    
    // selector 
    const SELECTOR_KEY_SEPARATOR = '.';
    const SELECTOR_EXPRESSION_START = '{';
    const SELECTOR_EXPRESSION_END = '}';
    const SELECTOR_EXPRESSION_SEPERATOR = '=';
    const SELECTOR_ARRAY_START = '[';
    const SELECTOR_ARRAY_END = ']';



    // ----------------------------------------------------------------------------
    // --- Properties--------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get the entity's id
     *
     * @return int
     */
    public function getId() { return $this->_nId; }

    /**
     * Set the entity's id
     *
     * @param int $nId The entity's id
     */
    public function setId($nId) { $this->_nId = $nId; }


    /**
     * Get the entity's type's id
     *
     * @return mixed
     */
    public function getEntityTypeId() { return $this->_config->entityTypeId; }

    /**
     * Get the entity's type's name
     *
     * @return string
     */
    public function getEntityTypeName() { return $this->_config->entityTypeName; }


    /**
     * Get the moment of creation
     *
     * @return \DateTime
     */
    public function getCreated() { return $this->_datetimeCreated; }

    /**
     * Set the moment of creation
     *
     * @param \DateTime $datetimeCreated The moment of creation
     */
    public function setCreated($datetimeCreated) { $this->_datetimeCreated = $datetimeCreated; }



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param string $sEntityType
     * @param boolean $bTrackChanges (default changes are tracked)
     */
    public function __construct($xEntityTypeId, $sEntityTypeName, $bTrackChanges = true)
    {
        // init
        $this->_config = (object) array();

        // register
        $this->_config->entityTypeId = $xEntityTypeId;
        $this->_config->entityTypeName = $sEntityTypeName;
        $this->_bTrackChanges = $bTrackChanges;

        // init
        $this->_aProperties = [];
    }

    
    
    // ----------------------------------------------------------------------------
    // --- Public methods - setup -------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get entity's property names
     * @return array
     */
    public function getPropertyNames()
    {
        // init
        $aPropertyNames = [];
        
        // collect
        foreach ($this->_aProperties as $sPropertyName => $value) { $aPropertyNames[] = $sPropertyName; }
        
        // send
        return $aPropertyNames;
    }
    
    /**
     * Setup property by config
     * 
     * @param object $propertyConfig
     */
    public function setupProperty($propertyConfig)
    {
        // init
        $property = (object) array(
            'config' => $propertyConfig,
            'data' => (object) array()
        );

        // prepare
        switch($propertyConfig->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                $property->data->persistentValue = null;
                $property->data->currentValue = null;

                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                $property->data->persistentEntity = null;
                $property->data->currentEntity = null;
                //$property->data->entityCache = null; #todo

                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                $property->data->persistentCollection = [];
                $property->data->currentCollection = [];

                break;
        }


        // store
        $this->_aProperties[$propertyConfig->name] = $property;


    }
    
    public function getPropertyType($sPropertySelector)
    {
        return $this->_aProperties[$sPropertySelector]->config->type;
    }

    /**
     * Check if this entity is of a certain base type entity
     * @param $sEntityType
     * @return boolean
     */
    public function typeOf($sEntityType)
    {
        return $GLOBALS['Mimoto.Config']->entityIsTypeOf($this->_config->entityTypeName, $sEntityType);
    }


    
    // ----------------------------------------------------------------------------
    // --- Public methods - usage -------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the value of a property
     * @param string $sPropertySelector
     * @param boolean $bGetStorableValue The storable value, in case of an entity or collection. Default is false
     * @return mixed
     */
    public function getValue($sPropertySelector, $bGetStorableValue = false)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);
        
        switch($property->config->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE: return $this->getValueFromValueProperty($property); break;
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY: return $this->getValueFromEntityProperty($property, $bGetStorableValue, $sSubpropertySelector); break;
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION: return $this->getValueFromCollectionProperty($property, $bGetStorableValue, $sSubpropertySelector); break;
        }
    }
    
    /**
     * Set the value of a property
     * @param string $sPropertySelector
     * @param mixed value
     */
    public function setValue($sPropertySelector, $value)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);
        
        switch($property->config->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE: $this->setValueOfValueProperty($property, $value); break;
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY: $this->setValueOfEntityProperty($property, $value, $sSubpropertySelector); break;
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION: $this->setValueOfCollectionProperty($property, $value, $sSubpropertySelector); break;
        }
    }
    
    public function addValue($sPropertySelector, $value, $sEntityType = null)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);
        
        switch($property->config->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                $GLOBALS['Mimoto.Log']->warn("Adding value to a non-collection", "Unable to add a value to a value property <b>".$property->config->name);
                break;
            
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                
                if (empty($sSubpropertySelector))
                {
                    $GLOBALS['Mimoto.Log']->warn("Adding value to a non-collection", "Unable to add a value to an entity property <b>".$property->config->name);
                }
                else
                {
                    $this->addEntityProperty($property, $value, $sSubpropertySelector);
                }
                break;
                
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:
                
                $this->addCollectionProperty($property, $value, $sEntityType, $sSubpropertySelector);
                break;
        }
    }
    
    public function removeValue($sPropertySelector, $value, $sEntityType = null)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);
        
        switch($property->config->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:
                
                throw new MimotoEntityException("( '-' ) - Nope, I'm unable to add a value the non-collection '$property->config->name' which is a value");
            
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                
                if (empty($sSubpropertySelector)) { throw new MimotoEntityException("( '-' ) - Nope, I'm unable to add a value the non-collection '$property->config->name' which is an entity"); }
                
                $this->removeEntityProperty($property, $value, $sSubpropertySelector);
                break;
                
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:
                
                $this->removeCollectionProperty($property, $value, $sEntityType, $sSubpropertySelector);
                break;
        }
    }



    // ----------------------------------------------------------------------------
    // --- Public Aimless methods -------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get Aimless value of a property or subproperty
     * @param string $sPropertyName
     * @return string
     */
    public function getAimlessValue($sPropertyName)
    {
        // find
        $nSeperatorPos = strpos($sPropertyName, '.');

        // separate
        $sMainPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, 0, $nSeperatorPos) : $sPropertyName;
        $sSubPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, $nSeperatorPos + 1) : '';

        // compose
        $sAimlessValue = MimotoAimlessUtils::formatAimlessValue($this->getEntityTypeName(), $this->getId(), $sPropertyName);

        // verify
        if (!empty($sSubPropertyName) && $this->valueRelatesToEntity($sMainPropertyName))
        {
            // load
            $entity = $this->getValue($sMainPropertyName);

            // compose
            if (MimotoDataUtils::isEntity($entity))
            {
                $sAimlessValue .= MimotoAimlessUtils::formatAimlessSubvalue($sMainPropertyName, $entity->getId(), $sSubPropertyName);
            }
            else
            {
                $sAimlessValue .= MimotoAimlessUtils::formatAimlessSubvalueWithoutId($sMainPropertyName, $sSubPropertyName);
            }
        }

        // send
        return $sAimlessValue;
    }

    /**
     * Get Aimless id of an entity
     * @return string
     */
    public function getAimlessId()
    {
        return $this->getEntityTypeName().'.'.$this->getId();
    }



    public function serialize()
    {
        
    }
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods - Properties - Value -----------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Read a value property
     * @param object $property
     * @return mixed
     * @throws MimotoEntityException
     */
    private function getValueFromValueProperty($property)
    {
        // validate #todo disabled when value is null in database. Is this an issue? Not really. Opt for deletion
        //if (!isset($property->data->currentValue)) { throw new MimotoEntityException("( '-' ) - Hmm, the property '".$property->config->name."' you are trying to get doesn't seems to have a value set yet"); }
        
        // send
        return $property->data->currentValue;
    }
    
    /**
     * Set a value property
     * @param string $property
     * @param mixed $value
     */
    private function setValueOfValueProperty($property, $value)
    {
        // store if change tracking is disabled
        if (!$this->_bTrackChanges) { $property->data->persistentValue = $value; }

        // store
        $property->data->currentValue = $value;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods - Properties - Entity ----------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Read entity
     * @param object $property
     * @param boolean $bGetStorableValue
     * @return int or MimotoEntity
     * @throws MimotoEntityException
     */
    private function getValueFromEntityProperty($property, $bGetStorableValue = false, $sSubpropertySelector = '')
    {
        // forward
        if (!empty($sSubpropertySelector)) { return $this->forwardGetValueFromEntityProperty($property, $sSubpropertySelector, $bGetStorableValue); }

        // validate
        if (empty($property->data->currentEntity)) return null;

        // send
        if ($bGetStorableValue) { return $property->data->currentEntity->getChildId(); }

        // send
        return $this->loadEntity($property);
    }
    
    /**
     * Forward set entity property
     * @param object $property
     * @param string $sPropertySelector
     * @param boolean $bGetStorableValue Default is set to false
     * @throws MimotoEntityException
     */
    private function forwardGetValueFromEntityProperty($property, $sPropertySelector, $bGetStorableValue = false)
    {
        // validate
        if (!empty($property->data->currentEntity) && !MimotoDataUtils::isValidEntityId($property->data->currentEntity->getChildId())) { throw new MimotoEntityException("( '-' ) - Sorry, the entity '$property->config->name' for which you are trying to set the property '$sPropertySelector' doesn't seem to be set yet"); }

        // load
        $entity = $this->loadEntity($property);
        
        // forward
        return (!empty($entity)) ? $entity->getValue($sPropertySelector, $bGetStorableValue) : null;
    }
    
    /**
     * Load entity
     * @param object $property
     * @return MimotoEntity
     */
    private function loadEntity($property)
    {
        // check if available
        if (empty($property->data->currentEntity->getEntity()))
        {
            if (!empty($property->data->currentEntity) &&
                MimotoDataUtils::isValidEntityId($property->data->currentEntity->getChildId()))
            {
                // load
                $property->data->currentEntity->setEntity($GLOBALS['Mimoto.Data']->get($property->data->currentEntity->getChildEntityTypeName(), $property->data->currentEntity->getChildId()));
            }
        }
        
        // send
        return (!empty($property->data->currentEntity->getEntity())) ? $property->data->currentEntity->getEntity() : null;
    }
    
    
    /**
     * Set entity property
     * @param object $property
     * @param mixed $xValue
     * @param string $sPropertySelector
     * @return property
     * @throws MimotoEntityException
     */
    private function setValueOfEntityProperty($property, $xValue, $sPropertySelector)
    {
        // forward
        if (!empty($sPropertySelector)) { $this->forwardSetValueOfEntityProperty($property, $sPropertySelector, $xValue); return; }




        //error($xValue->getEntityTypeName());
        //error($xValue);


        // 1. check if type is connection
        // 2. check if type is entity
        // 3. check if type is id
        // 4. central function for checking the above?







        // validate
        if (MimotoDataUtils::isEntity($xValue) && $xValue->getEntityTypeId() !== $property->config->settings->allowedEntityType->id)
        {
            throw new MimotoEntityException("( '-' ) - Sorry, the entity you are trying to set at '".$property->config->name."' has type '".$xValue->getEntityTypeName()."' instead of type '".$property->config->settings->allowedEntityType->name."'");
        }


        if ($xValue instanceof MimotoEntityConnection)
        {

            // store if change tracking is disabled
            if (!$this->_bTrackChanges) { $property->data->persistentEntity = $xValue; }

            // store
            $property->data->currentEntity = $xValue;

            return;
        }


        //error($this->getEntityTypeId());

        // init
        $connection = new MimotoEntityConnection();

        // compose
        $connection->setParentEntityTypeId($this->getEntityTypeId());
        $connection->setParentPropertyId($property->config->id);
        $connection->setParentId($this->getId());
        $connection->setChildEntityTypeId($property->config->settings->allowedEntityType->id);
        $connection->setSortIndex(0);




        if (MimotoDataUtils::isEntity($xValue) )
        {


            // compose
            $connection->setChildId($xValue->getId());
            $connection->setEntity($xValue);

            // store if change tracking is disabled
            if (!$this->_bTrackChanges) { $property->data->persistentEntity = $connection; }

            // store
            $property->data->currentEntity = $connection;
            //$property->data->entityCache = $xValue;

            return;
        }

        if (MimotoDataUtils::isValidEntityId($xValue))
        {
            // compose
            $connection->setChildId($xValue);

            // store if change tracking is disabled
            if (!$this->_bTrackChanges) { $property->data->persistentEntity = $connection; }

            // store
            $property->data->currentEntity = $connection;

            return;
        }

        if (empty($xValue) || $xValue == 0)
        {
            // store if change tracking is disabled
            if (!$this->_bTrackChanges) { $property->data->persistentEntity = null; }
            
            // clear
            unset($property->data->currentEntity);
            //unset($property->data->entityCache);
            
            return;
        }

        // validate
        throw new MimotoEntityException("( '-' ) - Sorry, the entity or entity id you are trying to set at '$property->config->name' doesn't seem to be valid");
    }
    
    /**
     * Forward set entity property
     * @param object $property
     * @param string $sPropertySelector
     * @param mixed $value
     * @throws MimotoEntityException
     */
    private function forwardSetValueOfEntityProperty($property, $sPropertySelector, $value)
    {
        // validate
        if (!MimotoDataUtils::isValidEntityId($property->data->currentEntity->getChildId())) { throw new MimotoEntityException("( '-' ) - Sorry, the entity '$property->config->name' for which you are trying to set the property '$sPropertySelector' doesn't seem to be set yet"); }
        
        // load
        $entity = $this->loadEntity($property);
        
        // forward
        $entity->setValue($sPropertySelector, $value);
    }
    
    
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods - Properties - Collection ------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Read collection
     * @param collection object $property
     * @param boolean $bGetStorableValue
     * @return MimotoCollection ----> id's or anders? | array met id's of MimotoCollection
     * @throws MimotoEntityException
     */
    private function getValueFromCollectionProperty($property, $bGetStorableValue = false, $sSubpropertySelector = '')
    {
        // 1. collection gaat alleen over volgorde en referenties, niet om feitelijk inhoud
        // 2. inhoud draagt eigen changed-status
        // 3. dit houdt het management van de collection vrij eenvoudig
        
        
        //echo "\nsSubpropertySelector=".$sSubpropertySelector."<br>\n\n";

        
        // init
        $aConditionals = MimotoDataUtils::getConditionals($sSubpropertySelector);
        
        
            
        if (preg_match("/^\[\]$/", $sSubpropertySelector))
        {
            /* array with comma separated multiple key support */ 
            
        }
        
        // 1. regexp voor alles
        // 2. value voor alles
        
        if (preg_match("/^\/\/$/", $sSubpropertySelector))
        {
            /* regexp */
        }
        

        /* regular value */

        
        if ($bGetStorableValue)
        {
            // 1. de data moet eerst geladen worden
            // 2. indien geladen, opslaan
            // 3. indien opgeslagen, gebruik uit geheugen


            $aCollectionItems = $property->data->currentCollection;

            $aCollection = [];

            $nCollectionItemCount = count($aCollectionItems);
            for ($i = 0; $i < $nCollectionItemCount; $i++)
            {
                // register
                $connection = $aCollectionItems[$i];

                if (empty($connection->getEntity()))
                {
                    // load
                    $connection->setEntity($GLOBALS['Mimoto.Data']->get($connection->getChildEntityTypeName(), $connection->getChildId()));
                }

                // load
                $entity = $connection->getEntity();


                $bVerified = true;
                foreach ($aConditionals as $sKey => $value)
                {
                    // verify
                    if ($entity->getValue($sKey) != $value)
                    {
                        $bVerified = false;
                        break;
                    }
                }

                if ($bVerified) { $aCollection[] = $entity; }
            }

            // send
            return $aCollection;
        }



        // 1. maak kopie van $property->data->currentCollection


        return $property->data->currentCollection;
    }
    
    
    
    
    private function setValueOfCollectionProperty($property, $value, $sPropertySelector)
    {
        // forward
        if (!empty($sPropertySelector)) { $this->forwardSetValueOfCollectionProperty($property, $sPropertySelector, $value); return; }
        // 1. in de forward komt de selector-query of [1]
        
        // validate
        if (!is_array($value)) { throw new MimotoEntityException("( '-' ) - The collection property '".$property->config->name."' can only accept an array"); }
        
        
        // init
        if (!$this->_bTrackChanges) { $property->data->persistentCollection = []; }
        $property->data->currentCollection = [];
        

        $nItemCount = count($value);
        for ($i = 0; $i < $nItemCount; $i++)
        {
            // register
            $item = $value[$i];
            
            // store
            $subproperty = $item;
            
            // store
            if (!$this->_bTrackChanges) { $property->data->persistentCollection[$i] = clone $subproperty; }
            $property->data->currentCollection[] = $subproperty;
        }
    }
    
    /**
     * Add collection property
     * @param object $property
     * @param mixed $value
     * @param string $sPropertySelector
     * @throws MimotoEntityException
     */
    private function addCollectionProperty($property, $value, $sEntityType, $sPropertySelector)
    {
        // forward #fixme Is this still relevant. Code seems to be missing
        if (!empty($sPropertySelector)) { $this->forwardAddEntityProperty($property, $sPropertySelector, $value); return; }

        // validate input
        if (!MimotoDataUtils::isEntity($value) && !MimotoDataUtils::isValidEntityId($value)) { throw new MimotoEntityException("( '-' ) - Sorry, the value you are trying to add at to collection '$property->config->name' is not a MimotoEntity"); }

        if (MimotoDataUtils::isEntity($value))
        {
            $sEntityType = $value->getEntityTypeName();
        }
        else
        {
            if ($sEntityType === null)
            {
                // validate
                if (count($property->config->settings->allowedEntityTypes) != 1) { throw new MimotoEntityException("( '-' ) - Please provide an entity type if you only pass an id when adding an item to the collection '$property->config->name' which allows the types ".json_encode($property->config->allowedEntityTypes)); }
                
                // auto define
                $sEntityType = $property->config->settings->allowedEntityTypes[0]->name;
            }
        }


        // init
        $connection = new MimotoEntityConnection();

        $connection->setParentEntityTypeId($this->getEntityTypeId());
        $connection->setParentPropertyId($property->config->id);
        $connection->setParentId($this->getId());
        
        
        $aAllowedEntityTypes = [];
        $bAllowAllEntityTypes = false;
        $nAllowedEntityTypecount = count($property->config->settings->allowedEntityTypes);
        for ($i = 0; $i < $nAllowedEntityTypecount; $i++)
        {
            // check wildcard
            if ($property->config->settings->allowedEntityTypes[$i]->id == CoreConfig::WILDCARD)
            {
                $bAllowAllEntityTypes = true;
                break;
            }

            // register
            $aAllowedEntityTypes[] = $property->config->settings->allowedEntityTypes[$i]->name;
        }


        // validate
        if (MimotoDataUtils::isEntity($value) && !$bAllowAllEntityTypes && !in_array($sEntityType, $aAllowedEntityTypes))
        {
            $GLOBALS['Mimoto.Log']->error("Collection item not allowed", "The entity you are trying to set at <b>".$property->config->name."</b> has type <b>".$value->getEntityTypeName()."</b> instead of one of the types <b>".json_encode($property->config->settings->allowedEntityTypes)."</b>", true);
        }

        if (MimotoDataUtils::isEntity($value))
        {
            // store
            $connection->setChildId($value->getId());
            $connection->setEntity($value);
        }
        else
        if (MimotoDataUtils::isValidEntityId($value))
        {
            // store
            $connection->setChildId($value);
        }

        $connection->setChildEntityTypeId($GLOBALS['Mimoto.Config']->getEntityIdByName($sEntityType));
        $connection->setSortIndex(count($property->data->currentCollection));


        // manage duplicates
        if (!$property->config->settings->allowDuplicates)
        {
            $bDuplicateFound = false;
            $nCurrentCollectionCount = count($property->data->currentCollection);
            for ($i = 0; $i < $nCurrentCollectionCount; $i++)
            {
                if (!empty($connection->getChildId()) && $property->data->currentCollection[$i]->getChildId() == $connection->getChildId())
                {
                    $bDuplicateFound = true;
                    return;
                }
            }
        }
        
        
        // store
        if (!$this->_bTrackChanges) { $property->data->persistentCollection[$i] = clone $connection; }
        $property->data->currentCollection[] = $connection;
    }
    
    /**
     * remove collection property
     * @param object $property
     * @param mixed $value
     * @param string $sPropertySelector
     * @throws MimotoEntityException
     */
    private function removeCollectionProperty($property, $xValue, $sEntityType, $sPropertySelector)
    {
        // forward
        if (!empty($sPropertySelector)) { $this->forwardRemoveEntityProperty($property, $sPropertySelector, $xValue); return; }
        
        
        // validate input
        if (!MimotoDataUtils::isEntity($xValue) && !MimotoDataUtils::isValidEntityId($xValue)) { throw new MimotoEntityException("( '-' ) - Sorry, the value you are trying to add at to collection '$property->config->name' is not a MimotoEntity"); }
        
        
        if (MimotoDataUtils::isEntity($xValue))
        {
            $sEntityType = $xValue->getEntityTypeName();
        }
        else
        {
            if ($sEntityType === null)
            {
                // validate
                if (count($property->config->settings->allowedEntityTypes) != 1) { throw new MimotoEntityException("( '-' ) - Please provide an entity type if you only pass an id when adding an item to the collection '$property->config->name' which allows the types ".json_encode($property->config->allowedEntityTypes)); }
                
                // auto define
                $sEntityType = $property->config->settings->allowedEntityTypes[0]->name;
            }
        }
        
        // init
        $connection = new MimotoEntityConnection();

        $connection->setParentEntityTypeId($this->getEntityTypeId());
        $connection->setParentPropertyId($property->config->id);
        $connection->setParentId($this->getId());
        
        
        $aAllowedEntityTypes = [];
        $nAllowedEntityTypeCount = count($property->config->settings->allowedEntityTypes);
        for ($i = 0; $i < $nAllowedEntityTypeCount; $i++)
        {
            $aAllowedEntityTypes[] = $property->config->settings->allowedEntityTypes[$i]->name;
        }
        
        
        // validate
        if (MimotoDataUtils::isEntity($xValue) && !in_array($sEntityType, $aAllowedEntityTypes)) { throw new MimotoEntityException("( '-' ) - Sorry, the entity you are trying to set at '$property->config->name' has type '".$xValue->getEntityTypeName()."' instead of on of the types ".json_encode($property->config->settings->allowedEntityTypes)); }

        if (MimotoDataUtils::isEntity($xValue))
        {
            // store
            $connection->setChildId($xValue->getId());
        }
        else
        if (MimotoDataUtils::isValidEntityId($xValue))
        {
            // store
            $connection->setChildId($xValue);
        }

        $connection->setChildEntityTypeId($GLOBALS['Mimoto.Config']->getEntityIdByName($sEntityType));
        $connection->setSortIndex(count($property->data->currentCollection));
        
        
        // --- HERE --------------------------------------------------------------------------------------------
        // 1. bij duplicates verwijder allemaal
        // 2. hoe connection id verwijderen? (sortindex / id en connection id niet aanraken?)
        
        
        // manage duplicates
        // if (!$property->config->settings->allowDuplicates)
        
        $nCurrentCollectionCount = count($property->data->currentCollection);
        for ($i = 0; $i < $nCurrentCollectionCount; $i++)
        {
            if ($property->data->currentCollection[$i]->getChildId() == $connection->getChildId())
            {
                // remove
                if (!$this->_bTrackChanges) { array_splice($property->data->persistentCollection, $i, 1); }
                array_splice($property->data->currentCollection, $i, 1);
            }
        }
        
        
        
        // validate
        //throw new MimotoEntityException("( '-' ) - Sorry, the entity or entity id you are trying to set at '$property->config->name' doesn't seem to be valid");
    }
    
    
    
    // ----------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------


    // #todo - Move to data utils


    /**
     * Get property
     * @param type $sPropertySelector
     * @return single property or collection of properties
     * @throws MimotoEntityException
     */
    private function getProperty($sPropertySelector)
    {
        // validate
        if (!MimotoDataUtils::validatePropertySelector($sPropertySelector)) { throw new MimotoEntityException("( '-' ) - The property selector '$sPropertySelector' seems to be malformed"); }

        // init
        $aMatchingProperties = [];

        // check all properties
        foreach ($this->_aProperties as $sPropertyName => $property)
        {
            // search
            if ($sPropertyName === $sPropertySelector || (strlen($sPropertySelector) > strlen($sPropertyName) && $sPropertyName.'.' === substr($sPropertySelector, 0, strlen($sPropertyName) + 1)))
            {
                // register
                $aMatchingProperties[] = $property;
                break;
            }
        }

        // verify
        if (count($aMatchingProperties) === 0)
        {
            $GLOBALS['Mimoto.Log']->error("Missing property", "The property <b>$sPropertySelector</b> you are looking for doesn't seem to be here", true);
        }

        // send
        return $aMatchingProperties[0];
    }

    /**
     * Get subproperty selector
     * @param string $sPropertySelector
     * @param object $property
     * @return string
     */
    private function getSubpropertySelector($sPropertySelector, $property)
    {
        // strip
        $sSubpropertySelector = substr($sPropertySelector, strlen($property->config->name));

        // strip more
        if (substr($sSubpropertySelector, 0, 1) === '.') { $sSubpropertySelector = substr($sSubpropertySelector, 1); }

        // send
        return $sSubpropertySelector;
    }




    /** _______________________________________________________________________________________
     * ___                                         ____________________________________________
     * ___|   Private functions - string parsing  |____________________________________________
     * ________________________________________________________________________________________
     */


    /**
     * Split selector and respect expressions
     */
    private function splitSelector($sPropertySelector)
    {
        return explode(self::SELECTOR_KEY_SEPARATOR, $sPropertySelector);
    }

    
    
    public function valueRelatesToEntity($sPropertyName)
    {
        // verify and send
        return (isset($this->_aProperties[$sPropertyName]) && $this->_aProperties[$sPropertyName]->config->type == MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
    }

    
    
    
    /**
     * Add an item to a collection
     * 
     * @param string $sPropertySelector The selector containing the property name and optional subselector
     * @param mixed $value The item (id or entity)
     * @param index $nIndex (Optional) The index on which to add the item
     * @throws MimotoEntityException
     */
    public function add($sPropertySelector, $value, $nIndex = null)
    {
        // find
        $nSeperatorPos = strpos($sPropertySelector, '.');

        // separate
        $sMainPropertyName = ($nSeperatorPos !== false) ? substr($sPropertySelector, 0, $nSeperatorPos) : $sPropertySelector;
        $sSubPropertyName = ($nSeperatorPos !== false) ? substr($sPropertySelector, $nSeperatorPos + 1) : '';

        // load
        //if ($this->hasProperty($sPropertyName)) { $property = $this->_aProperties[$sPropertyName]; }
        $property = $this->_aProperties[$sMainPropertyName];

        // report
        if ($property->config->type == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) { throw new MimotoEntityException("( '-' ) - It's not possible to add an item to value"); }
        
        // forward
        $property->add($sSubPropertyName, $value, $nIndex);
    }
    
    /**
     * Remove an item from a collection
     * 
     * @param string $sPropertySelector The selector containing the property name and optional subselector
     * @param mixed $value The item (id or entity)
     * @throws MimotoEntityException
     */
    public function remove($sPropertySelector, $value)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        // load
        $property = $this->_aProperties[$sPropertyName];
        
        // report
        if ($property->config->type == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) { throw new MimotoEntityException("( '-' ) - It's not possible to remove an item from value"); }
        
        // forward
        $property->remove($sSubselector, $value);
    }
    
    /**
     * Get Changes
     * @return array Collection containing of all changed properties as key/value pairs
     */
    public function getChanges()
    {
        // init
        $aModifiedValues = [];
        
        foreach ($this->_aProperties as $sPropertyName => $property)
        {
            // register
            $property = $this->_aProperties[$sPropertyName];
            
            switch($property->config->type)
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:
                    
                    if (!isset($property->data->persistentValue) || $property->data->persistentValue !== $property->data->currentValue)
                    {
                        $aModifiedValues[$sPropertyName] = $property->data->currentValue;
                    }
                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                    // init
                    $aAddedItems = [];
                    $aUpdatedItems = [];
                    $aRemovedItems = [];

                    if (isset($property->data->currentEntity) && !isset($property->data->persistentEntity))
                    {
                        $aAddedItems[] = $property->data->currentEntity;
                    }
                    elseif (!isset($property->data->currentEntity) && isset($property->data->persistentEntity))
                    {
                        $aRemovedItems[] = $property->data->persistentEntity;
                    }
                    elseif (isset($property->data->currentEntity) && isset($property->data->persistentEntity))
                    {
                        // check if similar
                        if (MimotoDataUtils::connectionsAreSimilar($property->data->currentEntity, $property->data->persistentEntity))
                        {
                            $property->data->currentEntity->setId($property->data->persistentEntity->getId());
                        }
                        else
                        {
                            $aAddedItems[] = $property->data->currentEntity;
                            $aRemovedItems[] = $property->data->persistentEntity;
                        }
                    }

                    if (count($aAddedItems) > 0 || count($aUpdatedItems) > 0 || count($aRemovedItems) > 0)
                    {
                        $aModifiedValues[$sPropertyName] = (object) array(
                            'added' => $aAddedItems,
                            'updated' => $aUpdatedItems,
                            'removed' => $aRemovedItems,
                        );
                    }

                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                    // init
                    $aAddedItems = [];
                    $aUpdatedItems = [];
                    $aRemovedItems = [];
                    
                    
                    if (!empty($property->data->currentCollection))
                    {
                        $nCurrentCollectionCount = count($property->data->currentCollection);
                        for ($c = 0; $c < $nCurrentCollectionCount; $c++)
                        {
                            $currentItem = $property->data->currentCollection[$c];

                            // add new items
                            if (empty($currentItem->getId()) || $currentItem->isNew())
                            {
                                $aAddedItems[] = $currentItem;
                                continue;
                            }
                            
                            // add updated items
                            if (!empty($property->data->persistentCollection))
                            {
                                $nPersistentCollectionCount = count($property->data->persistentCollection);
                                for ($p = 0; $p < $nPersistentCollectionCount; $p++)
                                {
                                    $persistentItem = $property->data->persistentCollection[$p];
                                    
                                    if ($persistentItem->getId() == $currentItem->getId())
                                    {
                                        if ($persistentItem->getSortIndex() != $currentItem->getSortIndex())
                                        {
                                            $aUpdatedItems[] = $currentItem;
                                            break;
                                        }
                                    }
                                }
                                
                                
                            }
                        }
                    }
                    
                    // add removed items
                    if (!empty($property->data->persistentCollection))
                    {
                        $nPersistentCollectionCount = count($property->data->persistentCollection);
                        for ($p = 0; $p < $nPersistentCollectionCount; $p++)
                        {
                            // register
                            $persistentItem = $property->data->persistentCollection[$p];
                            
                            // init 
                            $bItemFound = false;
                            
                            // search
                            $nCurrentCollectionCount = count($property->data->currentCollection);
                            for ($c = 0; $c < $nCurrentCollectionCount; $c++)
                            {
                                // register
                                $currentItem = $property->data->currentCollection[$c];
                                
                                if ($currentItem->getId() == $persistentItem->getId())
                                {
                                    $bItemFound = true;
                                    break;
                                }
                            }
                            
                            if (!$bItemFound) { $aRemovedItems[] = $persistentItem; }
                        }
                    }
                    
                    if (count($aAddedItems) > 0 || count($aUpdatedItems) > 0 || count($aRemovedItems) > 0)
                    {
                        $aModifiedValues[$sPropertyName] = (object) array(
                            'added' => $aAddedItems,
                            'updated' => $aUpdatedItems,
                            'removed' => $aRemovedItems,
                        );
                    }
                    
                    break;
            }
        }
        
        // send
        return $aModifiedValues;
    }
    
    
    /**
     * Start tracking changes
     */
    public function trackChanges()
    {
        // toggle
        $this->_bTrackChanges = true;
    }
    
    /**
     * Check if the value was changed
     * 
     * @return boolean True if value was changed
     */
    public function hasChanges()
    {
        // check and send
        return (count($this->getChanges()) > 0) ? true : false;
    }
    
    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        foreach ($this->_aProperties as $sPropertyName => $property)
        {
            // register
            $property = $this->_aProperties[$sPropertyName];
            
            switch($property->config->type)
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:
                
                    $property->data->persistentValue = $property->data->currentValue;
                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                    
                    if (!empty($property->data->currentEntity))
                    {
                        $property->data->persistentEntity = clone $property->data->currentEntity;
                    }
                    else
                    {
                        unset($property->data->persistentEntity);
                    }
                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:
                    
                    // delete
                    $property->data->persistentCollection = [];
                    
                    if (!empty($property->data->currentCollection))
                    {
                        $nCurrentCollectionCount = count($property->data->currentCollection);
                        for ($k = 0; $k < $nCurrentCollectionCount; $k++)
                        {
                            $property->data->persistentCollection[$k] = clone $property->data->currentCollection[$k];
                        }
                    }
                    break;
            }
        }
    }
    
    /**
     * Check if the data object has a property
     * 
     * @return boolean True if value was changed
     */
    public function hasProperty($sProperty)
    {
        return isset($this->_aProperties[$sProperty]);
    }
    
}

<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\library\data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Data\MimotoCollection;


/**
 * MimotoData
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoData
{
    
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
    // --- Constructor-------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * 
     * @param boolean $bTrackChanges (default changes are tracked)
     */
    public function __construct($bTrackChanges = true)
    {
        // register
        $this->_bTrackChanges = $bTrackChanges;
        
        // init
        $this->_aProperties = [];
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods - setup -------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Set value as property
     * 
     * @param string $sPropertyName
     */
    public function setValueAsProperty($sPropertyName)
    {
        // validate
        if (!MimotoDataUtils::validatePropertyName($sPropertyName)) { throw new MimotoEntityException("( '-' ) - Sorry, the property '$sPropertyName' you are trying to set has characters that are not allowed. You can only use a-z A-Z and 0-9"); }
        
        // store
        $this->_aProperties[$sPropertyName] = (object) array(
            'name' => $sPropertyName,
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE
        );
    }
    
    /**
     * Set entity as property
     * 
     * @param string $sPropertyName
     */
    public function setEntityAsProperty($sPropertyName, $sEntityType)
    {
        // validate
        if (!MimotoDataUtils::validatePropertyName($sPropertyName)) { throw new MimotoEntityException("( '-' ) - Sorry, the property '$sPropertyName' you are trying to set has characters that are not allowed. You can only use a-z A-Z and 0-9"); }
        
        // store
        $this->_aProperties[$sPropertyName] = (object) array(
            'name' => $sPropertyName,
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY,
            'entityType' => $sEntityType
        );
    }
    
    /**
     * Set collection as property
     * 
     * @param string $sPropertyName
     */
    public function setCollectionAsProperty($sPropertyName, $sAllowedEntityType)
    {
        // validate
        if (!MimotoDataUtils::validatePropertyName($sPropertyName)) { throw new MimotoEntityException("( '-' ) - Sorry, the property '$sPropertyName' you are trying to set has characters that are not allowed. You can only use a-z A-Z and 0-9"); }
        
        // store
        $this->_aProperties[$sPropertyName] = (object) array(
            'name' => $sPropertyName,
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION,
            'allowedEntityTypes' => [$sAllowedEntityType]
        );
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
        
        switch($property->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE: return $this->getValueProperty($property); break;
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY: return $this->getEntityProperty($property, $bGetStorableValue, $sSubpropertySelector); break;
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION: return $this->getCollectionProperty($property, $bGetStorableValue, $sSubpropertySelector); break;
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
        
        switch($property->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE: $this->setValueProperty($property, $value); break;
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY: $this->setEntityProperty($property, $value, $sSubpropertySelector); break;
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION: $this->setCollectionProperty($property, $value, $sSubpropertySelector); break;
        }
    }
    
    public function addValue($sPropertySelector, $value)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);
        
        switch($property->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:
                
                throw new MimotoEntityException("( '-' ) - Nope, I'm unable to add a value the non-collection '$property->name' which is a value");
            
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                
                if (empty($sSubpropertySelector)) { throw new MimotoEntityException("( '-' ) - Nope, I'm unable to add a value the non-collection '$property->name' which is an entity"); }
                
                $this->addEntityProperty($property, $value, $sSubpropertySelector);
                break;
                
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:
                
                $this->addCollectionProperty($property, $value, $sSubpropertySelector);
                break;
        }
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
    private function getValueProperty($property)
    {
        // validate
        if (!isset($property->currentValue)) { throw new MimotoEntityException("( '-' ) - Hmm, the property '$property->name' you are trying to get doesn't seems to have a value set yet"); }
        
        // send
        return $property->currentValue;
    }
    
    /**
     * Set a value property
     * @param string $property
     * @param mixed $value
     */
    private function setValueProperty($property, $value)
    {
        // store if change tracking is disabled
        if (!$this->_bTrackChanges) { $property->persistentValue = $value; }

        // store
        $property->currentValue = $value;
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
    private function getEntityProperty($property, $bGetStorableValue = false, $sSubpropertySelector = '')
    {
        // forward
        if (!empty($sSubpropertySelector)) { return $this->forwardgetEntityProperty($property, $sSubpropertySelector, $bGetStorableValue); }
        
        
        // validate
        if (!isset($property->currentId)) { throw new MimotoEntityException("( '-' ) - Hmm, the property '$property->name' you are trying to get doesn't seems to have a value set yet"); }
        
        // send
        if ($bGetStorableValue) { return $property->currentId; }
        
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
    private function forwardGetEntityProperty($property, $sPropertySelector, $bGetStorableValue = false)
    {
        // validate
        if (!MimotoDataUtils::isValidEntityId($property->currentId)) { throw new MimotoEntityException("( '-' ) - Sorry, the entity '$property->name' for which you are trying to set the property '$sPropertySelector' doesn't seem to be set yet"); }
        
        // load
        $entity = $this->loadEntity($property);
        
        // forward
        return $entity->getValue($sPropertySelector, $bGetStorableValue);
    }
    
    /**
     * Load entity
     * @param object $property
     * @return MimotoEntity
     */
    private function loadEntity($property)
    {
        // check if available
        if (!isset($property->entityCache))
        {
            if (MimotoDataUtils::isValidEntityId($property->currentId))
            {                    
                // load
                $property->entityCache = $GLOBALS['Mimoto.Data']->get($property->entityType, $property->currentId);
            }
        }
        
        // send
        return $property->entityCache;
    }
    
    
    /**
     * Set entity property
     * @param object $property
     * @param mixed $value
     * @param string $sPropertySelector
     * @return property
     * @throws MimotoEntityException
     */
    private function setEntityProperty($property, $value, $sPropertySelector)
    {
        // forward
        if (!empty($sPropertySelector)) { $this->forwardSetEntityProperty($property, $sPropertySelector, $value); return; }
        
        
        // 
        // 
        // 
        // 1. is setValue id '' -> remove entityCache
        // 2. if no id set (omdat new entity), dan houd id leeg, maar vul aan onSave
        //
        //
        //
        
        
        // validate
        if (MimotoDataUtils::isEntity($value) && $value->getEntityType() !== $property->entityType) { throw new MimotoEntityException("( '-' ) - Sorry, the entity you are trying to set at '$property->name' has type '".$value->getEntityType()."' instead of type '$property->entityType'"); }

        if (MimotoDataUtils::isEntity($value) )
        {
            // store if change tracking is disabled
            if (!$this->_bTrackChanges) { $property->persistentId = $value->getId(); }

            // store
            $property->currentId = $value->getId();
            $property->entityCache = $value;

            return;
        }
        else
        if (MimotoDataUtils::isValidEntityId($value))
        {
            // store if change tracking is disabled
            if (!$this->_bTrackChanges) { $property->persistentId = $value; }

            // store
            $property->currentId = $value;

            return;
        }
        else
        if (empty($value) || $value == 0)
        {
            // store if change tracking is disabled
            if (!$this->_bTrackChanges) { unset($property->persistentId); }
            
            // clear
            unset($property->currentId);
            unset($property->entityCache);
            
            return;
        }

        // validate
        throw new MimotoEntityException("( '-' ) - Sorry, the entity or entity id you are trying to set at '$property->name' doesn't seem to be valid");
    }
    
    /**
     * Forward set entity property
     * @param object $property
     * @param string $sPropertySelector
     * @param mixed $value
     * @throws MimotoEntityException
     */
    private function forwardSetEntityProperty($property, $sPropertySelector, $value)
    {
        // validate
        if (!MimotoDataUtils::isValidEntityId($property->currentId)) { throw new MimotoEntityException("( '-' ) - Sorry, the entity '$property->name' for which you are trying to set the property '$sPropertySelector' doesn't seem to be set yet"); }
        
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
    private function readCollectionProperty($property, $bGetStorableValue)
    {
        //return $aMatchingProperties;
        
        
        // 1. if (this is collection and)    
        if (preg_match("/^{}$/", $sKey))
        {
            // 1. query, with && en || support, comma separated
            // 2. Example: {phase="archived"}
            
            // register
            $sExpression = substr($sKey, 1, strlen($sKey) - 1);
            $aExpressionElements = explode(self::EXPRESSION_SEPERATOR, $sExpression);

            // update
            $sExpressionKey = trim($aExpressionElements[0]);
            $sExpressionValue = trim($aExpressionElements[1]);

            // register
            $sFirstChar = $sExpressionValue[0];
            $sLastChar = $sExpressionValue[strlen($sExpressionValue) - 1];
            
            // cleanup
            if (($sFirstChar === "'" && $sLastChar === "'") || ($sFirstChar == '"' && $sLastChar == '"'))
            {
                $sExpressionValue = substr($sExpressionValue, 1, strlen($sExpressionValue) - 1);
            }
            
            // search all objects in collection
            //if (oData instanceof Array) // 1. of node is (object), dan anders omgaan met subnodes uitlezen
            {
                // 1. parent entity meegeven?
                foreach ($aProperties as $sKey -> $value)
                {
                   
                    
                    // validate
                    //if (oData[i][sExpressionKey] == sExpressionValue) {
                    //}
                }
            }
        }
        
        if (preg_match("/^\[\]$/", $sKey)) { /* array with comma separated multiple key support */ }
        
        
        // 1. regexp voor alles
        // 2. value voor alles
        if (preg_match("/^\/\/$/", $sKey)) { /* regexp */ } 
        //else { regular value }
        
        
        return $value = (object) array
        (
            'name' => $property->name,
            'value' => []
        );
    }
    
    
    
    
    private function setCollectionProperty($property, $value, $sPropertySelector)
    {
        // forward
        if (!empty($sPropertySelector)) { $this->forwardSetCollectionProperty($property, $sPropertySelector, $value); return; }
        // 1. in de forward komt de selector-query of [1]
        
        // validate
        if (!is_array($value)) { throw new MimotoEntityException("( '-' ) - The collection property '".$property->name."' can only accept an array"); }
        
        // 1. validate values in array
        // 2. check if subvalue or expression
        // 3. erzijn geen {} en  [], enkele {} want geen vrij object zoals json/MimotoData
        // 4. overhevelen waarden
        
        
        // init
        if (!$this->_bTrackChanges) { $property->persistentCollection = []; }
        $property->currentCollection = [];
        
        //print_r($value);
        
        $nItemCount = count($value);
        for ($i = 0; $i < $nItemCount; $i++)
        {
            // register
            $item = $value[$i];
            
            // init
            $subproperty = (object) array(
                'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION_ITEM,
                'entityType' => $property->allowedEntityTypes[0]
            );
            
            
            // validate
            if (MimotoDataUtils::isEntity($item) && $item->getEntityType() !== $subproperty->entityType) { throw new MimotoEntityException("( '-' ) - Sorry, the entity you are trying set in the collection '$property->name' has type '".$item->getEntityType()."' instead of type '".$property->allowedEntityTypes[0]."'"); }

            if (MimotoDataUtils::isEntity($item) )
            {
                // store if change tracking is disabled
                if (!$this->_bTrackChanges) { $subproperty->persistentId = $item->getId(); }

                // store
                $subproperty->currentId = $item->getId();
                $subproperty->entityCache = $item;
            }
            else
            if (MimotoDataUtils::isValidEntityId($value))
            {
                 // store if change tracking is disabled
                if (!$this->_bTrackChanges) { $subproperty->persistentId = $item; }

                // store
                $subproperty->currentId = $item;
            }
            
            
            
            //for ($j = 0; $j < $nItemCount; $j++) // check for doubles if options don't allow it
            //{
                //$property->currentCollection
            //}
            
            // store
            if (!$this->_bTrackChanges) { $property->persistentCollection[$i] = $subproperty; }
            $property->currentCollection[] = $subproperty;
        }
    }
    
    /**
     * Add collection property
     * @param object $property
     * @param mixed $value
     * @param string $sPropertySelector
     * @throws MimotoEntityException
     */
    private function addCollectionProperty($property, $value, $sPropertySelector)
    {
        // forward
        if (!empty($sPropertySelector)) { $this->forwardAddEntityProperty($property, $sPropertySelector, $value); return; }
        
        
        // 1. is setValue id '' -> remove entityCache
        // 2. if no id set (omdat new entity), dan houd id leeg, maar vul aan onSave
        
        
        // init
        $subproperty = (object) array(
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION_ITEM,
            'entityType' => $property->allowedEntityTypes[0]
        );
        
        
        // validate
        if (MimotoDataUtils::isEntity($value) && $value->getEntityType() !== $subproperty->entityType) { throw new MimotoEntityException("( '-' ) - Sorry, the entity you are trying to set at '$property->name' has type '".$value->getEntityType()."' instead of type '".$property->allowedEntityTypes[0]."'"); }

        if (MimotoDataUtils::isEntity($value) )
        {
            // store if change tracking is disabled
            if (!$this->_bTrackChanges) { $subproperty->persistentId = $value->getId(); }

            // store
            $subproperty->currentId = $value->getId();
            $subproperty->entityCache = $value;
        }
        else
        if (MimotoDataUtils::isValidEntityId($value))
        {
             // store if change tracking is disabled
            if (!$this->_bTrackChanges) { $subproperty->persistentId = $value; }

            // store
            $subproperty->currentId = $value;
        }

        // store
        if (!$this->_bTrackChanges) { $property->persistentCollection[$i] = $subproperty; }
        $property->currentCollection[] = $subproperty;
        
        
        // validate
        //throw new MimotoEntityException("( '-' ) - Sorry, the entity or entity id you are trying to set at '$property->name' doesn't seem to be valid");
    }
    
    
    
    // ----------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------
    // ----------------------------------------------------------------------------------
    
    
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
        if (count($aMatchingProperties) === 0) { throw new MimotoEntityException("( '-' ) - The property '$sPropertySelector' you are looking for doesn't seem to be here"); }        
        
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
        $sSubpropertySelector = substr($sPropertySelector, strlen($property->name));
        
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
        return (isset($this->_aValuesAsEntities[$sPropertyName]));
    }

    
    
//    
//    /**
//     * Add an item to a collection
//     * 
//     * @param string $sPropertySelector The selector containing the property name and optional subselector
//     * @param mixed $value The item (id or entity)
//     * @param index $nIndex (Optional) The index on which to add the item
//     * @throws MimotoEntityException
//     */
//    public function add($sPropertySelector, $value, $nIndex = null)
//    {
//        // prepare
//        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
//        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
//        
//        // load
//        //if ($this->hasProperty($sPropertyName)) { $property = $this->_aProperties[$sPropertyName]; }
//        $property = $this->_aProperties[$sPropertyName];
//        
//        // report
//        if ($property instanceof MimotoValueProperty) { throw new MimotoEntityException("( '-' ) - It's not possible to add an item to value"); }
//        
//        // forward
//        $property->add($sSubselector, $value, $nIndex);
//    }
//    
//    /**
//     * Remove an item from a collection
//     * 
//     * @param string $sPropertySelector The selector containing the property name and optional subselector
//     * @param mixed $value The item (id or entity)
//     * @throws MimotoEntityException
//     */
//    public function remove($sPropertySelector, $value)
//    {
//        // prepare
//        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
//        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
//        
//        // load
//        $property = $this->_aProperties[$sPropertyName];
//        
//        // report
//        if ($property instanceof MimotoValueProperty) { throw new MimotoEntityException("( '-' ) - It's not possible to remove an item from value"); }
//        
//        // forward
//        $property->from($sSubselector, $value);
//    }
//    
//    
//    
//    // ----------------------------------------------------------------------------
//    // --- Public methods ---------------------------------------------------------
//    // ----------------------------------------------------------------------------
//    
//    
//    /**
//     * Start tracking changes
//     */
//    public function trackChanges()
//    {
//        // toggle
//        $this->_bTrackChanges = true;
//        
//        // update
//        foreach ($this->_aProperties as $sPropertyName => $property) { $property->trackChanges(); }
//    }
//    
//    /**
//     * Check if the value was changed
//     * 
//     * @return boolean True if value was changed
//     */
//    public function hasChanges()
//    {
//        // init
//        $bHasChanges = false;
//        
//        foreach ($this->_aProperties as $sPropertyName => $property)
//        {
//            if ($property->hasChanges())
//            {
//                $bHasChanges = true;
//                break;
//            }
//        }
//        
//        // send
//        return $bHasChanges;
//    }
//    
//    /**
//     * Accept the changes made to the object
//     */
//    public function acceptChanges()
//    {
//        foreach ($this->_aProperties as $sPropertyName => $property)
//        {
//            //$this->_persistentId = $this->_currentId;
//        }
//    }
//    
//    /**
//     * Get Changes
//     * @return array Collection containing of all changed properties as key/value pairs
//     */
//    public function getChanges()
//    {
//        // init
//        $aModifiedValues = [];
//        
//        foreach ($this->_aProperties as $sPropertyName => $property)
//        {
//            
//            // check
//            if ($property->hasChanges())
//            {
//                if ($property instanceof MimotoValueProperty)
//                {
//                    $aModifiedValues[$sPropertyName] = $property->getValue();
//                }
//                else
//                if ($property instanceof MimotoEntityProperty)
//                {
//                    $aModifiedValues[$sPropertyName] = $property->getValue('', true);
//                }
//                else
//                if ($property instanceof MimotoCollectionProperty)
//                {
//                    // 1. check changes, of hele set?
//                    // 2. focus enkel op de changes in array aantal, items, volgorde
//                    // 3. oftwel: de connections
//                    // 4. misschien opvragen: changed items? of afhandelen in Repositori
//                }
//                else
//                if ($property instanceof MimotoData)
//                {
//                    // load
//                    $aModifiedSubvalues = $property->getChanges();
//                    
//                    // compose
//                    foreach($aModifiedSubvalues as $sKey => $value)
//                    {
//                        $aModifiedValues[$sPropertyName.'.'.$sKey] = $value;
//                    }
//                }
//            }
//        }
//        
//        // send
//        return $aModifiedValues;
//    }
//    
//    
//    
//    // ----------------------------------------------------------------------------
//    // --- Public methods - Aimless -----------------------------------------------
//    // ----------------------------------------------------------------------------
//    
//    
//    /**
//     * Get Aimless value of a property or subproperty
//     * @param string $sPropertySelector
//     * @return string The Aimless value for the supplied property selector
//     */
//    public function getAimlessValue($sPropertySelector)
//    {
//        // prepare
//        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
//        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
//        
//        // compose
//        $sAimlessValue = MimotoLiveScreenUtils::formatAimlessValue($this->getEntityType(), $this->getId(), $sPropertyName);
//        
//        // verify
//        if (!empty($sSubselector) && $this->valueRelatesToEntity($sPropertyName))
//        {
//            // load
//            $entity = $this->getValue($sPropertyName);
//            
//            // compose
//            if (MimotoEntityUtils::isEntity($entity))
//            {
//                
//                $sAimlessValue .= MimotoLiveScreenUtils::formatAimlessSubvalue($sPropertyName, $entity->getId(), $sSubselector);
//            }
//            else
//            {
//                $sAimlessValue .= MimotoLiveScreenUtils::formatAimlessSubvalueWithoutId($sPropertyName, $sSubselector);
//            }
//        }
//        
//        // send
//        return $sAimlessValue;
//    }
//    
//    /**
//     * Get Aimless id of an entity
//     * @return string The Aimless id for the supplied property selector
//     */
//    public function getAimlessId()
//    {
//        return $this->getEntityType().'.'.$this->getId();
//    }
//    

    
    
    
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
        return (!isset($this->_persistentValue) || $this->_persistentValue !== $this->_currentValue);
    }
    
    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        // update
        $this->_persistentValue = $this->_currentValue;
    }
    
}

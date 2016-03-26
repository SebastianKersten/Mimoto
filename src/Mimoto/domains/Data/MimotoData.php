<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\library\data\MimotoValueProperty;
use Mimoto\library\data\MimotoEntityProperty;
use Mimoto\library\data\MimotoCollectionProperty;
use Mimoto\library\data\MimotoDataUtils;
use Mimoto\library\data\MimotoDataPropertyInterface;
use Mimoto\LiveScreen\MimotoLiveScreenUtils;


/**
 * MimotoData
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoData implements MimotoDataPropertyInterface
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
     * @param string $sPropertySelector The selector containing the property name and optional subselector
     */
    public function setValueAsProperty($sPropertySelector)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        
        if ($sSubselector !== false)
        {
            // init or load existing
            $property = (!isset($this->_aProperties[$sPropertyName])) ? new Mimotodata($this->_bTrackChanges) : $this->_aProperties[$sPropertyName];
            
            // forward
            $property->setValueAsProperty($sSubselector);
        }
        else
        {
            // init
            $property = new MimotoValueProperty($this->_bTrackChanges);
        }
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set entity as property
     * 
     * @param string $sPropertySelector The selector containing the property name and optional subselector
     * @param string $sEntityType The type of the entity
     */
    public function setEntityAsProperty($sPropertySelector, $sEntityType)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        
        if ($sSubselector !== false)
        {
            // init or load existing
            $property = (!isset($this->_aProperties[$sPropertyName])) ? new Mimotodata($this->_bTrackChanges) : $this->_aProperties[$sPropertyName];
            
            // forward
            $property->setEntityAsProperty($sSubselector, $sEntityType);
        }
        else
        {
            // init
            $property = new MimotoEntityProperty($sEntityType, $this->_bTrackChanges);
        }
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set collection as property
     * 
     * @param string $sPropertySelector The selector containing the property name and optional subselector
     * @param string $sAllowedEntityType The entity type allowed in the collection
     */
    public function setCollectionAsProperty($sPropertySelector, $sAllowedEntityType)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        
        if ($sSubselector !== false)
        {
            // init or load existing
            $property = (!isset($this->_aProperties[$sPropertyName])) ? new Mimotodata($this->_bTrackChanges) : $this->_aProperties[$sPropertyName];
            
            // forward
            $property->setCollectionAsProperty($sSubselector, $sAllowedEntityType);
        }
        else
        {
            // init
            $property = new MimotoCollectionProperty($sAllowedEntityType, $this->_bTrackChanges);
        }
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods - usage -------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Check if the entity has a certain property
     * 
     * @param string $sPropertySelector The property name to be checked
     */
    public function hasProperty($sPropertySelector)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        if (!$this->hasProperty($sPropertyName)) { throw new MimotoEntityException("( '-' ) - Sorry, you seem so look for a property '$sPropertyName' that is not here"); }
        
        // load
        $property = $this->_aProperties[$sPropertyName];
        
        if (empty($sSubselector) || ($property instanceof MimotoValueProperty))
        {
            return isset($this->_aProperties[$sPropertyName]);
        }
        else
        {
            
            echo "Subselector=['$sSubselector']";
            // forward
            return $property->hasProperty($sSubselector);
        }
    }
    
    /**
     * Get value of property
     * 
     * @param string $sPropertySelector The selector containing the property name and optional subselector
     * @return mixed
     * @throws MimotoEntityException
     */
    public function getValue($sPropertySelector, $bGetStorableValue = false)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        if (!$this->hasProperty($sPropertyName)) { throw new MimotoEntityException("( '-' ) - Sorry, you seem so look for a property '$sPropertyName' that is not here"); }
        
        // load
        $property = $this->_aProperties[$sPropertyName];
        
        // forward
        return ($property instanceof MimotoValueProperty) ? $property->getValue() : $property->getValue($sSubselector, $bGetStorableValue);
    }
    
    /**
     * Set value
     * @param string $sPropertySelector
     * @param mixed $value
     */
    public function setValue($sPropertySelector, $value)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        // load
        $property = $this->_aProperties[$sPropertyName];
        
        // forward
        ($property instanceof MimotoValueProperty) ? $property->setValue($value) : $property->setValue($sSubselector, $value);
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
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        // load
        //if ($this->hasProperty($sPropertyName)) { $property = $this->_aProperties[$sPropertyName]; }
        $property = $this->_aProperties[$sPropertyName];
        
        // report
        if ($property instanceof MimotoValueProperty) { throw new MimotoEntityException("( '-' ) - It's not possible to add an item to value"); }
        
        // forward
        $property->add($sSubselector, $value, $nIndex);
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
        if ($property instanceof MimotoValueProperty) { throw new MimotoEntityException("( '-' ) - It's not possible to remove an item from value"); }
        
        // forward
        $property->from($sSubselector, $value);
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Start tracking changes
     */
    public function trackChanges()
    {
        // toggle
        $this->_bTrackChanges = true;
        
        // update
        foreach ($this->_aProperties as $sPropertyName => $property) { $property->trackChanges(); }
    }
    
    /**
     * Check if the value was changed
     * 
     * @return boolean True if value was changed
     */
    public function hasChanges()
    {
        // init
        $bHasChanges = false;
        
        foreach ($this->_aProperties as $sPropertyName => $property)
        {
            if ($property->hasChanges())
            {
                $bHasChanges = true;
                break;
            }
        }
        
        // send
        return $bHasChanges;
    }
    
    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        // update
        foreach ($this->_aProperties as $sPropertyName => $property) { $property->acceptChanges(); }
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
            
            // check
            if ($property->hasChanges())
            {
                if ($property instanceof MimotoValueProperty)
                {
                    $aModifiedValues[$sPropertyName] = $property->getValue();
                }
                else
                if ($property instanceof MimotoEntityProperty)
                {
                    $aModifiedValues[$sPropertyName] = $property->getValue('', true);
                }
                else
                if ($property instanceof MimotoCollectionProperty)
                {
                    // 1. check changes, of hele set?
                    // 2. focus enkel op de changes in array aantal, items, volgorde
                    // 3. oftwel: de connections
                    // 4. misschien opvragen: changed items? of afhandelen in Repositori
                }
                else
                if ($property instanceof MimotoData)
                {
                    // load
                    $aModifiedSubvalues = $property->getChanges();
                    
                    // compose
                    foreach($aModifiedSubvalues as $sKey => $value)
                    {
                        $aModifiedValues[$sPropertyName.'.'.$sKey] = $value;
                    }
                }
            }
        }
        
        // send
        return $aModifiedValues;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods - Aimless -----------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get Aimless value of a property or subproperty
     * @param string $sPropertySelector
     * @return string The Aimless value for the supplied property selector
     */
    public function getAimlessValue($sPropertySelector)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        // compose
        $sAimlessValue = MimotoLiveScreenUtils::formatAimlessValue($this->getEntityType(), $this->getId(), $sPropertyName);
        
        // verify
        if (!empty($sSubselector) && $this->valueRelatesToEntity($sPropertyName))
        {
            // load
            $entity = $this->getValue($sPropertyName);
            
            // compose
            if (MimotoEntityUtils::isEntity($entity))
            {
                
                $sAimlessValue .= MimotoLiveScreenUtils::formatAimlessSubvalue($sPropertyName, $entity->getId(), $sSubselector);
            }
            else
            {
                $sAimlessValue .= MimotoLiveScreenUtils::formatAimlessSubvalueWithoutId($sPropertyName, $sSubselector);
            }
        }
        
        // send
        return $sAimlessValue;
    }
    
    /**
     * Get Aimless id of an entity
     * @return string The Aimless id for the supplied property selector
     */
    public function getAimlessId()
    {
        return $this->getEntityType().'.'.$this->getId();
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    // 1. check op type
    
    
    private function valueRelatesToEntity($sPropertyName)
    {
        // verify and send
        return (isset($this->_aValuesAsEntities[$sPropertyName]));
    }
    
    private function storeValueAsEntity($sPropertyName, $entity)
    {
        $this->_aValuesAsEntities[$sPropertyName]->value = $entity;
    }
    
}

<?php

// classpath
namespace Mimoto\library\entities;


/**
 * MimotoEntity
 *
 * @author Sebastian Kersten
 */
class MimotoEntity
{
    
    /**
     * The entity's persistent values
     * @var array
     */
    private $_aPersistentValues;
    
    /**
     * The entity's current values
     * @var array
     */
    private $_aCurrentValues;
    
    /**
     * The entity's values as entities
     * @var array
     */
    private $_aValuesAsEntities;
    
    /**
     * Track change mode
     * @var boolean
     */
    private $_bTrackChanges;
    
    /**
     * The entity's id
     * @var int 
     */
    private $_nId = 0;
    
    /**
     * The entity's type
     * @var string 
     */
    private $_sEntityType = '';
    
    /**
     * The moment of creation
     * @var datetime
     */
    private $_datetimeCreated = 0;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties--------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the entity's type
     * 
     * @return string
     */
    public function getEntityType() { return $this->_sEntityType; }
    
    
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
     * Get the moment of creation
     * 
     * @return datetime
     */
    public function getCreated() { return $this->_datetimeCreated; }
    
    /**
     * Set the moment of creation
     * 
     * @param datetime $datetimeCreated The moment of creation
     */
    public function setCreated($datetimeCreated) { $this->_datetimeCreated = $datetimeCreated; }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor-------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param string $sEntityType
     */
    public function __construct($sEntityType, $bTrackChanges = true)
    {
        // register
        $this->_sEntityType = $sEntityType;
        $this->_bTrackChanges = $bTrackChanges;
        
        // init
        $this->_aPersistentValues = [];
        $this->_aCurrentValues = [];
        $this->_aValuesAsEntities = [];
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
    }
    
    /**
     * Get value
     * @param string $sPropertyName
     * @return mixed
     */
    public function getValue($sPropertyName)
    {
        // verify
        if (!$this->valueRelatesToEntity($sPropertyName)) return $this->_aCurrentValues[$sPropertyName];
        
        
        if (!is_nan($this->_aCurrentValues[$sPropertyName]) && $this->_aCurrentValues[$sPropertyName] > 0)
        {
            // register
            $service = $this->_aValuesAsEntities[$sPropertyName]->service;

            // load
            $entity = $service->getEntityById($this->_aCurrentValues[$sPropertyName]);

            // register
            $this->setValue($sPropertyName, $entity);
            
            // send
            return $entity;
        }
        else
        {
            return $this->_aCurrentValues[$sPropertyName];
        }
    }
    
    /**
     * Set value
     * @param string $sPropertyName
     * @param mixed $value
     */
    public function setValue($sPropertyName, $value)
    {
        // register
        $preparedValue = $value;
        
        // 1. is isEntity -> replace entity, replace ID from entoty in currentvalues
        // 2. if isString / isInt -> drop stored entity
        
        
        // verify
        if ($this->isEntity($value) && $this->valueRelatesToEntity($sPropertyName))
        {
            // register
            $entity = $value;
            
            // overwrite
            $preparedValue = $entity->getId();
            
            // store
            $this->storeValueAsEntity($sPropertyName, $entity);
        }
        else
        {
            if ($this->valueRelatesToEntity($sPropertyName))
            {
                echo "Different! ".$value."<br>";
                
                // 1. make sure this is an id!
                // 2. if (different from currentValue) -> change
                // 3. drop stroed entty
                
                // drop
                //$this->storeValueAsEntity($sPropertyName, null);
            }
        }
        
        // store
        if (!$this->_bTrackChanges) { $this->_aPersistentValues[$sPropertyName] = $preparedValue; }
        
        // store
        $this->_aCurrentValues[$sPropertyName] = $preparedValue;
    }
    
    /**
     * Set entity delegate
     * @param string $sPropertyName
     * @param MimotoService $service
     */
    public function setValueAsEntityService($sPropertyName, $service)
    {
        // init
        $valueAsEntity = (object) array();
        
        // setup
        $valueAsEntity->service = $service;
        
        // store        
        $this->_aValuesAsEntities[$sPropertyName] = $valueAsEntity;
    }
    
    /**
     * Get modified values
     * @return array Collection containing all modified values as key/value pair
     */
    public function getModifiedValues()
    {
        // init
        $aModifiedValues = [];
        
        // search
        foreach($this->_aCurrentValues as $sKey => $value)
        {
            // verify       
            if (!isset($this->_aPersistentValues[$sKey]) || $this->_aPersistentValues[$sKey] != $this->_aCurrentValues[$sKey])
            {
                $aModifiedValues[$sKey] = $value;
            }
        }
        
        // send
        return $aModifiedValues;
    }
    
    /**
     * Mark modified values as persistent
     */
    public function markModifiedValuesAsPersistent()
    {
        // search
        foreach($this->_aCurrentValues as $sKey => $value)
        {
            $this->_aPersistentValues[$sKey] = $this->_aCurrentValues[$sKey];
        }
    }
    
    /**
     * Get Aimless value of a property or subproperty
     * @param type $sPropertyName
     * @return string
     */
    public function getAimlessValue($sPropertyName)
    {
        // find
        $nSeperatorPos = strpos($sPropertyName, '.');
        
        // separate
        $sRemainingPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, $nSeperatorPos + 1) : '';
        $sFirstPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, 0, $nSeperatorPos) : $sPropertyName;
        
        // compose
        $sAimlessValue = $this->getEntityType().'.'.$this->getId().'.'.$sFirstPropertyName;
        
        // verify
        if (!empty($sRemainingPropertyName) && $this->valueRelatesToEntity($sFirstPropertyName))
        {
            // load
            $entity = $this->getValue($sFirstPropertyName);
            
            // compose
            if ($this->isEntity($entity))
            {
                $sAimlessValue .= '['.$entity->getAimlessValue($sRemainingPropertyName).']';
            }
            else
            {
                $sAimlessValue .= '['.$sPropertyName.']';
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
        return $this->getEntityType().'.'.$this->getId();
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    
    private function valueRelatesToEntity($sPropertyName)
    {
        // verify and send
        return (isset($this->_aValuesAsEntities[$sPropertyName]));
    }
    
    private function storeValueAsEntity($sPropertyName, $entity)
    {
        $this->_aValuesAsEntities[$sPropertyName]->value = $entity;
    }
    
    private function isEntity($value)
    {
        return ($value instanceof MimotoEntity);
    }
    
}
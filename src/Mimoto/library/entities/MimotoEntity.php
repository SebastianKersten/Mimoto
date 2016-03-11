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
    var $_aPersistentValues;
    
    /**
     * The entity's current values
     * @var array
     */
    var $_aCurrentValues;
    
    /**
     * Track change mode
     * @var boolean
     */
    var $_bTrackChanges;
    
    /**
     * The entity's id
     * @var int 
     */
    var $_nId = 0;
    
    /**
     * The entity's type
     * @var string 
     */
    var $_sEntityType = '';
    
    /**
     * The moment of creation
     * @var datetime
     */
    var $_datetimeCreated = 0;
    
    
    
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
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor-------------------------------------------------------------
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
     * @param string $sKey
     * @return mixed
     */
    public function getValue($sKey)
    {
        // load
        return $this->_aCurrentValues[$sKey];
    }
    
    /**
     * Set value
     * @param string $sKey
     * @param mixed $value
     */
    public function setValue($sKey, $value)
    {
        // store
        if (!$this->_bTrackChanges) { $this->_aPersistentValues[$sKey] = $value; }
        
        // store
        $this->_aCurrentValues[$sKey] = $value; 
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
    
}
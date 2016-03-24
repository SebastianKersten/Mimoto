<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Data\MimotoData;


/**
 * MimotoEntityValue
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntity extends MimotoData
{
    
    /**
     * The entity's id
     * @var int 
     */
    private $_nId;
    
    /**
     * The entity's type
     * @var string 
     */
    private $_sEntityType;
    
    /**
     * The moment of creation
     * @var datetime
     */
    private $_datetimeCreated;
    
    
    
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
        
        parent::__construct($bTrackChanges);
        
        // register
        $this->_sEntityType = $sEntityType;
        
    }
    
}

<?php

// classpath
namespace Mimoto\Entity;


/**
 * MimotoEntity
 *
 * @author Sebastian Kersten
 */
class MimotoEntity
{
    
    // #todo - track changes
    
    
    
    
    
    /**
     * The entity's type
     * @var string 
     */
    var $_sEntityType;
    
    /**
     * The entity's id
     * @var int 
     */
    var $_nId;
    
    
    
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
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor-------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param string $sEntityType
     */
    public function __construct($sEntityType)
    {
        // register
        $this->_sEntityType = $sEntityType;
    }
    
}
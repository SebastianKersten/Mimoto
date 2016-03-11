<?php

// classpath
namespace Mimoto\Service;


/**
 * MimotoService
 *
 * @author Sebastian Kersten
 */
class MimotoService
{
    
    /**
     * The entity's type
     * @var string 
     */
    var $_sEntityType;
    
    
    
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
    public function __construct($sEntityType)
    {
        // register
        $this->_sEntityType = $sEntityType;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public function --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param string $sEntityType
     */
    public function getEntityById($nId)
    {
        // register
        $this->_sEntityType = $sEntityType;
    }
}
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
    
    /**
     * The entity's name
     * @var string 
     */
    var $_sEntityName;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties--------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the entity's name
     * 
     * @return string
     */
    public function getEntityName() { return $this->_sEntityName; }
    
    /**
     * Set the entity's name
     * 
     * @param string $sEntityName The entity's name
     */
    public function setEntityName($sEntityName) { $this->_sEntityName = $sEntityName; }
    
}
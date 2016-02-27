<?php

// classpath
namespace MaidoProjects\Agency;


/**
 * The "Agency"-model contains the information of an agency
 *
 * @author Sebastian Kersten
 */
class Agency
{
    
    /**
     * The agency's id
     * @var int 
     */
    var $_nId = 0;
    
    /**
     * The agency's name
     * @var string
     */
    var $_sName = '';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
     /**
     * Get the agency's id
     * 
     * @return int
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the agency's id
     * 
     * @param int $nId The agency's id
     */
    public function setId($nId) { $this->_nId = $nId; }
    
    
    /**
     * Get the agency's name
     * 
     * @return string
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the agency's name
     * 
     * @param string $sName The agency's name
     */
    public function setName($sName) { $this->_sName = $sName; }
    
}
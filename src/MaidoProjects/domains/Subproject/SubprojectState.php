<?php

// classpath
namespace MaidoProjects\Subproject;


/**
 * The "SubprojectState"-model contains the information of a subproject state
 *
 * @author Sebastian Kersten
 */
class SubprojectState
{
    
    /**
     * The sub[project state's id
     * @var int 
     */
    var $_nId;
    
    /**
     * The subproject state's name
     * @var string
     */
    var $_sName;
    
    /**
     * The moment of creation
     * @var datetime
     */
    var $_datetimeCreated;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
     /**
     * Get the subproject state's id
     * 
     * @return int
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the subproject state's id
     * 
     * @param int $nId The subproject state's id
     */
    public function setId($nId) { $this->_nId = $nId; }
    
    
    /**
     * Get the subproject state's name
     * 
     * @return string
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the subproject state's name
     * 
     * @param string $sName The subproject state's name
     */
    public function setName($sName) { $this->_sName = $sName; }
    
    
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
    
}
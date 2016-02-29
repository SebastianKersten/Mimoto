<?php

// classpath
namespace MaidoProjects\Project;

/**
 * The "Project"-model contains the information of a project
 *
 * @author Sebastian Kersten
 */
class Project
{
    
    /**
     * The project's id
     * @var int 
     */
    var $_nId;
    
    /**
     * The project's name
     * @var string
     */
    var $_sName;
    
    /**
     * The project's description
     * @var string
     */
    var $_sDescription;
    
    /**
     * The project's client id
     * @var int 
     */
    var $_nClientId;
    
    /**
     * The project's client's name
     * @var string
     */
    var $_sClientName;
    
    /**
     * The project's agency id
     * @var int 
     */
    var $_nAgencyId;
    
    /**
     * The project's agency's name
     * @var string
     */
    var $_sAgencyName;
    
    /**
     * The project's project manager id
     * @var int 
     */
    var $_nProjectManagerId;
    
    /**
     * The project's project managers's name
     * @var string
     */
    var $_sProjectManagerName;
    
    /**
     * The project's subprojects
     * @var array
     */
    var $_aSubprojects;
    
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the project's id
     * 
     * @return int
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the project's id
     * 
     * @param int $nId The project's id
     */
    public function setId($nId) { $this->_nId = $nId; }
    
    
    /**
     * Get the project's name
     * 
     * @return string
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the project's name
     * 
     * @param string $sName The project's name
     */
    public function setName($sName) { $this->_sName = $sName; }
    
    
    /**
     * Get the project's description
     * 
     * @return string
     */
    public function getDescription() { return $this->_sDescription; }
    
    /**
     * Set the project's description
     * 
     * @param string $sDescription The project's description
     */
    public function setDescription($sDescription) { $this->_sDescription = $sDescription; }
    
    
    /**
     * Get the project's client id
     * 
     * @return int
     */
    public function getClientId() { return $this->_nClientId; }
    
    /**
     * Set the project's client id
     * 
     * @param int $nClientId The project's client id
     */
    public function setClientId($nClientId) { $this->_nClientId = $nClientId; }
    
    
    /**
     * Get the project's client's name
     * 
     * @return string
     */
    public function getClientName() { return $this->_sClientName; }
    
    /**
     * Set the project's client's name
     * 
     * @param string $sClientName The project's client's name
     */
    public function setClientName($sClientName) { $this->_sClientName = $sClientName; }
    
    
    /**
     * Get the project's agency id
     * 
     * @return int
     */
    public function getAgencyId() { return $this->_nAgencyId; }
    
    /**
     * Set the project's agency id
     * 
     * @param int $nAgencyId The project's agency id
     */
    public function setAgencyId($nAgencyId) { $this->_nAgencyId = $nAgencyId; }
    
    
    /**
     * Get the project's agency's name
     * 
     * @return string
     */
    public function getAgencyName() { return $this->_sAgencyName; }
    
    /**
     * Set the project's agency's name
     * 
     * @param string $sAgencyName The project's agency's name
     */
    public function setAgencyName($sAgencyName) { $this->_sAgencyName = $sAgencyName; }
    
    
    /**
     * Get the project's project manager id
     * 
     * @return int
     */
    public function getProjectManagerId() { return $this->_nProjectManagerId; }
    
    /**
     * Set the project's project manager id
     * 
     * @param int $nProjectManagerId The project's project manager id
     */
    public function setProjectManagerId($nProjectManagerId) { $this->_nProjectManagerId = $nProjectManagerId; }
    
    
    /**
     * Get the project's project manager's name
     * 
     * @return string
     */
    public function getProjectManagerName() { return $this->_sProjectManagerName; }
    
    /**
     * Set the project's project manager's name
     * 
     * @param string $sProjectManagerName The project's project manager's name
     */
    public function setProjectManagerName($sProjectManagerName) { $this->_sProjectManagerName = $sProjectManagerName; }
    
    
    
    // #todo - delegate
    
    
    /**
     * Get the project's subprojects
     * 
     * @return Array
     */
    public function getSubprojects() { return $this->_aSubprojects; }
    
     /**
     * Set the project's subprojects
     * 
     * @param array $aSubprojects The project's subprojects
     */
    public function setSubprojects($aSubprojects) { $this->_aSubprojects = $aSubprojects; }
    
}

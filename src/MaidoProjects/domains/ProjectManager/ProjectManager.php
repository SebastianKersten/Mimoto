<?php

// classpath
namespace MaidoProjects\ProjectManager;

/**
 * The "ProjectManager"-model contains the information of a project manager
 *
 * @author Sebastian Kersten
 */
class ProjectManager
{
    
    /**
     * The client's id
     * @var int 
     */
    var $_nId = 0;
    
    /**
     * The project manager's name
     * @var string
     */
    var $_sName = '';
    
    /**
     * The URL of the project manager's avatar
     * @var string
     */
    var $_sAvatarURL = '';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
     /**
     * Get the project manager's id
     * 
     * @return int
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the project manager's id
     * 
     * @param int $nId The project manager's id
     */
    public function setId($nId) { $this->_nId = $nId; }
    
    
    /**
     * Get the project manager's name
     * 
     * @return string
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the project manager's name
     * 
     * @param string $sName The project manager's name
     */
    public function setName($sName) { $this->_sName = $sName; }
    
    
    /**
     * Get the URL of the project manager's avatar
     * 
     * @return string
     */
    public function getAvatarURL() { return $this->_sAvatarURL; }
    
    /**
     * Set the URL of the project manager's avatar
     * 
     * @param string $sAvatarURL The URL of the project manager's avatar
     */
    public function setAvatarURL($sAvatarURL) { $this->_sAvatarURL = $sAvatarURL; }
}

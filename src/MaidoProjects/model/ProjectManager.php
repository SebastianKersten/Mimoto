<?php

/**
 * The "ProjectManager"-model contains the information of a project manager
 *
 * @author Sebastian Kersten (sebastian@momkai.com)
 */
class ProjectManager
{
    
    /**
     * The client's id
     * @var number 
     */
    var $_nId = 0;
    
    /**
     * The project manager's first name
     * @var string
     */
    var $_sFirstName = '';
    
    /**
     * The project manager's last name
     * @var string
     */
    var $_sLastName = '';
    
    /**
     * The URL of the project manager's avatar
     * @var string
     */
    var $_sAvatarURL = '';
    
    
     /**
     * Get the project manager's id
     * 
     * @return number
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the project manager's id
     * 
     * @param string $nId The project manager's id
     */
    public function setId($nId) { $this->_nId = $nId; }
    
    
    /**
     * Get the project manager's first name
     * 
     * @return string
     */
    public function getFirstName() { return $this->_sFirstName; }
    
    /**
     * Set the project manager's first name
     * 
     * @param string $sFirstName The project manager's first name
     */
    public function setFirstName($sFirstName) { $this->_sFirstName = $sFirstName; }
    
    
    /**
     * Get the project manager's last name
     * 
     * @return string
     */
    public function getLastName() { return $this->_sLastName; }
    
    /**
     * Set the project manager's last name
     * 
     * @param string $sLastName The project manager's last name
     */
    public function setLastName($sLastName) { $this->_sLastName = $sLastName; }
    
    
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

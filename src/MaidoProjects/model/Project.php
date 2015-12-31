<?php

/**
 * The "Project"-model contains the information of a project
 *
 * @author Sebastian Kersten (sebastian@momkai.com)
 */
class Project
{
    
    /**
     * The project's id
     * @var number 
     */
    var $_nId = 0;
    
    /**
     * The project's name
     * @var string
     */
    var $_sName = '';
    
    
    
     /**
     * Get the project's id
     * 
     * @return number
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the project's id
     * 
     * @param string $nId The project's id
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
    
}

<?php

namespace MaidoProjects\Subproject;


/**
 * The "SubprojectState"-model contains the information of a subproject state
 *
 * @author Sebastian Kersten (sebastian@momkai.com)
 */
class SubprojectState
{
    
    /**
     * The client's id
     * @var number 
     */
    var $_nId = 0;
    
    /**
     * The client's name
     * @var string
     */
    var $_sName = '';
    
    
     /**
     * Get the subproject's id
     * 
     * @return number
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the subproject state's id
     * 
     * @param string $nId The subproject state's id
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
    
}
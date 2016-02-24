<?php

namespace MaidoProjects\Subproject;

/**
 * The "Subproject"-model contains the information of a subproject
 *
 * @author Sebastian Kersten (sebastian@momkai.com)
 */
class Subproject
{
    
    /**
     * The subproject's id
     * @var number 
     */
    var $_nId = 0;
    
    /**
     * The subproject's name
     * @var string
     */
    var $_sName = '';
    
    
    #todo status, budget, slagingskans, periode
    
    
    /**
     * Get the subproject's id
     * 
     * @return number
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the subproject's id
     * 
     * @param string $nId The subproject's id
     */
    public function setId($nId) { $this->_nId = $nId; }
    
    
    /**
     * Get the subproject's name
     * 
     * @return string
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the subproject's name
     * 
     * @param string $sName The subproject's name
     */
    public function setName($sName) { $this->_sName = $sName; }
    
}

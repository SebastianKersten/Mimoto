<?php

/**
 * The "SubprojectPart"-model contains the information of a subproject part
 *
 * @author Sebastian Kersten (@supertaboo) (sebastian@momkai.com)
 */
class SubrojectPart
{
    
    /**
     * The subproject part's id
     * @var number 
     */
    var $_nId = 0;
    
    /**
     * The subproject part's name
     * @var string
     */
    var $_sName = '';
    
    
    
    /**
     * Get the subproject part's id
     * 
     * @return number
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the subproject part's id
     * 
     * @param string $nId The subproject part's id
     */
    public function setId($nId) { $this->_nId = $nId; }
    
    
    /**
     * Get the subproject part's name
     * 
     * @return string
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the subproject part's name
     * 
     * @param string $sName The subproject part's name
     */
    public function setName($sName) { $this->_sName = $sName; }
    
}

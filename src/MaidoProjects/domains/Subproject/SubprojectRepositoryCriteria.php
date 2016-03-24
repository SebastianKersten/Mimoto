<?php

// classpath
namespace MaidoProjects\Subproject;


/**
 * SubprojectRepositoryCriteria
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SubprojectRepositoryCriteria
{
    
    // private
    const ALL = 'all';
    const BY_PROJECT_ID = 'by_project_id';
    
    
    /**
     * The criterium
     * @var string 
     */
    var $_sCriterium;
    
    /**
     * The project's id
     * @var int 
     */
    var $_nProjectId;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // default
        $this->_sCriterium = self::ALL;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the criterium
     * 
     * @return string
     */
    public function getCriterium() { return $this->_sCriterium; }
    
    /**
     * Set the criterium
     * 
     * @param string $sCriterium The criterium
     */
    public function setCriterium($sCriterium) { $this->_sCriterium = $sCriterium; }
    
    
    /**
     * Get the project's id
     * 
     * @return int
     */
    public function getProjectId() { return $this->_nProjectId; }
    
    /**
     * Set the project's id
     * 
     * @param int $nProjectId The project's id
     */
    public function setProjectId($nProjectId) { $this->_nProjectId = $nProjectId; }
    
}

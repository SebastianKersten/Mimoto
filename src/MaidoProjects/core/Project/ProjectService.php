<?php

// classspath
namespace MaidoProjects\Project;

// Momkai classes
use MaidoProjects\Project\ProjectRepository;


/**
 * ProjectService
 *
 * @author Sebastian Kersten
 */
class ProjectService
{
    
    // services
    private $_SubprojectService;
    private $_ProjectManagerService;
    private $_ClientService;
    private $_AgencyService;
    
    // repositories
    private $_ProjectRepository;
    
    // mysql tables
    const MYSQL_TABLE_SUBPROJECT_STATES = 'subproject_states';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Contructor
     * @param type $SubprojectService
     */
    public function __construct($SubprojectService, $ProjectManagerService, $ClientService, $AgencyService, $ProjectRepository)
    {
        // register services
        $this->_SubprojectService = $SubprojectService;
        $this->_ProjectManagerService = $ProjectManagerService;
        $this->_ClientService = $ClientService;
        $this->_AgencyService = $AgencyService;
        
        // register repositories
        $this->_ProjectRepository = $ProjectRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get all projects
     */
    public function getAllProjects()
    {
        // load
        $aProjects = $this->_ProjectRepository->find();
        
        // send
        return $aProjects;
    }
    
}

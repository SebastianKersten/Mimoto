<?php

// classpath
namespace MaidoProjects\Project;

// Momkai classes
use Mimoto\library\repositories\MimotoSingleMySQLTableRepository;


/**
 * ProjectRepository
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ProjectRepository extends MimotoSingleMySQLTableRepository
{
    
    // services
    private $_SubprojectService;
    private $_ProjectManagerService;
    private $_ClientService;
    private $_AgencyService;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($EventService, $SubprojectService, $ClientService, $AgencyService, $ProjectManagerService)
    {
        
        // init parent
        parent::__construct($EventService);
        
        // register services
        $this->_SubprojectService = $SubprojectService;
        $this->_ClientService = $ClientService;
        $this->_AgencyService = $AgencyService;
        $this->_ProjectManagerService = $ProjectManagerService;
        
        
        // setup
        $this->setModelClass('MaidoProjects\Project\Project');
        $this->setModelExceptionClass('MaidoProjects\Project\ProjectException');
        $this->setModelEventClass('MaidoProjects\Project\ProjectEvent');
        $this->setMySQLTable('projects');
        
        // connect
        $this->setValueAsProperty('name', 'name');
        $this->setValueAsProperty('description', 'description');
        $this->setEntityAsProperty('client', 'client_id', $this->_ClientService);
        $this->setEntityAsProperty('agency', 'agency_id', $this->_AgencyService);
        $this->setEntityAsProperty('projectmanager', 'projectmanager_id', $this->_ProjectManagerService);
        $this->setCollectionAsProperty('subprojects', 'projects_subprojects', $this->_SubprojectService);
    }
   
}
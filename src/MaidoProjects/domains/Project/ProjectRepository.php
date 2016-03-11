<?php

// classpath
namespace MaidoProjects\Project;

// Momkai classes
use Mimoto\library\repositories\MimotoSingleMySQLTableRepository;


/**
 * ProjectRepository
 *
 * @author Sebastian Kersten
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
    public function __construct($EventService, $SubprojectService, $ProjectManagerService, $ClientService, $AgencyService)
    {
        
        // init parent
        parent::__construct($EventService);
        
        // register services
        $this->_SubprojectService = $SubprojectService;
        $this->_ProjectManagerService = $ProjectManagerService;
        $this->_ClientService = $ClientService;
        $this->_AgencyService = $AgencyService;
        
        
        // setup
        $this->setModelClass('MaidoProjects\Project\Project');
        $this->setModelExceptionClass('MaidoProjects\Project\ProjectException');
        $this->setModelEventClass('MaidoProjects\Project\ProjectEvent');
        $this->setMySQLTable('projects');
        
        // connect
        $this->setModelToMySQLTableMap(
            [
                (object) array('property' => 'name', 'dbcolumn' => 'name'),
                (object) array('property' => 'description', 'dbcolumn' => 'description'),
                (object) array('property' => 'client_id', 'dbcolumn' => 'client_id', 'entity' => 'client', 'entityService' => $this->_ClientService),
                (object) array('property' => 'agency_id', 'dbcolumn' => 'agency_id', 'entity' => 'agency', 'entityService' => $this->_AgencyService),
                (object) array('property' => 'projectmanager_id', 'dbcolumn' => 'projectmanager_id', 'entity' => 'projectmanager', 'entityService' => $this->_ProjectManagerService),
            ]
        );
        
        // connect
        /*$this->setPublicMapping(
            [
                (object) array('property' => 'Name', 'column' => 'name'),
                (object) array('property' => 'Description', 'column' => 'description'),
                (object) array('property' => 'ClientId', 'column' => 'client_id', 'entity' => 'client', 'entityService' => $this->_ClientService),
                (object) array('property' => 'AgencyId', 'column' => 'agency_id', 'entity' => 'agency', 'entityService' => $this->_AgencyService),
                (object) array('property' => 'ProjectManagerId', 'column' => 'projectmanager_id', 'entity' => 'projectmanager', 'entityService' => $this->_ProjectManagerService),
            ]
        );*/
        
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get single project by ID
     * @param int $nId
     * @return Project
     * @throws ProjectException
     */
    public function get($nId)
    {
        // forward
        $project = parent::get($nId);
        
        // complete with data for presentation
        $project = $this->addPresentationDataToProject($project);
        
        // send
        return $project;
    }
    
    /**
     * Find projects
     * @return Array containing Projects
     */
    public function find()
    {
        // forward
        $aProjects = parent::find();
        $nProjectCount = count($aProjects);
        
        // complete with data for presentation
        for ($i = 0; $i < $nProjectCount; $i++)
        {
            $aProjects[$i] = $this->addPresentationDataToProject($aProjects[$i]);
        }
        
        // send
        return $aProjects;
    }
    
    public function store($project)
    {
        // complete with data for presentation
        $project = $this->addPresentationDataToProject($project);
        
        // forward
        parent::store($project);
    }
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Add presentation data to project
     * @param Project $project
     * @return Project
     */
    private function addPresentationDataToProject($project)
    {   
        // register data for presentation
        $project->setClientName($this->_ClientService->getClientById($project->getClientId())->getName());
        if (!empty($project->getAgencyId())) { $project->setAgencyName($this->_AgencyService->getAgencyById($project->getAgencyId())->getName()); }
        $project->setProjectManagerName($this->_ProjectManagerService->getProjectManagerById($project->getProjectManagerId())->getName());
        
        $project->setSubprojects($this->_SubprojectService->getAllSubprojectsByProjectId($project->getId()));
        
        // send
        return $project;   
    }
        
}

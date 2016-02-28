<?php

// classpath
namespace MaidoProjects\Project;

// Momkai classes
use MaidoProjects\Project\Project;
use MaidoProjects\Project\ProjectException;


/**
 * ProjectRepository
 *
 * @author Sebastian Kersten
 */
class ProjectRepository
{
    
    // services
    private $_SubprojectService;
    private $_ProjectManagerService;
    private $_ClientService;
    private $_AgencyService;
    
    // mysql tables
    const MYSQL_TABLE_PROJECTS = 'projects';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($SubprojectService, $ProjectManagerService, $ClientService, $AgencyService)
    {
        // register services
        $this->_SubprojectService = $SubprojectService;
        $this->_ProjectManagerService = $ProjectManagerService;
        $this->_ClientService = $ClientService;
        $this->_AgencyService = $AgencyService;
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
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_PROJECTS." WHERE id=".$nId;
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        if ($nItemCount !== 1)
        {
             throw new ProjectException('Cannot find project with ID='.$nId);
        }
        else
        {
            // send
            return $this->createProjectFromMySQLResult($result, 0);
        }
    }
    
    /**
     * Find projects
     * @return Array containing Projects
     */
    public function find()
    {
        
        // init
        $aProjects = array();
        
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_PROJECTS." ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            // register
            $aProjects[] = $this->createProjectFromMySQLResult($result, $i);
        }
        
        // send
        return $aProjects;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Create Project from MySQL result
     * @param MySQL query result $mysqlResult
     * @param int $nIndex
     * @return Project
     */
    private function createProjectFromMySQLResult($mysqlResult, $nIndex)
    {
        // init
        $project = new Project();
        
        // register
        $project->setId(mysql_result($mysqlResult, $nIndex, 'id'));
        $project->setName(mysql_result($mysqlResult, $nIndex, 'name'));
        $project->setDescription(mysql_result($mysqlResult, $nIndex, 'description'));
        $project->setClientId(mysql_result($mysqlResult, $nIndex, 'client_id'));
        $project->setAgencyId(mysql_result($mysqlResult, $nIndex, 'agency_id'));
        $project->setProjectManagerId(mysql_result($mysqlResult, $nIndex, 'projectmanager_id'));

        // register data for presentation
        $project->setClientName($this->_ClientService->getClientById($project->getClientId())->getName());
        if (!empty($project->getAgencyId())) { $project->setAgencyName($this->_AgencyService->getAgencyById($project->getAgencyId())->getName()); }
        $project->setProjectManagerName($this->_ProjectManagerService->getProjectManagerById($project->getProjectManagerId())->getName());
        
        
        $project->setSubprojects($this->_SubprojectService->getAllSubprojectsByProjectId($project->getId()));
        
        // send
        return $project;   
    }
    
    
    /*
     * Set retriever
     * 
     * $aSubprojects = array();

            for ($j = 0; $j < $nSubprojectCount; $j++)
            {
                
                $subproject = array();
            
                // --- project ---
                $subproject['id'] = mysql_result($resultSubprojects, $i, 'id');
                $subproject['name'] = mysql_result($resultSubprojects, $i, 'name');
                $subproject['phase'] = mysql_result($resultSubprojects, $i, 'phase');
                
                $project['subprojects'][] = $subproject;
            }
     * 
     * 
     * 
     */
        
}

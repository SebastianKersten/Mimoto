<?php

// classspath
namespace MaidoProjects\Project;

// Momkai classes
use MaidoProjects\Project\Project;
use MaidoProjects\Project\ProjectException;

// Mimoto classes
use Mimoto\library\services\MimotoService;


/**
 * ProjectService
 *
 * @author Sebastian Kersten
 */
class ProjectService extends MimotoService
{
    
    /**
     * Contructor
     * @param repository $ProjectRepository
     */
    public function __construct($ProjectRepository)
    {   
        // register
        $this->setMainRepository($ProjectRepository);
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get project by ID
     */
    public function getProjectById($nId)
    {
        // load
        try
        {
            $project = $this->getMainRepository()->get($nId);
        }
        catch(ProjectException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $project;
    }
    
    /**
     * Get all projects
     */
    public function getAllProjects()
    {
        // load
        $aProjects = $this->getMainRepository()->find();
        
        // send
        return $aProjects;
    }
    
    /**
     * Store project
     */
    public function storeProject($nId, $sName, $sDescription, $nClientId, $nAgencyId, $nProjectManagerId)
    {
        // load or create
        $project = (!is_nan($nId) && $nId > 0) ? $this->getMainRepository()->get($nId) : $this->getMainRepository()->create();
        
        // register
        $project->setName($sName);
        $project->setDescription($sDescription);
        $project->setClient($nClientId);
        $project->setAgency($nAgencyId);
        $project->setProjectManager($nProjectManagerId);
        
        // store
        $this->getMainRepository()->store($project);
    }
    
}

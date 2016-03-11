<?php

// classspath
namespace MaidoProjects\Project;

// Momkai classes
use MaidoProjects\Project\Project;
use MaidoProjects\Project\ProjectException;


/**
 * ProjectService
 *
 * @author Sebastian Kersten
 */
class ProjectService
{
    
    // repositories
    private $_ProjectRepository;
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Contructor
     * @param repository $ProjectRepository
     */
    public function __construct($ProjectRepository)
    {   
        // register repositories
        $this->_ProjectRepository = $ProjectRepository;
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
            $project = $this->_ProjectRepository->get($nId);
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
        $aProjects = $this->_ProjectRepository->find();
        
        // send
        return $aProjects;
    }
    
    /**
     * Store project
     */
    public function storeProject($nId, $sName, $sDescription, $nClientId, $nAgencyId, $nProjectManagerId)
    {
        
        // init
        $project = new Project();
        
        // register
        $project->setId($nId);
        $project->setName($sName);
        $project->setDescription($sDescription);
        $project->setClientId($nClientId);
        $project->setAgencyId($nAgencyId);
        $project->setProjectManagerId($nProjectManagerId);
        
        // store
        $this->_ProjectRepository->store($project);
    }
    
}

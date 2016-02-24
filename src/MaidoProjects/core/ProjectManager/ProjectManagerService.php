<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Momkai classes
use MaidoProjects\ProjectManager\ProjectManagerRepository;
use MaidoProjects\ProjectManager\ProjectManagerException;


/**
 * ProjectManagerService
 *
 * @author Sebastian Kersten
 */
class ProjectManagerService
{
    
    // repositories
    private $_ProjectManagerRepository;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($ProjectManagerRepository)
    {
        // init
        $this->_ProjectManagerRepository = $ProjectManagerRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get project manager by ID
     */
    public function getProjectManagerById($nId)
    {
         // load
        try
        {
            $projectManager = $this->_ProjectManagerRepository->get($nId);
        }
        catch(ProjectManagerException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $projectManager;
    }
    
    /**
     * Get all clients
     */
    public function getAllProjectManagers()
    {
        // load
        $aProjectManagers = $this->_ProjectManagerRepository->find();
        
        // send
        return $aProjectManagers;
    }
    
    /**
     * Store project manager
     */
    public function storeProjectManager($nId, $sName)
    {
        // store
        $this->_ProjectManagerRepository->store($nId, $sName);
    }
    
}
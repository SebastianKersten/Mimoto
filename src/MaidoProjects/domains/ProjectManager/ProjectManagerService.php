<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Momkai classes
use MaidoProjects\ProjectManager\ProjectManager;
use MaidoProjects\ProjectManager\ProjectManagerException;

// Mimoto classes
use Mimoto\library\services\MimotoService;


/**
 * ProjectManagerService
 *
 * @author Sebastian Kersten
 */
class ProjectManagerService extends MimotoService
{
    
    /**
     * Constructor
     */
    public function __construct($ProjectManagerRepository)
    {
        // register
        $this->setMainRepository($ProjectManagerRepository);
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
            $projectManager = $this->getMainRepository()->get($nId);
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
        $aProjectManagers = $this->getMainRepository()->find();
        
        // send
        return $aProjectManagers;
    }
    
    /**
     * Store project manager
     */
    public function storeProjectManager($nId, $sName)
    {
        // init
        $projectManager = new ProjectManager();
        
        // register
        $projectManager->setId($nId);
        $projectManager->setName($sName);
        
        // store
        $this->getMainRepository()->store($projectManager);
    }
    
}
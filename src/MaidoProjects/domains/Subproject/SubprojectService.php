<?php

// classpath
namespace MaidoProjects\Subproject;

// Momkai classes
use MaidoProjects\Subproject\Subproject;
use MaidoProjects\Subproject\SubprojectException;

// Mimoto classes
use Mimoto\library\services\MimotoService;


/**
 * SubprojectService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SubprojectService extends MimotoService
{
    
    /**
     * Constructor
     */
    public function __construct($SubprojectRepository)
    {
        // register
        $this->setMainRepository($SubprojectRepository);
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get subproject by ID
     * @return Subproject
     */
    public function getSubprojectById($nId)
    {   
        // load
        try
        {
            $subproject = $this->getMainRepository()->get($nId);
        }
        catch(SubprojectException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $subproject;
    }
    
    /**
     * Get all subprojects
     * @return Array containing Subprojects
     */
    public function getAllSubprojectsByProjectId($nProjectId)
    {   
        // configure
        $criteria = new SubprojectRepositoryCriteria();
        $criteria->setCriterium(SubprojectRepositoryCriteria::BY_PROJECT_ID);
        $criteria->setProjectId($nProjectId);
        
        // load
        $aSubprojects = $this->getMainRepository()->find($criteria);
        
        // send
        return $aSubprojects;
    }
    
    /**
     * Store subproject
     */
    public function storeSubproject($nId, $sName)
    {
        // store
        $this->getMainRepository()->store($nId, $sName);
    }
    
}

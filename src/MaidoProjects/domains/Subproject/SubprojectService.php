<?php

// classpath
namespace MaidoProjects\Subproject;

// Momkai classes
use MaidoProjects\Subproject\Subproject;
use MaidoProjects\Subproject\SubprojectException;


/**
 * SubprojectService
 *
 * @author Sebastian Kersten
 */
class SubprojectService
{
    
     // repositories
    private $_SubprojectRepository;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($SubprojectRepository)
    {
        // register
        $this->_SubprojectRepository = $SubprojectRepository;
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
            $subproject = $this->_SubprojectRepository->get($nId);
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
        $aSubprojects = $this->_SubprojectRepository->find($criteria);
        
        // send
        return $aSubprojects;
    }
    
    /**
     * Store subproject
     */
    public function storeSubproject($nId, $sName)
    {
        // store
        $this->_SubprojectRepository->store($nId, $sName);
    }
    
}

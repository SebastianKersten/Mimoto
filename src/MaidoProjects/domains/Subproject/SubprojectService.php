<?php

// classpath
namespace MaidoProjects\Subproject;

// Momkai classes
use MaidoProjects\Subproject\SubprojectRepositoryCriteria;


/**
 * SubprojectService
 *
 * @author Sebastian Kersten
 */
class SubprojectService
{
    
     // repositories
    private $_SubprojectRepository;
    private $_SubprojectStateRepository;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($SubprojectRepository, $SubprojectStateRepository)
    {
        // register
        $this->_SubprojectRepository = $SubprojectRepository;
        $this->_SubprojectStateRepository = $SubprojectStateRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    // --- Subprojects ---
    
    
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
    
    
    
    // --- SubprojectStates ----
    
    
    /**
     * Get subproject state by ID
     * @return SubprojectState
     */
    public function getSubprojectStateById($nId)
    {   
        // load
        try
        {
            $subprojectState = $this->_SubprojectStateRepository->get($nId);
        }
        catch(SubprojectStateException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $subprojectState;
    }
    
    /**
     * Get all subprojects states
     * @return Array containing SubprojectStates
     */
    public function getAllSubprojectStates()
    {   
         // load
        $aSubprojectStates = $this->_SubprojectStateRepository->find();
        
        // send
        return $aSubprojectStates;
    }
    
    /**
     * Store subproject state
     */
    public function storeSubprojectState($nId, $sName)
    {
        // store
        $this->_SubprojectStateRepository->store($nId, $sName);
    }
    
}

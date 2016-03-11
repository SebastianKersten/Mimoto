<?php

// classpath
namespace MaidoProjects\SubprojectState;

// Momkai classes
use MaidoProjects\SubprojectState\SubprojectState;
use MaidoProjects\SubprojectState\SubprojectStateException;


/**
 * SubprojectService
 *
 * @author Sebastian Kersten
 */
class SubprojectStateService
{
    
     // repositories
    private $_SubprojectStateRepository;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($SubprojectStateRepository)
    {
        // register
        $this->_SubprojectStateRepository = $SubprojectStateRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    
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
        // init
        $subprojectState = new SubprojectState();
        
        // register
        $subprojectState->setId($nId);
        $subprojectState->setName($sName);
        
        // store
        $this->_SubprojectStateRepository->store($subprojectState);
    }
    
}

<?php

// classpath
namespace MaidoProjects\SubprojectState;

// Momkai classes
use MaidoProjects\SubprojectState\SubprojectState;
use MaidoProjects\SubprojectState\SubprojectStateException;

// Mimoto classes
use Mimoto\library\services\MimotoService;


/**
 * SubprojectService
 *
 * @author Sebastian Kersten
 */
class SubprojectStateService extends MimotoService
{
    
    /**
     * Constructor
     */
    public function __construct($SubprojectStateRepository)
    {
        // register
        $this->setMainRepository($SubprojectStateRepository);
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
            $subprojectState = $this->getMainRepository()->get($nId);
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
        $aSubprojectStates = $this->getMainRepository()->find();
        
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
        $this->getMainRepository()->store($subprojectState);
    }
    
}

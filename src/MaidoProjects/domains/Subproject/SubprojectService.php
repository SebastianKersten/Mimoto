<?php

// classpath
namespace MaidoProjects\Subproject;

// Momkai classes
use MaidoProjects\Subproject\SubprojectRepository;
use MaidoProjects\Subproject\SubprojectStateRepository;


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
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // init
        $this->_SubprojectRepository = new SubprojectRepository();
        $this->_SubprojectStateRepository = new SubprojectStateRepository();
    }
    
    
    
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
    public function getAllSubprojects()
    {   
        // load
        $aSubprojects = $this->_SubprojectRepository->find();
        
        // send
        return $aSubprojects;
    }
    
    
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
    
}

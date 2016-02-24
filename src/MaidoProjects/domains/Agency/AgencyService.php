<?php

// classpath
namespace MaidoProjects\Agency;

// Momkai classes
use MaidoProjects\Agency\Agency;
use MaidoProjects\Agency\AgencyException;


/**
 * AgencyService
 *
 * @author Sebastian Kersten
 */
class AgencyService
{
    
    // repositories
    private $_AgencyRepository;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // init
        $this->_AgencyRepository = new AgencyRepository();
    }
    
    /**
     * Get agency by ID
     */
    public function getAgencyById($nId)
    {
        // load
        try
        {
            $agency = $this->_AgencyRepository->get($nId);
        }
        catch(AgencyException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $agency;
    }
    
    /**
     * Get all agencies
     */
    public function getAllAgencies()
    {
        // load
        $aAgencies = $this->_AgencyRepository->find();
        
        // send
        return $aAgencies;
    }
    
}
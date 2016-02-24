<?php

// classpath
namespace MaidoProjects\Agency;

// Momkai classes
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
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($AgencyRepository)
    {
        // init
        $this->_AgencyRepository = $AgencyRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
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
    
    /**
     * Store agency
     */
    public function storeAgency($nId, $sName)
    {
        // store
        $this->_AgencyRepository->store($nId, $sName);
    }
    
}
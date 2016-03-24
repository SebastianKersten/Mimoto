<?php

// classpath
namespace MaidoProjects\Form;

// Momkai classes
use MaidoProjects\Agency\AgencyException;


/**
 * AgencyService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormService
{
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct() {}
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get agency by ID
     */
    public function createForm($sEntityType, $nId) // separate form/forminputs-models met config parameters
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
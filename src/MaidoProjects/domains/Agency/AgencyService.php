<?php

// classpath
namespace MaidoProjects\Agency;

// Momkai classes
use MaidoProjects\Agency\Agency;
use MaidoProjects\Agency\AgencyException;

// Mimoto classes
use Mimoto\library\services\MimotoService;


/**
 * AgencyService
 *
 * @author Sebastian Kersten
 */
class AgencyService extends MimotoService
{
    
    /**
     * Constructor
     */
    public function __construct($AgencyRepository)
    {
        // register
        $this->setMainRepository($AgencyRepository);
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get agency by ID
     */
    public function getAgencyById($nId)
    {
        // load
        try
        {
            $agency = $this->getMainRepository()->get($nId);
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
        $aAgencies = $this->getMainRepository()->find();
        
        // send
        return $aAgencies;
    }
    
    /**
     * Store agency
     */
    public function storeAgency($nId, $sName)
    {
        
        // init
        $agency = new Agency();
        
        // register
        $agency->setId($nId);
        $agency->setName($sName);
        
        // store
        $this->getMainRepository()->store($agency);
    }
    
}

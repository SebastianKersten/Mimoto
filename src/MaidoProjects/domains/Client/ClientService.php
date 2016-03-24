<?php

// classpath
namespace MaidoProjects\Client;

// Momkai classes
use MaidoProjects\Client\Client;
use MaidoProjects\Client\ClientException;

// Mimoto classes
use Mimoto\library\services\MimotoService;


/**
 * ClientService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ClientService extends MimotoService
{
    
    /**
     * Constructor
     */
    public function __construct($ClientRepository)
    {
        // register
        $this->setMainRepository($ClientRepository);
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get client by ID
     */
    public function getClientById($nId)
    {
        // load
        try
        {
            $client = $this->getMainRepository()->get($nId);
        }
        catch(ClientException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $client;
    }
    
    /**
     * Get all clients
     */
    public function getAllClients()
    {
        // load
        $aClients = $this->getMainRepository()->find();
        
        // send
        return $aClients;
    }
    
    /**
     * Store client
     */
    public function storeClient($nId, $sName)
    {
        // load or create
        $client = (!is_nan($nId) && $nId > 0) ? $this->getMainRepository()->get($nId) : $this->getMainRepository()->create();
        
        // register
        $client->setName($sName);
        
        // store
        $this->getMainRepository()->store($client); // #todo - returns new client?
    }
    
}

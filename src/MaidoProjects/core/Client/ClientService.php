<?php

// classpath
namespace MaidoProjects\Client;

// Momkai classes
use MaidoProjects\Client\ClientException;


/**
 * ClientService
 *
 * @author Sebastian Kersten
 */
class ClientService
{
    
    // repositories
    private $_ClientRepository;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($ClientRepository)
    {
        // init
        $this->_ClientRepository = $ClientRepository;
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
            $client = $this->_ClientRepository->get($nId);
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
        $aClients = $this->_ClientRepository->find();
        
        // send
        return $aClients;
    }
    
    /**
     * Store client
     */
    public function storeClient($nId, $sName)
    {
        // store
        $this->_ClientRepository->store($nId, $sName);
    }
    
}

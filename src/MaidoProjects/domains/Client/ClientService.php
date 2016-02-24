<?php

// classpath
namespace MaidoProjects\Client;

// Momkai classes
use MaidoProjects\Client\ClientRepository;
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
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // init
        $this->_ClientRepository = new ClientRepository();
    }
    
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
     * Save client
     */
    public function saveClient($client)
    {
        // ?
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
    
}

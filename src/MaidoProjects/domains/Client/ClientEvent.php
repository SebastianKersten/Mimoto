<?php

// classpath
namespace MaidoProjects\Client;

// Momkai classes
use MaidoProjects\Client\Client;

// Mimoto classes
use Mimoto\Event\MimotoEvent;


class ClientEvent extends MimotoEvent
{   
    
    /**
     * Constructor
     * @param Client $client
     */
    public function __construct(Client $client, $sEvent)
    {
        // forward
        parent::__construct($client, $sEvent);
    }
    
    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->getEntity();
    }
    
}
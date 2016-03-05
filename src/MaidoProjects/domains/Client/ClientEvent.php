<?php

// classpath
namespace MaidoProjects\Client;

// Symfony classes
use Symfony\Component\EventDispatcher\Event;


class ClientEvent extends Event
{
    /**
     * xxx
     *
     * @var string
     */
    const CREATED = 'client.created';
    
    /**
     * xxx
     *
     * @var string
     */
    const UPDATED = 'client.updated';
    
    
    
    
    protected $client;
    
    
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }
    
}
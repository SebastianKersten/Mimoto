<?php

// classpath
namespace MaidoProjects\Agency;

// Symfony classes
use Symfony\Component\EventDispatcher\Event;


class AgencyEvent extends Event
{
    /**
     * xxx
     *
     * @var string
     */
    const CREATED = 'agency.created';
    
    /**
     * xxx
     *
     * @var string
     */
    const UPDATED = 'agency.updated';
    
    
    
    
    protected $agency;
    
    
    public function __construct(Agency $agency)
    {
        $this->agency = $agency;
    }
    
    /**
     * @return Agency
     */
    public function getAgency()
    {
        return $this->agency;
    }
    
}
<?php

// classpath
namespace MaidoProjects\Agency;

// Momkai classes
use MaidoProjects\Agency\Agency;

// Mimoto classes
use Mimoto\Event\MimotoEvent;


class AgencyEvent extends MimotoEvent
{   
    
    /**
     * Constructor
     * @param Agency $agency
     */
    public function __construct(Agency $agency, $sEvent)
    {
        // forward
        parent::__construct($agency, $sEvent);
    }
    
    /**
     * @return Agency
     */
    public function getAgency()
    {
        return $this->getEntity();
    }
    
}
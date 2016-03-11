<?php

// classpath
namespace MaidoProjects\SubprojectState;

// Momkai classes
use MaidoProjects\Subproject\SubprojectState;

// Mimoto classes
use Mimoto\Event\MimotoEvent;


class SubprojectStateEvent extends MimotoEvent
{   
    
    /**
     * Constructor
     * @param SubprojectState $subprojectState
     */
    public function __construct(SubprojectState $subprojectState, $sEvent)
    {
        // forward
        parent::__construct($subprojectState, $sEvent);
    }
    
    /**
     * @return SubprojectState
     */
    public function getSubprojectState()
    {
        return $this->getEntity();
    }
    
}
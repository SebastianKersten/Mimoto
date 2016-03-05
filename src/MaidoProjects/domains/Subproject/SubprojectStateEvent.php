<?php

// classpath
namespace MaidoProjects\Subproject;

// Symfony classes
use Symfony\Component\EventDispatcher\Event;


class SubprojectStateEvent extends Event
{
    /**
     * xxx
     *
     * @var string
     */
    const CREATED = 'subprojectstate.created';
    
    /**
     * xxx
     *
     * @var string
     */
    const UPDATED = 'subprojectstate.updated';
    
    
    
    
    protected $subprojectstate;
    
    
    public function __construct(SubprojectState $subprojectstate)
    {
        $this->subprojectstate = $subprojectstate;
    }
    
    /**
     * @return subprojectState
     */
    public function getSubprojectState()
    {
        return $this->subprojectstate;
    }
    
}
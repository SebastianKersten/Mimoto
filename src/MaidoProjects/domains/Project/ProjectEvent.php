<?php

// classpath
namespace MaidoProjects\Project;

// Momkai classes
use MaidoProjects\Project\Project;

// Mimoto classes
use Mimoto\Event\MimotoEvent;


class ProjectEvent extends MimotoEvent
{   
    
    /**
     * Constructor
     * @param Project $project
     */
    public function __construct(Project $project, $sEvent)
    {
        // forward
        parent::__construct($project, $sEvent);
    }
    
    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->getEntity();
    }
    
}
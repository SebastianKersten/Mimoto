<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Momkai classes
use MaidoProjects\ProjectManager\ProjectManager;

// Mimoto classes
use Mimoto\Event\MimotoEvent;


class ProjectManagerEvent extends MimotoEvent
{   
    
    /**
     * Constructor
     * @param ProjectManager $projectManager
     */
    public function __construct(ProjectManager $projectManager, $sEvent)
    {
        // forward
        parent::__construct($projectManager, $sEvent);
    }
    
    /**
     * @return ProjectManager
     */
    public function getProjectManager()
    {
        return $this->getEntity();
    }
    
}
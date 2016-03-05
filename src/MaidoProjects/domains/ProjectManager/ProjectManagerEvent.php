<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Symfony classes
use Symfony\Component\EventDispatcher\Event;


class ProjectManagerEvent extends Event
{
    /**
     * xxx
     *
     * @var string
     */
    const CREATED = 'projectmanager.created';
    
    /**
     * xxx
     *
     * @var string
     */
    const UPDATED = 'projectmanager.updated';
    
    
    
    
    protected $projectmanager;
    
    
    public function __construct(ProjectManager $projectmanager)
    {
        $this->projectmanager = $projectmanager;
    }
    
    /**
     * @return ProjectManager
     */
    public function getProjectManager()
    {
        return $this->projectmanager;
    }
    
}
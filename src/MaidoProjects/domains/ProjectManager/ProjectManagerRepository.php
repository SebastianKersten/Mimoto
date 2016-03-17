<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Momkai classes
use Mimoto\library\repositories\MimotoSingleMySQLTableRepository;


/**
 * ProjectManagerRepository
 *
 * @author Sebastian Kersten
 */
class ProjectManagerRepository extends MimotoSingleMySQLTableRepository
{      
    
    /**
     * Constructor
     */
    public function __construct($EventService)
    {
        
        // init parent
        parent::__construct($EventService);
        
        // setup
        $this->setModelClass('MaidoProjects\ProjectManager\ProjectManager');
        $this->setModelExceptionClass('MaidoProjects\ProjectManager\ProjectManagerException');
        $this->setModelEventClass('MaidoProjects\ProjectManager\ProjectManagerEvent');
        $this->setMySQLTable('projectmanagers');
        
        // connect
        $this->setProperty('name', 'name', '');
    }
    
}

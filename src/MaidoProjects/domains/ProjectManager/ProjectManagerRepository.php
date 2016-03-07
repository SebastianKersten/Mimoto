<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Momkai classes
use library\repositories\AbstractSingleMySQLTableRepository;


/**
 * ProjectManagerRepository
 *
 * @author Sebastian Kersten
 */
class ProjectManagerRepository extends AbstractSingleMySQLTableRepository
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
        $this->setModelToMySQLTableMap(
            [
                (object) array('property' => 'Id', 'column' => 'id', 'primary' => true),
                (object) array('property' => 'Name', 'column' => 'name')
            ]
        );
    }
    
}

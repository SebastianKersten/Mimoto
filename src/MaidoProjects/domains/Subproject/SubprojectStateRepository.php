<?php

// classpath
namespace MaidoProjects\Subproject;

// Momkai classes
use library\repositories\AbstractSingleMySQLTableRepository;


/**
 * SubprojectStateRepository
 *
 * @author Sebastian Kersten
 */
class SubprojectStateRepository extends AbstractSingleMySQLTableRepository
{      
    
    /**
     * Constructor
     */
    public function __construct($EventService)
    {
        
        // init parent
        parent::__construct($EventService);
        
        // setup
        $this->setModelClass('MaidoProjects\Subproject\SubprojectState');
        $this->setModelExceptionClass('MaidoProjects\Subproject\SubprojectStateException');
        $this->setModelEventClass('MaidoProjects\Subproject\SubprojectStateEvent');
        $this->setMySQLTable('subproject_states');
        
        // connect
        $this->setModelToMySQLTableMap(
            [
                (object) array('property' => 'Id', 'column' => 'id', 'primary' => true),
                (object) array('property' => 'Name', 'column' => 'name')
            ]
        );
    }
    
}

<?php

// classpath
namespace MaidoProjects\SubprojectState;

// Momkai classes
use Mimoto\library\repositories\MimotoSingleMySQLTableRepository;


/**
 * SubprojectStateRepository
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SubprojectStateRepository extends MimotoSingleMySQLTableRepository
{      
    
    /**
     * Constructor
     */
    public function __construct($EventService)
    {
        
        // init parent
        parent::__construct($EventService);
        
        // setup
        $this->setModelClass('MaidoProjects\SubprojectState\SubprojectState');
        $this->setModelExceptionClass('MaidoProjects\SubprojectState\SubprojectStateException');
        $this->setModelEventClass('MaidoProjects\SubprojectState\SubprojectStateEvent');
        $this->setMySQLTable('subproject_states');
        
        // connect
        $this->setValueAsProperty('name', 'name');
    }
    
}

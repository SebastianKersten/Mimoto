<?php

// classpath
namespace MaidoProjects\Agency;

// Momkai classes
use Mimoto\library\repositories\MimotoSingleMySQLTableRepository;


/**
 * AgencyRepository
 *
 * @author Sebastian Kersten
 */
class AgencyRepository extends MimotoSingleMySQLTableRepository
{      
    
    /**
     * Constructor
     */
    public function __construct($EventService)
    {
        
        // init parent
        parent::__construct($EventService);
        
        // setup
        $this->setModelClass('MaidoProjects\Agency\Agency');
        $this->setModelExceptionClass('MaidoProjects\Agency\AgencyException');
        $this->setModelEventClass('MaidoProjects\Agency\AgencyEvent');
        $this->setMySQLTable('agencies');
        
        // connect
        $this->setValueAsProperty('name', 'name');
    }
    
}

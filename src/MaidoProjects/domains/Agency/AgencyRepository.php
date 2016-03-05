<?php

// classpath
namespace MaidoProjects\Agency;

// Momkai classes
use library\repositories\AbstractSingleMySQLTableRepository;


/**
 * AgencyRepository
 *
 * @author Sebastian Kersten
 */
class AgencyRepository extends AbstractSingleMySQLTableRepository
{      
    
    /**
     * Constructor
     */
    public function __construct($EventService)
    {
        
        // register
        $this->setEventService($EventService);
        
        // setup
        $this->setModelClass('MaidoProjects\Agency\Agency');
        $this->setModelExceptionClass('MaidoProjects\Agency\AgencyException');
        $this->setModelEventClass('MaidoProjects\Agency\AgencyEvent');
        $this->setMySQLTable('agencies');
        
        // connect
        $this->setModelToMySQLTableMap(
            [
                (object) array('property' => 'Id', 'column' => 'id', 'primary' => true),
                (object) array('property' => 'Name', 'column' => 'name')
            ]
        );
    }
    
}

<?php

// classpath
namespace MaidoProjects\Client;

// Momkai classes
use library\repositories\AbstractSingleMySQLTableRepository;


/**
 * ClientRepository
 *
 * @author Sebastian Kersten
 */
class ClientRepository extends AbstractSingleMySQLTableRepository
{      
    
    /**
     * Constructor
     */
    public function __construct($EventService)
    {
        
        // init parent
        parent::__construct($EventService);
        
        // setup
        $this->setModelClass('MaidoProjects\Client\Client');
        $this->setModelExceptionClass('MaidoProjects\Client\ClientException');
        $this->setModelEventClass('MaidoProjects\Client\ClientEvent');
        $this->setMySQLTable('clients');
        
        // connect
        $this->setModelToMySQLTableMap(
            [
                (object) array('property' => 'Id', 'column' => 'id', 'primary' => true),
                (object) array('property' => 'Name', 'column' => 'name')
            ]
        );
    }
    
}

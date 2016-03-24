<?php

// classpath
namespace MaidoProjects\Client;

// Momkai classes
use Mimoto\library\repositories\MimotoSingleMySQLTableRepository;


/**
 * ClientRepository
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ClientRepository extends MimotoSingleMySQLTableRepository
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
        $this->setValueAsProperty('name', 'name');
    }
    
}

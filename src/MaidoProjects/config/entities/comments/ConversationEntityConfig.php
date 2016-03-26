<?php

// classpath
namespace MaidoProjects\Config\entities;

// Mimoto classes
use Mimoto\Config\MimotoEntityConfig;

/**
 * ConversationEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ConversationEntityConfig extends MimotoEntityConfig
{
    
    public function __construct()
    {
        // init
        $this->setName('conversation');
        
        // setup structure
        $this->setValueAsProperty('name');
        
        // data source
        $this->setMySQLTable('conversations');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
    }
    
}

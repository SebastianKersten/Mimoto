<?php

// classpath
namespace MaidoProjects\config\entities;

// Mimoto classes
use Mimoto\Config\MimotoEntityConfig;

/**
 * ClientEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ClientEntityConfig extends MimotoEntityConfig
{
    
    public function __construct()
    {
        // setup structure
        $this->setValueAsProperty('name');
        
        // data source
        $this->setMySQLTable('clients');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
    }
    
}

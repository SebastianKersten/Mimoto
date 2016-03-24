<?php

// classpath
namespace MaidoProjects\config\entities;

// Mimoto classes
use Mimoto\Config\MimotoEntityConfig;

/**
 * SubprojectStateEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SubprojectStateEntityConfig extends MimotoEntityConfig
{
    
    public function __construct()
    {
        // setup structure
        $this->setValueAsProperty('name');
        
        // data source
        $this->setMySQLTable('supproject_states');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
    }
    
}

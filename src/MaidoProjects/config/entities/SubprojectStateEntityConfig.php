<?php

// classpath
namespace MaidoProjects\Config\entities;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityConfig;

/**
 * SubprojectStateEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SubprojectStateEntityConfig extends MimotoEntityConfig
{
    
    public function __construct()
    {
        // init
        $this->setName('subprojectState');
        
        // setup structure
        $this->setValueAsProperty('name');
        
        // data source
        $this->setMySQLTable('subproject_states');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
    }
    
}

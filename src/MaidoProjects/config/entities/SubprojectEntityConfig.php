<?php

// classpath
namespace MaidoProjects\Config\entities;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityConfig;

/**
 * ClientEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SubprojectEntityConfig extends MimotoEntityConfig
{
    
    public function __construct()
    {
        // init
        $this->setName('subproject');
        
        // setup structure
        $this->setValueAsProperty('name');
        
        // data source
        $this->setMySQLTable('subprojects');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
    }
    
}

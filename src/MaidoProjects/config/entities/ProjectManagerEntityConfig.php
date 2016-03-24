<?php

// classpath
namespace MaidoProjects\config\entities;

// Mimoto classes
use Mimoto\Config\MimotoEntityConfig;

/**
 * ProjectManagerEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ProjectManagerEntityConfig extends MimotoEntityConfig
{
    
    public function __construct()
    {
        // setup structure
        $this->setValueAsProperty('name');
        
        // data source
        $this->setMySQLTable('projectmanagers');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
    }
    
}

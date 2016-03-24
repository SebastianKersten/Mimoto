<?php

// classpath
namespace MaidoProjects\config\entities;

// Mimoto classes
use Mimoto\Config\MimotoEntityConfig;

/**
 * AgencyEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class AgencyEntityConfig extends MimotoEntityConfig
{
    
    public function __construct()
    {
        // setup structure
        $this->setValueAsProperty('name');
        
        // data source
        $this->setMySQLTable('agencies');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
    }
    
}

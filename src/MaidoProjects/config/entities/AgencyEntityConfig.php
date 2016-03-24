<?php

// classpath
namespace MaidoProjects\Config\entities;

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
        // init
        $this->setName('agency');
        
        // setup structure
        $this->setValueAsProperty('name');
        
        // data source
        $this->setMySQLTable('agencies');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
    }
    
}

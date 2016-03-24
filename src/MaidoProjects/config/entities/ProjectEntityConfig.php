<?php

// classpath
namespace MaidoProjects\Config\entities;

// Mimoto classes
use Mimoto\Config\MimotoEntityConfig;

/**
 * ClientEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ProjectEntityConfig extends MimotoEntityConfig
{
    
    public function __construct()
    {
        // init
        $this->setName('project');
        
        
        // data source
        $this->setMySQLTable('projects');
        
        // setup structure
        $this->setValueAsProperty('name');
        $this->setValueAsProperty('description');
        $this->setEntityAsProperty('client', 'client');
        $this->setEntityAsProperty('agency', 'agency');
        $this->setEntityAsProperty('projectManager', 'projectManager');
        //$this->setCollectionAsProperty('subprojects', 'subproject');
        $this->setValueAsProperty('options.mailUpdates');
        $this->setValueAsProperty('options.sendLiveNotification');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
        $this->connectPropertyToMySQLColumn('description', 'description');
        $this->connectPropertyToDummyValue('client', 69);
        $this->connectPropertyToDummyValue('agency', 69);
        $this->connectPropertyToDummyValue('projectManager', 69);
        $this->connectPropertyToDefaultValue('options.mailUpdates', false);
        $this->connectPropertyToDefaultValue('options.sendLiveNotification', true);
        
    }
    
}

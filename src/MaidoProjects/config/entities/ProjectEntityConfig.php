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
        $this->connectPropertyToMySQLColumn('client', 'client_id');
        $this->connectPropertyToMySQLColumn('agency', 'agency_id');
        $this->connectPropertyToMySQLColumn('projectManager', 'projectmanager_id');
        //$this->connectPropertyToMySQLConnectionTable('subprojects', 'projectmanager_id');
        $this->connectPropertyToDummyValue('options.mailUpdates', 'false');
        $this->connectPropertyToDummyValue('options.sendLiveNotification', 'true');
        
    }
    
}

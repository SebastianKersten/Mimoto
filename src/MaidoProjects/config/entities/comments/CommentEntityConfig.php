<?php

// classpath
namespace MaidoProjects\Config\entities;

// Mimoto classes
use Mimoto\Config\MimotoEntityConfig;

/**
 * CommentEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CommentEntityConfig extends MimotoEntityConfig
{
    
    public function __construct()
    {
        // init
        $this->setName('comment');
        
        // setup structure
        $this->setValueAsProperty('name');
        
        // data source
        $this->setMySQLTable('comments');
        
        // connect entity to data source
        $this->connectPropertyToMySQLColumn('name', 'name');
    }
    
}

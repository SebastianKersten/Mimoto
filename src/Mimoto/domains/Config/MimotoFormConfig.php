<?php

// classpath
namespace Mimoto\Config;

/**
 * MimotoEntityConfig
 *
 * @author apple
 */
class MimotoEntityConfig
{
    
    public function __construct()
    {
        
        // init
        $project = new MimotoData(false);
        //MimotoEntityService->getEntity('project', $nId = 0);

        // setup structure
        $project->setValueAsProperty('name');
        $project->setValueAsProperty('description');
        $project->setEntityAsProperty('client', 'client'); // type, id
        $project->setEntityAsProperty('agency', 'agency');
        $project->setEntityAsProperty('projectManager', 'projectManager');
        $project->setCollectionAsProperty('subprojects', 'subproject');
        $project->setValueAsProperty('options.mailUpdates');
        $project->setValueAsProperty('options.sendLiveNotification');

        // set data
        $project->setValue('name', $sProjectName);
        $project->setValue('description', $sProjectDescription);
        $project->setValue('client', $nClientId); // zet id, maar pas op get wordt de echte entity (wat een data is) opgehaald
        $project->setValue('agency', $nAgencyId);
        $project->setValue('projectManager', $nProjectManagerId);
        $project->setValue('subprojects', $aSubprojects);
        $project->setValue('options.mailUpdates', true);
        $project->setValue('options.sendLiveNotification', false);
    }
    
    
    
    
}

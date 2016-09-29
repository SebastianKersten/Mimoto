<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Silex\Application;


/**
 * FormsController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormsController
{
    
    public function getOverview(Application $app)
    {   
        // load
        $aEntityConfigs = $app['Mimoto.EntityConfigService']->getAllEntityConfigs();
        
        return $app['twig']->render(
            'Mimoto.CMS/components/base.twig',
            array(
                'section' => 'forms',
                'pagetemplate' => 'Mimoto.CMS/pages/forms/Overview.twig',
                'aEntityConfigs' => $aEntityConfigs
            )
        );
    }
    
}

<?php

// classpath
namespace Mimoto\UserInterface;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


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
            'Mimoto.CMS/base.twig',
            array(
                'section' => 'forms',
                'pagetemplate' => 'Mimoto.CMS/pages/forms/Overview.twig',
                'aEntityConfigs' => $aEntityConfigs
            )
        );
    }
    
}

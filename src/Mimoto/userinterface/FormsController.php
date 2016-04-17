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
            'Mimoto.CMS/root.twig',
            array(
                'section' => 'Forms',
                'pagetemplate' => 'Mimoto.CMS/pages/Forms/Overview.twig',
                'aEntityConfigs' => $aEntityConfigs
            )
        );
    }
    
}

<?php

// classpath
namespace Mimoto\UserInterface;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * ContentController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ContentController
{
    
    public function getOverview(Application $app)
    {   
        // load
        $aEntityConfigs = $app['Mimoto.EntityConfigService']->getAllEntityConfigs();
        
        return $app['twig']->render(
            'Mimoto.CMS/base.twig',
            array(
                'section' => 'content',
                'pagetemplate' => 'Mimoto.CMS/pages/content/Overview.twig',
                'aEntityConfigs' => $aEntityConfigs
            )
        );
    }
    
}

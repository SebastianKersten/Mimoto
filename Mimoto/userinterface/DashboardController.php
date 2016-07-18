<?php

// classpath
namespace Mimoto\UserInterface;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * DashboardController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DashboardController
{
    
    public function getDashboard(Application $app)
    {

        $page = $app['Mimoto.Aimless']->createComponent('MimotoCMS_EntityItemItem', $entity);

        $page->render();



        return $app['twig']->render(
            'Mimoto.CMS/root.twig',
            array(
                'section' => 'Dashboard',
                'pagetemplate' => 'Mimoto.CMS/pages/Dashboard/Dashboard.twig'
            )
        );
    }
    
}

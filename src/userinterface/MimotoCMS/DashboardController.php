<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Silex\Application;


/**
 * DashboardController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DashboardController
{
    
    public function viewDashboard(Application $app)
    {
        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_dashboard_Overview');

        // output
        return $page->render();
    }
    
}

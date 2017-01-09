<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\UserInterface\MimotoCMS\utils\InterfaceUtils;

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

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // output
        return $page->render();
    }
    
}

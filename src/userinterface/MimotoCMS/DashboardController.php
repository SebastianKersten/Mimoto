<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\core\CoreConfig;

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
        // 1. init page
        $page = $app['Mimoto.Aimless']->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create content
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_dashboard_Overview');

        // 3. connect
        $page->addComponent('content', $component);

        // 4. output
        return $page->render();
    }
    
}

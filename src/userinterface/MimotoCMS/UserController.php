<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\UserInterface\MimotoCMS\utils\InterfaceUtils;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;


/**
 * UserController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class UserController
{
    
    public function viewUserOverview(Application $app)
    {
        // create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_users_UserOverview');

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Users',
                    "url" => '/mimoto.cms/users'
                )
            )
        );

        // output
        return $page->render();
    }
    
}

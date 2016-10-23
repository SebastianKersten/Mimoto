<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
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
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_users_UserOverview');

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

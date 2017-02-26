<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
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
        // 1. init page
        $page = Mimoto::service('aimless')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('aimless')->createComponent('Mimoto.CMS_users_UserOverview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Users',
                    "url" => '/mimoto.cms/users'
                )
            )
        );

        // 4. output
        return $page->render();
    }
    
}

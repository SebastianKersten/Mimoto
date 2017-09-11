<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

// Silex classes
use Silex\Application;


/**
 * UserRolesController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class UserRolesController
{

    /**
     * View user role overview
     * @return string The rendered html output
     */
    public function overview()
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_configuration_userroles_Overview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Configuration',
                    "url" => '/mimoto.cms/configuration'
                ),
                (object) array(
                    "label" => 'User roles',
                    "url" => '/mimoto.cms/configuration/userroles'
                )
            )
        );

        // 4. output
        return $page->render();
    }

    /**
     * View user role
     * @return string The rendered html output
     */
    public function userRoleView(Application $app, $nItemId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eUserRole = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER_ROLE, $nItemId);

        // 3. validate data
        if (empty($eUserRole)) return $app->redirect("/mimoto.cms/configuration/userroles");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_configuration_userroles_Detail', $eUserRole);

        // 5. connect
        $page->addComponent('content', $component);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Configuration',
                    "url" => '/mimoto.cms/configuration'
                ),
                (object) array(
                    "label" => 'User roles',
                    "url" => '/mimoto.cms/configuration/userroles'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_USER_ROLE.'.'.$eUserRole->getId().'.name">'.$eUserRole->getValue('name').'</span>',
                    "url" => '/mimoto.cms/configuration/userrole/'.$eUserRole->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

}

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
     * View new user role form
     * @return string The rendered html output
     */
    public function userRoleNew()
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create form layout
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup form
        $component->addForm(
            CoreConfig::COREFORM_USER_ROLE,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ROOT.'.'.CoreConfig::MIMOTO_ROOT.'.userRoles',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect content
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
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

    public function userRoleEdit(Application $app, $nItemId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load
        $eUserRole = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER_ROLE, $nItemId);

        // 3. validate
        if (empty($eUserRole)) return $app->redirect("/mimoto.cms/configuration/userroles");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 5. setup
        $component->addForm(
            CoreConfig::COREFORM_USER_ROLE,
            $eUserRole,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $popup->render();
    }

    public function userRoleDelete(Application $app, $nItemId)
    {
        // 1. load
        $eUserRole = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER_ROLE, $nItemId);

        // 2. delete
        Mimoto::service('data')->delete($eUserRole);

        // 3. output
        return Mimoto::service('messages')->response((object) array('result' => 'User role deleted! '.date("Y.m.d H:i:s")), 200);
    }

}

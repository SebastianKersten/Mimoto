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
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_users_Overview', $eRoot));

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

    /**
     * View new user form
     * @return string The rendered html output
     */
    public function userNew()
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create form layout
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup form
        $component->addForm(
            CoreConfig::COREFORM_USER,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ROOT.'.'.CoreConfig::MIMOTO_ROOT.'.users',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect content
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
    }

    /**
     * View user detail
     * @return string The rendered html output
     */
    public function userView(Application $app, $nUserId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eUser = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER, $nUserId);

        // 3. validate data
        if (empty($eUser)) return $app->redirect("/mimoto.cms/users");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_users_Detail', $eUser);

        // 5. connect
        $page->addComponent('content', $component);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Users',
                    "url" => '/mimoto.cms/users'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_USER.'.'.$eUser->getId().'.name">'.$eUser->getValue('name').'</span>',
                    "url" => '/mimoto.cms/user/'.$eUser->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

    public function userEdit(Application $app, $nUserId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load
        $eUser = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER, $nUserId);

        // 3. validate
        if (empty($eUser)) return $app->redirect("/mimoto.cms/users");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 5. setup
        $component->addForm(
            CoreConfig::COREFORM_USER,
            $eUser,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $popup->render();
    }

    public function editCurrentUser(Application $app)
    {
        // 1. init popup
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load
        $eUser = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER, $app['session']->get('user')->id);

        // temp - update session info to latest info
        $app['session']->get('user')->name = $eUser->getValue('name');
        $app['session']->get('user')->avatar = '/'.$eUser->getValue('avatar.path').$eUser->getValue('avatar.name');

        // 3. validate
        if (empty($eUser)) return $app->redirect("/mimoto.cms");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 5. setup
        $component->addForm(
            CoreConfig::COREFORM_USER,
            $eUser,
            [
                'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/account']]
            ]
        );

        // 6. connect
        $page->addComponent('content', $component);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Users',
                    "url" => '/mimoto.cms/users'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_USER.'.'.$eUser->getId().'.name">'.$eUser->getValue('name').'</span>',
                    "url" => '/mimoto.cms/user/'.$eUser->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

    public function userDelete(Application $app, $nUserId)
    {
        // 1. load
        $eUser = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER, $nUserId);

        // 2. delete
        Mimoto::service('data')->delete($eUser);

        // 3. output
        return Mimoto::service('messages')->response((object) array('result' => 'User deleted! '.date("Y.m.d H:i:s")), 200);
    }
    
}

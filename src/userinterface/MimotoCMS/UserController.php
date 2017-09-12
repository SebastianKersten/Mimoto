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

        // 4. load
        $eForm = Mimoto::service('input')->getFormByName(CoreConfig::MIMOTO_USER);

        // 5. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form', $eForm);

        // 6. setup
        $component->addForm(
            CoreConfig::MIMOTO_USER,
            $eUser,
            [
//                'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/account']]
            ]
        );

        // 7. connect
        $page->addComponent('content', $component);

        // 8. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Account',
                    "url" => '/mimoto.cms/account'
                )
            )
        );

        // 9. output
        return $page->render();
    }

    public function editUser(Application $app, $nUserId)
    {
        // 1. init popup
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load
        $eUser = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER, $nUserId);

        // 3. validate
        if (empty($eUser)) return $app->redirect("/mimoto.cms/users");

        // 4. load
        $eForm = Mimoto::service('input')->getFormByName(CoreConfig::MIMOTO_USER);

        // 5. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form', $eForm);

        // 6. setup
        $component->addForm(
            CoreConfig::MIMOTO_USER,
            $eUser,
            [
                //'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/account']]
            ]
        );

        // 7. connect
        $page->addComponent('content', $component);

        // 8. setup page
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

        // 9. output
        return $page->render();
    }

}

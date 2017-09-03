<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\core\CoreConfig;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * DashboardController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DashboardController
{
    
    public function viewDashboard(Request $request, Application $app)
    {
        if (!$app['session']->get('is_user'))
        {
            // --- temp setup to guide first time user to users page

            // find
            $aUsers = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_USER]);

            // validate
            if (count($aUsers) == 0)
            {
                Mimoto::output('Install Mimoto', '
                    <ol>
                        <li>Make a copy of `config.php.bak` and name it `config.php`</li>
                        <li>Add your MySQL credentials to your `config.php`</li>
                        <li>Import the database dump in `/database` in your MySQL</li>
                        <li>Add at least 1 user to the `_Mimoto_user` table:<br>
<br>
INSERT INTO `_Mimoto_user`(`id`, `name`, `email`, `password`, `created`) VALUES (1, \'Your full name\', \'your@email.com\', \'your_password\', NULL);<br>
and<br>
INSERT INTO `_Mimoto_connection`(`parent_entity_type_id`, `parent_id`, `parent_property_id`, `child_entity_type_id`, `child_id`, `sortindex`) VALUES (\'_Mimoto_user\', \'1\', \'_Mimoto_user--roles\', \'_Mimoto_user_role\', \'_Mimoto_user_role-owner\', 0);
                        </li>
                    </ol>
                ');
                die();

                // 1. init page
                //$page = Mimoto::service('output')->create('MimotoCMS_layout_Setup');

                //
                //return $app->redirect('/mimoto.cms/setup');
            }
            else
            {
                // 1. init page
                $page = Mimoto::service('output')->create('MimotoCMS_layout_Login');

                // 2. setup
                $page->setVar('requestedPage', $request->get('request'));
            }
        }
        else
        {
            // validate user permissions
            if (!(Mimoto::user()->hasRole('owner') || Mimoto::user()->hasRole('superuser') || Mimoto::user()->hasRole('admin') || Mimoto::user()->hasRole('contenteditor')))
            {
                // logout
                return $app->redirect('/mimoto.cms/logout');
            }


            // ---


            // 1. init page
            $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

            // 2. create content
            $component = Mimoto::service('output')->createComponent('MimotoCMS_dashboard_Overview');

            // 3. connect
            $page->addComponent('content', $component);
        }

        // 4. output
        return $page->render();
    }
    
}

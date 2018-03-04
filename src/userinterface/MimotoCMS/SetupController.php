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
 * SetupController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SetupController
{
    
    public function welcome(Request $request, Application $app)
    {

        //Mimoto::service('database')->



        // 1. ask for mysql info
        // 2. ask for project name?
        // 3. create tables
        // 4. check tables (get all _Mimoto tables, check names, check columns, check types)
        // 5. create root user (owner?)



        if (!$app['session']->get('is_user'))
        {
            // --- temp setup to guide first time user to users page

            // find
            $aUsers = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_USER]);

            // validate
            if (count($aUsers) == 0)
            {
                Mimoto::output('Install Mimoto', '
                    <ol>
                        <li>Make a copy of `mimoto.json.dist` and name it `mimoto.json`</li>
                        <li>Add your MySQL credentials to your `mimoto.json`</li>
                        <li>Import the database dump in `/database` in your MySQL</li> 
                    </ol>
                ');
                die();
            }


            // --- end of temp setup

            // 1. init page
            $page = Mimoto::service('output')->createPage('MimotoCMS_layout_Login');

            // 2. setup
            $page->setVar('requestedPage', $request->get('request'));
        }
        else
        {
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


    // --- database sanity


    public function addCoreTable(Application $app, Request $request, $sTableName)
    {
        // 1. validate
        if (!Mimoto::user()->hasRole('owner') && !Mimoto::user()->hasRole('superuser')) return '';

        // 2. validate
        if (substr($sTableName, 0, strlen(CoreConfig::CORE_PREFIX)) != CoreConfig::CORE_PREFIX) return '';

        // 3. validate
        if (!in_array($sTableName, Mimoto::service('setup')->getCoreTables())) return '';

        // 4. create
        if (Mimoto::service('setup')->addCoreTable($sTableName))
        {
            // report success
            return Mimoto::service('messages')->response((object) array('result' => 'Table `'.$sTableName.'` added! '.date("Y.m.d H:i:s")), 200);
        }
        else
        {
            // report error
            return Mimoto::service('messages')->response((object) array('result' => 'Coudn`t create table `'.$sTableName.'` '.date("Y.m.d H:i:s")), 400);
        }
    }

    public function fixCoreTable(Application $app, Request $request, $sTableName)
    {
        // 1. validate
        if (!Mimoto::user()->hasRole('owner') && !Mimoto::user()->hasRole('superuser')) return '';

        // 2. validate
        if (substr($sTableName, 0, strlen(CoreConfig::CORE_PREFIX)) != CoreConfig::CORE_PREFIX) return '';

        // 3. validate
        if (!in_array($sTableName, Mimoto::service('setup')->getCoreTables())) return '';

        // 4. fix
        if (($result = Mimoto::service('setup')->fixCoreTable($sTableName)) === true)
        {
            // report success
            return Mimoto::service('messages')->response((object) array('result' => 'Table `'.$sTableName.'` fixed! '.date("Y.m.d H:i:s")), 200);
        }
        else
        {
            // report error
            return Mimoto::service('messages')->response((object) array('result' => 'Coudn`t fix table `'.$sTableName.'`: '.$result.' '.date("Y.m.d H:i:s")), 400);
        }
    }

    public function removeCoreTable(Application $app, Request $request, $sTableName)
    {
        // 1. validate
        if (!Mimoto::user()->hasRole('owner') && !Mimoto::user()->hasRole('superuser')) return '';

        // 2. validate
        if (substr($sTableName, 0, strlen(CoreConfig::CORE_PREFIX)) != CoreConfig::CORE_PREFIX) return '';

        // 3. validate
        if (in_array($sTableName, Mimoto::service('setup')->getCoreTables())) return '';

        // 4. remove
        if (Mimoto::service('setup')->removeCoreTable($sTableName))
        {
            // report success
            return Mimoto::service('messages')->response((object) array('result' => 'Table `'.$sTableName.'` removed! '.date("Y.m.d H:i:s")), 200);
        }
        else
        {
            // report error
            return Mimoto::service('messages')->response((object) array('result' => 'Coudn`t remove table `'.$sTableName.'` '.date("Y.m.d H:i:s")), 400);
        }
    }
    
}

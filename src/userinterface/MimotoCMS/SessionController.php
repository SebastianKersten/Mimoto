<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


use ElephantIO\Exception\ServerConnectionFailureException;


/**
 * SessionController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SessionController
{

    /**
     * Verify if user is allowed to enter the admin
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public static function validateCMSUser(Request $request, Application $app) // #research - not sure why this needs to be static
    {
        // validate
        if (!$app['session']->get('is_user'))
        {
            // compose
            $sRequestedPage = (!empty($request->get('request'))) ? $request->get('request') : $request->getRequestUri();
            if (!empty($sRequestedPage)) $sRequestedPage = '?request='.$sRequestedPage;

            // open login screen
            return $app->redirect('/mimoto.cms' . $sRequestedPage);
        }
    }


    public function login(Request $request, Application $app)
    {
        // register
        $sUsername = $request->get('username');
        $sPassword = $request->get('password');
        $sRequestedPage = $request->get('request');


        // 1. this need permission control and roles
        // 2. https://silex.sensiolabs.org/doc/2.0/providers/security.html


        // 1. find based on username (email)
        // 2. check password
        // 3. get avatar and name

        // find
        $aUsers = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_USER, 'value' => ['email' => $sUsername]]);

        // validate
        if (count($aUsers) == 1)
        {
            // register
            $eUser = $aUsers[0];

            // validate
            if ($sUsername == $eUser->getValue('email') && $sPassword == $eUser->getValue('password'))
            {
                // compose
                $user = (object) array(
                    'id' => $eUser->getId(),
                    'name' => $eUser->getValue('name'),
                    'avatar' => '/'.$eUser->getValue('avatar.path').$eUser->getValue('avatar.name'),
                );

                // register
                $app['session']->set('is_user', true);
                $app['session']->set('user', $user);

                // determine
                $sNextPage = (!empty($sRequestedPage)) ? $sRequestedPage : '/mimoto.cms';

                // open
                return $app->redirect($sNextPage);
            }
        }


        // 1. init page
        $page = Mimoto::service('output')->createPage('MimotoCMS_layout_Login');

        // 2. setup
        $page->setVar('requestedPage', $sRequestedPage);
        $page->setVar('username', $sUsername);

        // 3. output
        return $page->render();
    }

    public function logout(Application $app)
    {
        // clear
        $app['session']->clear();

        // redirect
        return $app->redirect('/mimoto.cms');
    }

    public function logon(Request $request, Application $app)
    {
        // 1. for realtime editing

        $sSocketId = $request->get('id');


        $user = $app['session']->get('user');


        $client = new \ElephantIO\Client(new \ElephantIO\Engine\SocketIO\Version1X('http://localhost:4001'));


        try
        {
            $client->initialize();
            $client->emit('logon', ['user' => $user, 'socketId' => $sSocketId]);
            $client->close();
        }
        catch (ServerConnectionFailureException $e)
        {
            echo 'Server Connection Failure!!';
        }

        return Mimoto::service('messages')->response(true, 200);

    }

    public function recent(Application $app, $sPropertySelector)
    {

        // 1. split
        $aPropertyElements = explode('.', $sPropertySelector);

        // 2. load
        $eEntity = Mimoto::service('data')->get($aPropertyElements[0], $aPropertyElements[1]);

        // 3. read and send
        return $eEntity->getValue($aPropertyElements[2]);

    }

}

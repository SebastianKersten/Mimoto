<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Core\FormattingUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\EntityConfig;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

// ElephantIO classes
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version1X;
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

    /**
     * Initialize realtime session
     * @param Application $app
     * @return mixed
     */
    public function initialize(Application $app)
    {
        // compose
        $response = (object) array
        (
            'gateway' => Mimoto::value('config')->socketio->clientgateway
        );

        // only for logged in users
        if ($app['session']->get('is_user'))
        {
            // read and register
            $response->formattingOptions = FormattingUtils::getCustomFormattingOptions(); // #todo -> cache this!
        }

        // send
        return Mimoto::service('messages')->response($response, 200);
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

        // do nothing is user not logged in
        if (!$app['session']->get('is_user')) return '';


        // setup socket connection
        $client = new Client(new Version1X(Mimoto::value('config')->socketio->workergateway));

        try
        {
            // read
            $sSocketId = $request->get('id');
            $user = $app['session']->get('user');

            // broadcast approval
            $client->initialize();
            $client->emit('logon', ['user' => $user, 'socketId' => $sSocketId]);
            $client->close();
        }
        catch (ServerConnectionFailureException $e)
        {
            echo 'Server Connection Failure!!';
        }

        // send
        return Mimoto::service('messages')->response(true, 200);

    }

    public function recent(Application $app, $sPropertySelector)
    {
        // 1. split
        $aPropertyElements = explode('.', $sPropertySelector);

        // 2. load
        $eItem = Mimoto::service('data')->get($aPropertyElements[0], $aPropertyElements[1]);

        // 3. validate
        if (empty($eItem)) return '';



        // 2. get entity property
        // 3. get entity property setting
        // 4. check formatting


        // init
        $formattingOptions = array();


        // load
        $eEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, Mimoto::service('config')->getEntityIdByName($aPropertyElements[0]));

        // read
        $aProperties = $eEntity->getValue('properties');

        // search
        $nPropertyCount = count($aProperties);
        for ($nPropertyIndex = 0; $nPropertyIndex < $nPropertyCount; $nPropertyIndex++)
        {
            // register
            $eProperty = $aProperties[$nPropertyIndex];

            // verify
            if ($eProperty->getValue('name') == $aPropertyElements[2] && $eProperty->getValue('type') == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
            {
                // read
                $aSettings = $eProperty->getValue('settings');

                // search
                $nSettingCount = count($aSettings);
                for ($nSettingIndex = 0; $nSettingIndex < $nSettingCount; $nSettingIndex++)
                {
                    // register
                    $setting = $aSettings[$nSettingIndex];

                    // verify
                    if ($setting->getValue('key') == EntityConfig::SETTING_VALUE_FORMATTINGOPTIONS)
                    {
                        // read
                        $aRegisteredFormattingOptions = $setting->getValue('formattingOptions');

                        // compose
                        $nFormattingOptionCount = count($aRegisteredFormattingOptions);
                        for ($nFormattingOptionIndex = 0; $nFormattingOptionIndex < $nFormattingOptionCount; $nFormattingOptionIndex++)
                        {
                            // register
                            $registeredFormattingOption = $aRegisteredFormattingOptions[$nFormattingOptionIndex];

                            // compose
                            $formattingOptions[] = $registeredFormattingOption->getValue('name');
                        }

                        break;
                    }
                }
            }
        }

        // compose
        $response = (object) array(
            'formattingOptions' => $formattingOptions,
            'content' => $eItem->getValue($aPropertyElements[2])
        );

        // 3. read and send
        return new JsonResponse($response);

    }

}

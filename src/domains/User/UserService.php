<?php

// classpath
namespace Mimoto\User;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;


/**
 * UserService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class UserService
{

    private $_app = null;
    private $_user = null;



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct(Application $app)
    {
        // 1. store
        $this->_app = $app;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------



    public function login($sUsername, $sPassword)
    {
        // 1. load
        $aUsers = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_USER], true);

        // 2. find
        $nUserCount = count($aUsers);
        for ($nUserIndex = 0; $nUserIndex < $nUserCount; $nUserIndex++)
        {
            // a. register
            $eUser = $aUsers[$nUserIndex];

            $sEmail = trim(strtolower($eUser->get('email')));

            //Mimoto::output($sEmail, trim(strtolower($sUsername)));
            // b. compare
            if (!empty($sEmail) && $sEmail == trim(strtolower($sUsername)))
            {
                // I. read
                $encryptedPassword = $eUser->get('password');

                // II. compare
                if (Mimoto::service('session')->comparePassword($sPassword, $encryptedPassword))
                {
                    // 1. compose
                    $user = (object) array(
                        'id' => $eUser->getId(),
                        'firstName' => $eUser->get('firstName'),
                        'lastName' => $eUser->get('lastName'),
                        'avatar' => '/'.$eUser->get('avatar.path').$eUser->get('avatar.name'),
                    );

                    // 2. register
                    Mimoto::getSilexApp()['session']->set('is_user', true);
                    Mimoto::getSilexApp()['session']->set('user', $user);
                    //Mimoto::error('login TRUE');
                    // 3. login successful
                    return true;
                }
            }
        }
        //Mimoto::error('login FALSE');
        // 3. couldn't login
        return false;
    }

    public function logout()
    {
        // 1. clear
        Mimoto::getSilexApp()['session']->clear();
    }

    public function getUserByUsername($sUsername)
    {
        // 1. load
        $aUsers = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_USER], true);

        // 2. find
        $nUserCount = count($aUsers);
        for ($nUserIndex = 0; $nUserIndex < $nUserCount; $nUserIndex++)
        {
            // a. register
            $eUser = $aUsers[$nUserIndex];

            $sEmail = trim(strtolower($eUser->get('email')));

            // b. compare
            if (!empty($sEmail) && $sEmail == trim(strtolower($sUsername)))
            {
                return $eUser;
            }
        }

        // 3. couldn't login
        return false;
    }



    public function isLoggedIn()
    {
        return (!empty($this->_app) && !empty($this->_app['session']) && $this->_app['session']->get('is_user'));
    }


    /**
     * Notify developer
     */
    public function getUserId()
    {
        // send
        return (!empty(Mimoto::service('session')->currentUser())) ? Mimoto::service('session')->currentUser()->getId() : null;
        //return Mimoto::service('session')->currentUser()->getId();
    }

    /**
     * Notify developer
     */
    public function getUserPublicKey($sExtraSaltyHashThing)
    {
        // example
        $sUserId = $this->getUserId();
        $sPublicKey = md5($sExtraSaltyHashThing.md5($sUserId.'#salthashything')); // #todo get from config file

        // send
        return $sPublicKey;
    }

    public function createUser($sUserName, $sPassword)
    {

    }

    public function authenticate($sUserName, $sPassword)
    {

    }

    public function createMagicLink($sUserName, $sPassword)
    {

    }

    public function authenticateMagicLink($sToken)
    {

    }

}

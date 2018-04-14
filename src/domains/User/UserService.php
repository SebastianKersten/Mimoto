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
        $aUsers = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_USER]);

        // 2. find
        $nUserCount = count($aUsers);
        for ($nUserIndex = 0; $nUserIndex < $nUserCount; $nUserIndex++)
        {
            // a. register
            $eUser = $aUsers[$nUserIndex];

            // b. compare
            if (strtolower($eUser->get('email')) == strtolower($sUsername))
            {
                // I. read
                $encryptedPassword = $eUser->getValue('password');

                // II. compare
                if (Mimoto::service('session')->comparePassword($sPassword, $encryptedPassword))
                {
                    // 1. compose
                    $user = (object) array(
                        'id' => $eUser->getId(),
                        'firstName' => $eUser->getValue('firstName'),
                        'lastName' => $eUser->getValue('lastName'),
                        'avatar' => '/'.$eUser->getValue('avatar.path').$eUser->getValue('avatar.name'),
                    );

                    // 2. register
                    Mimoto::getSilexApp()['session']->set('is_user', true);
                    Mimoto::getSilexApp()['session']->set('user', $user);

                    // 3. login successful
                    return true;
                }
            }
        }

        // 3. couldn't login
        return false;
    }

    public function logout()
    {
        // 1. clear
        Mimoto::getSilexApp()['session']->clear();
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

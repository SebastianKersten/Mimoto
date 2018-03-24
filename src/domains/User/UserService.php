<?php

// classpath
namespace Mimoto\User;

// Mimoto classes
use Mimoto\Mimoto;
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

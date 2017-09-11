<?php

// classpath
namespace Mimoto\User;

// Mimoto classes
use Mimoto\Mimoto;


/**
 * UserService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class UserService
{


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct()
    {

    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Notify developer
     */
    public function getUserId()
    {
        // send
        return Mimoto::service('session')->currentUser()->getId();
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

}

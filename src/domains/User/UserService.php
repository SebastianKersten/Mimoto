<?php

// classpath
namespace Mimoto\User;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * UserService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class UserService
{

    const USER_ID = 69;


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
        return $sUserId = self::USER_ID;
    }
    
    /**
     * Notify developer
     */
    public function getUserPublicKey($sExtraSaltyHashThing)
    {
        // example
        $sUserId = self::USER_ID;
        $sPublicKey = md5($sExtraSaltyHashThing.md5($sUserId.'#salthashything')); // #todo get from config file

        // send
        return $sPublicKey;
    }

}

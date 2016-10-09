<?php

// classpath
namespace Mimoto\User;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * MimotoUserService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoUserService
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
    public function getUserPublicKey($sExtraSaltyHashThing)
    {
        // example
        $sUserId = 69;
        $sPublicKey = md5($sExtraSaltyHashThing.md5($sUserId.'#salthashything'));

        // send
        return $sPublicKey;
    }

}

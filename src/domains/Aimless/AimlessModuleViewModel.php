<?php

// classpath
namespace Mimoto\Aimless;


/**
 * AimlessModuleViewModel
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessModuleViewModel
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
    // --- Public methods - Aimless -----------------------------------------------
    // ----------------------------------------------------------------------------



    public function module($sModuleName, $values = [])
    {
        return MimotoAimlessUtils::getModule($sModuleName, $values);
    }

}

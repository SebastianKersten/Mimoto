<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\data\MimotoEntity;


/**
 * UserViewModel
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class UserViewModel extends AimlessComponentViewModel
{

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param AimlessComponent $component
     */
    public function __construct(AimlessComponent $component)
    {
        // store
        parent::__construct($component);
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - Aimless -----------------------------------------------
    // ----------------------------------------------------------------------------


    public function hasRole($xRoles)
    {
        // 1. allowed: string or array -> place in separate values
        // 2. check string and trhow in array
        // 3. check array
        // 4. check with user object

        // load
        $eUser = $this->_component->getEntity();

        // read
        $eRoles = $eUser->getValue('roles');

        // check




        return true;
    }

}

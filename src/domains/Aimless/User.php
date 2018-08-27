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
class User
{

    private $_component = null;
    private $_eInstance = null;


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param AimlessComponent $component
     */
    public function __construct(AimlessComponent $component, $eInstance = null)
    {
        // store
        $this->_component = $component;
        $this->_eInstance = $eInstance;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------




    // get/set, add/remove

    public function data()
    {
        return (!empty($this->_eInstance)) ? $this->_eInstance : null;
    }



    public function store()
    {
        Mimoto::service('data')->store($this->_eInstance);
    }



    /**
     * Check if the user has been assigned specific roles
     * Multiple params possible (arg1, arg2, etc)
     * @return bool
     */
    public function hasRole()
    {
        // init
        $bValidated = true;


        // load
        $eUser = $this->_component->getEntity();

        // read
        $aRoles = $eUser->getValue('roles');

        // init
        $aRolesNames = [];

        // collect
        $nRoleCount = count($aRoles);
        for ($nRoleIndex = 0; $nRoleIndex < $nRoleCount; $nRoleIndex++)
        {
            // register
            $eRole = $aRoles[$nRoleIndex];

            // read and overwrite
            $aRolesNames[] = $eRole->getValue('name');
        }

        // register
        $aRequestedRoles = func_get_args();

        // parse
        $nRequestedRoleCount = count($aRequestedRoles);
        for ($nRequestedRoleIndex = 0; $nRequestedRoleIndex < $nRequestedRoleCount; $nRequestedRoleIndex++)
        {
            // register
            $sRequestedRole = $aRequestedRoles[$nRequestedRoleIndex];

            // verify
            if (!in_array($sRequestedRole, $aRolesNames))
            {
                $bValidated = false;
                break;
            }

        }

        // send
        return $bValidated;
    }

}

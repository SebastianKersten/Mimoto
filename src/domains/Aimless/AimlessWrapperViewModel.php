<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\MimotoAimlessUtils;


/**
 * AimlessWrapperViewModel
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessWrapperViewModel extends AimlessComponentViewModel
{

    private $_sComponentName;


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param AimlessInput $input
     */
    public function __construct(AimlessComponent $component, $sComponentName)
    {
        // store
        parent::__construct($component);

        // store
        $this->_sComponentName = $sComponentName;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - Aimless -----------------------------------------------
    // ----------------------------------------------------------------------------


    public function wrap()
    {
        return $this->_component->wrap($this->_sComponentName);
    }

}

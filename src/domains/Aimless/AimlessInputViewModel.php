<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\AimlessComponentViewModel;


/**
 * AimlessInputViewModel
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessInputViewModel extends AimlessComponentViewModel
{


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param AimlessInput $input
     */
    public function __construct(AimlessInput $input)
    {
        // store
        parent::__construct($input);
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - Aimless -----------------------------------------------
    // ----------------------------------------------------------------------------


    public function input()
    {
        return $this->_component->input();
    }

    public function field()
    {
        return $this->_component->field();
    }

    public function fieldId()
    {
        return $this->_component->fieldId();
    }

    public function error()
    {
        return $this->_component->error();
    }

    public function value($bRenderValues = false, $sComponentName = null, $mapping = null)
    {
        return $this->_component->value($bRenderValues, $sComponentName, $mapping);
    }

    public function fieldValidation()
    {
        return $this->_component->fieldValidation();
    }
}

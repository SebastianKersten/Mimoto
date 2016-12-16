<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\MimotoAimlessUtils;


/**
 * AimlessComponentViewModel
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessComponentViewModel
{

    // data
    protected $_component;


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
        $this->_component = $component;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - Aimless -----------------------------------------------
    // ----------------------------------------------------------------------------


    public function data($sPropertySelector, $bGetConnectionInfo = false)
    {
        return $this->_component->data($sPropertySelector, $bGetConnectionInfo);
    }

    public function render($sPropertySelector, $sComponentName = null)
    {
        return $this->_component->data($sPropertySelector, false, true, $sComponentName);
    }
    
    public function selection($sSelectionName)
    {
        return $this->_component->selection($sSelectionName);
    }

    public function realtime($sPropertySelector = null, $sComponentName = null)
    {
        return $this->_component->realtime($sPropertySelector, $sComponentName);
    }

    public function meta($sPropertyName)
    {
        return $this->_component->meta($sPropertyName);
    }

    public function form($sKey = null)
    {
        return $this->_component->form($sKey);
    }

    public function submit($sKey = null)
    {
        return $this->_component->submit($sKey);
    }

    public function module($sModuleName, $values = [])
    {
        return MimotoAimlessUtils::getModule($sModuleName, $values);
    }

}

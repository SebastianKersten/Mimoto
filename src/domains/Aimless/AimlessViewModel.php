<?php

// classpath
namespace Mimoto\Aimless;


/**
 * AimlessViewModel
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessViewModel
{

    // data
    private $_component;


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


    public function data($sPropertySelector)
    {
        return $this->_component->data($sPropertySelector);
    }
    
    public function selection($sSelectionName)
    {
        return $this->_component->selection($sSelectionName);
    }

    public function realtime($sPropertySelector = null)
    {
        return $this->_component->realtime($sPropertySelector);
    }

    public function meta($sPropertyName)
    {
        return $this->_component->meta($sPropertyName);
    }

    public function form($sKey = null)
    {
        return $this->_component->form();
    }

    public function render()
    {
        return $this->_component->render();
    }
}

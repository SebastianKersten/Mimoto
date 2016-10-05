<?php

// classpath
namespace Mimoto\Aimless;


/**
 * AimlessComponentViewModel
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class AimlessComponentViewModel
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
        return $this->_component->form($sKey);
    }

    public function submit($sKey = null)
    {
        return $this->_component->submit($sKey);
    }

    public function input()
    {
        return $this->_component->input();
    }

    public function render()
    {
        return $this->_component->render();
    }
}

<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
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

    public function render($sPropertySelector, $sComponentName = null, $customValues = null)
    {
        return $this->_component->data($sPropertySelector, false, true, $sComponentName, null, $customValues);
    }

    public function renderWrapper($sPropertySelector, $sWrapperName, $sComponentName = null)
    {
        return $this->_component->data($sPropertySelector, false, true, $sComponentName, $sWrapperName);
    }

    public function realtime($sPropertySelector = null, $sComponentName = null)
    {
        return $this->_component->realtime($sPropertySelector, $sComponentName);
    }

    public function realtimeWrapper($sPropertySelector, $sWrapperName, $sComponentName = null)
    {
        return $this->_component->realtime($sPropertySelector, $sComponentName, $sWrapperName);
    }

    public function selection($sSelectionName)
    {
        return $this->_component->selection($sSelectionName);
    }

    public function component($sComponentAlias)
    {
        return $this->_component->component($sComponentAlias);
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

    public function hideOnEmpty($sPropertySelector)
    {
        return $this->_component->hideOnEmpty($sPropertySelector);
    }

    public function showOnEmpty($sPropertySelector)
    {
        return $this->_component->showOnEmpty($sPropertySelector);
    }

    public function reloadOnChange()
    {
        return $this->_component->reloadOnChange();
    }

    public function typeOf($sEntityTypeName)
    {
        return $this->_component->typeOf($sEntityTypeName);
    }

    public function globalValue($sKey)
    {
        return Mimoto::globalValue($sKey);
    }

    public function getValueBySortindex($nIndex = 0)
    {
        return $this->_component->getValueBySortindex($nIndex);
    }

    public function getRealtimeValueBySortindex($nIndex = 0)
    {
        return $this->_component->getValueBySortindex($nIndex, true);
    }

    public function getImageBySortindex($nIndex = 0)
    {
        return $this->_component->getValueBySortindex($nIndex, false, true);
    }

    public function getRealtimeImageBySortindex($nIndex = 0)
    {
        return $this->_component->getValueBySortindex($nIndex, true, true);
    }

}

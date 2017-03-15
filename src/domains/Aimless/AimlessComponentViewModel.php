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

    public function getConnectionId()
    {
        return $this->_component->getConnectionId();
    }


    // visibity and styling options


    public function showWhenEmpty($sPropertySelector)
    {
        return $this->_component->showWhenEmpty($sPropertySelector);
    }

    public function hideWhenEmpty($sPropertySelector)
    {
        return $this->_component->hidewhenEmpty($sPropertySelector);
    }

//    public function showWhenNoEmpty($sPropertySelector)
//    {
//        return $this->_component->showWhenEmpty($sPropertySelector);
//    }

//    public function hideWhenNoEmpty($sPropertySelector)
//    {
//        return $this->_component->hidewhenNotEmpty($sPropertySelector);
//    }

//
//
//
//
//
//
//
//Mimoto.showWhenEmpty(‘’)
//Mimoto.hideWhenEmpty(‘’)
//
//Mimoto.showWhenEquals(‘type’, ‘regular’)
//Mimoto.hideWhenEquals(‘type’, ‘regular’)
//
//Mimoto.styleWhenEquals(‘type’, ‘regular’, ‘background-color:#ff9900’)
//Mimoto.classWhenEquals(‘type’, ‘regular’, ‘your-bam-class’)
//
//> Mimoto.styleWhenEquals(‘subprojects.{type=x}’, 2, ‘background-color:#ff9900’)
//
//> Mimoto.styleWhenGreater
//
//
//
//
//#subprojects = collection
//	#subproject type = x
//	#subproject type = y
//	#subproject type = x
//
//
//
//Mimoto.styleWhenEquals(‘parent, ‘regular’, ‘background-color:#ff9900’)
//
//
//Mimoto.loadWhenEquals(‘type’, ‘explainer’, ‘/your/api/with/html/output’)



}

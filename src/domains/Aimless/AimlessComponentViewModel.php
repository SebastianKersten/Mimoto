<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Aimless\MimotoAimlessUtils;
use Mimoto\Aimless\DisplayOptionUtils;


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


    public function data($sPropertySelector, $sComponentName = null, $options = null)
    {
        $customValues = (!empty($options) && !empty($options['customValues'])) ? $options['customValues'] : null;
        $bGetConnectionInfo = (!empty($options) && !empty($options['getConnectionInfo'])) ? $options['getConnectionInfo'] : false;

        return $this->_component->data($sPropertySelector, $bGetConnectionInfo, !empty($sComponentName), $sComponentName, null, $customValues);
    }


//    public function data($sPropertySelector, $bGetConnectionInfo = false)
//    {
//        return $this->_component->data($sPropertySelector, $bGetConnectionInfo);
//    }

    // new API (replaces data)
//    public function rawData($sPropertySelector, $bGetConnectionInfo = false)
//    {
//        $this->data($sPropertySelector, $bGetConnectionInfo = false);
//    }

//    public function render($sPropertySelector, $sComponentName = null, $customValues = null)
//    {
//        return $this->_component->data($sPropertySelector, false, true, $sComponentName, null, $customValues);
//    }

//    public function renderWrapper($sPropertySelector, $sWrapperName, $sComponentName = null)
//    {
//        return $this->_component->data($sPropertySelector, false, true, $sComponentName, $sWrapperName);
//    }

    public function realtime($sPropertySelector = null, $sComponentName = null)
    {
        return $this->_component->realtime($sPropertySelector, $sComponentName);
    }

//    public function realtimeWrapper($sPropertySelector, $sWrapperName, $sComponentName = null)
//    {
//        return $this->_component->realtime($sPropertySelector, $sComponentName, $sWrapperName);
//    }

    public function jsListen($sPropertySelector, $scope, $fJavascriptDelegate)
    {
        return $this->_component->jsListen($sPropertySelector, $scope, $fJavascriptDelegate);
    }

    public function editable($sPropertySelector, $options = null)
    {
        return $this->_component->editable($sPropertySelector, $options);
    }

    public function selection($sSelectionName, $sComponentName = null)
    {
        return $this->_component->selection($sSelectionName, $sComponentName);
    }

    public function component($sComponentAlias)
    {
        return $this->_component->component($sComponentAlias);
    }

    public function meta($sPropertyName)
    {
        return $this->_component->meta($sPropertyName);
    }

    public function user()
    {
        return $this->_component->user();
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
        return $this->_component->module($sModuleName, $values);
        //return MimotoAimlessUtils::getModule($sModuleName, $values);
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


    public function isEmpty($sPropertySelector)
    {
        return $this->_component->isEmpty($sPropertySelector);
    }




    // --- Show and hide


    public function hideWhenEmpty($sPropertySelector)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_HIDEWHENEMPTY, $sPropertySelector, $this->_component);
    }

    public function hideWhenNotEmpty($sPropertySelector)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY, $sPropertySelector, $this->_component);
    }

    public function hideWhenValue($sPropertySelector, $xValues)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_HIDEWHENVALUE, $sPropertySelector, $this->_component, $xValues);
    }

    public function hideWhenNotValue($sPropertySelector, $xValues)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_HIDEWHENNOTVALUE, $sPropertySelector, $this->_component, $xValues);
    }

    public function hideWhenRegex($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_HIDEWHENREGEX, $sPropertySelector, $this->_component, $xValues);
    }

    public function hideWhenNotRegex($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_HIDEWHENNOTREGEX, $sPropertySelector, $this->_component, $xValues);
    }


    // ---


    public function showWhenEmpty($sPropertySelector)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_SHOWWHENEMPTY, $sPropertySelector, $this->_component);
    }

    public function showWhenNotEmpty($sPropertySelector)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY, $sPropertySelector, $this->_component);
    }

    public function showWhenValue($sPropertySelector, $xValues)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_SHOWWHENVALUE, $sPropertySelector, $this->_component, $xValues);
    }

    public function showWhenNotValue($sPropertySelector, $xValues)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_SHOWWHENNOTVALUE, $sPropertySelector, $this->_component, $xValues);
    }

    public function showWhenRegex($sPropertySelector, $xValues)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_SHOWWHENREGEX, $sPropertySelector, $this->_component, $xValues);
    }

    public function showWhenNotRegex($sPropertySelector, $xValues)
    {
        // compose and send
        return DisplayOptionUtils::visibleWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_SHOWWHENNOTREGEX, $sPropertySelector, $this->_component, $xValues);
    }



    // --- Add and remove CSS classes


    public function addClassWhenEmpty($sPropertySelector, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY, $sPropertySelector, $this->_component, $xClasses);
    }

    public function addClassWhenNotEmpty($sPropertySelector, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY, $sPropertySelector, $this->_component, $xClasses);
    }

    public function addClassWhenValue($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_ADDCLASSWHENVALUE, $sPropertySelector, $this->_component, $xClasses, $xValues);
    }

    public function addClassWhenNotValue($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE, $sPropertySelector, $this->_component, $xClasses, $xValues);
    }

    public function addClassWhenRegex($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_ADDCLASSWHENREGEX, $sPropertySelector, $this->_component, $xClasses, $xValues);
    }

    public function addClassWhenNotRegex($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX, $sPropertySelector, $this->_component, $xClasses, $xValues);
    }


    // ---


    public function removeClassWhenEmpty($sPropertySelector, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY, $sPropertySelector, $this->_component, $xClasses);
    }

    public function removeClassWhenNotEmpty($sPropertySelector, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY, $sPropertySelector, $this->_component, $xClasses);
    }

    public function removeClassWhenValue($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE, $sPropertySelector, $this->_component, $xClasses, $xValues);
    }

    public function removeClassWhenNotValue($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE, $sPropertySelector, $this->_component, $xClasses, $xValues);
    }

    public function removeClassWhenRegex($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX, $sPropertySelector, $this->_component, $xClasses, $xValues);
    }

    public function removeClassWhenNotRegex($sPropertySelector, $xValues, $xClasses)
    {
        // compose and send
        return DisplayOptionUtils::classWhen(DisplayOptionUtils::TAG_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX, $sPropertySelector, $this->_component, $xClasses, $xValues);
    }





    // --- equals ---

//    public function showWhenEquals($sPropertySelector, $value)
//    public function hideWhenEquals($sPropertySelector, $value)
//    public function showWhenNotEquals($sPropertySelector, $value)
//    public function hideWhenNotEquals($sPropertySelector, $value)
//    public function showWhenGreaterThan($sPropertySelector, $value)
//    public function hideWhenGreaterThan($sPropertySelector, $value)
//    public function showWhenLessThan($sPropertySelector, $value)
//    public function hideWhenLessThan($sPropertySelector, $value)
//    public function showWhenGreaterOrEqual($sPropertySelector, $value)
//    public function hideWhenGreaterOrEqual($sPropertySelector, $value)
//    public function showWhenLessOrEqual($sPropertySelector, $value)
//    public function hideWhenLessOrEqual($sPropertySelector, $value)



    // --- style ---

//    public function styleWhenEmpty($sPropertySelector, $value, $sStyle)
//    public function styleWhenNotEmpty($sPropertySelector, $value, $sStyle)
//    public function styleWhenEquals($sPropertySelector, $value, $sStyle)
//    public function styleWhenNotEquals($sPropertySelector, $value, $sStyle)
//    public function styleWhenGreaterThan($sPropertySelector, $value, $sStyle)
//    public function styleWhenNotGreaterThan($sPropertySelector, $value, $sStyle)
//    public function styleWhenGreaterOrEqual($sPropertySelector, $value, $sStyle)
//    public function styleWhenNotGreaterOrEqual($sPropertySelector, $value, $sStyle)
//    public function styleWhenLessOrEqual($sPropertySelector, $value, $sStyle)
//    public function styleWhenNotLessOrEqual($sPropertySelector, $value, $sStyle)


    // --- class ---

//    public function classWhenEmpty($sPropertySelector, $sClass) // #todo - args
//    public function classWhenNotEmpty($sPropertySelector, $value, $sClass)
//    public function classWhenEquals($sPropertySelector, $value, $sClass)
//    public function classWhenNotEquals($sPropertySelector, $value, $sClass)
//    public function classWhenGreaterThan($sPropertySelector, $value, $sClass)
//    public function classWhenNotGreaterThan($sPropertySelector, $value, $sClass)
//    public function classWhenGreaterOrEqual($sPropertySelector, $value, $sClass)
//    public function classWhenNotGreaterOrEqual($sPropertySelector, $value, $sClass)
//    public function classWhenLessOrEqual($sPropertySelector, $value, $sClass)
//    public function classWhenNotLessOrEqual($sPropertySelector, $value, $sClass)



// Mimoto.classWhenInArray('???') ? hoe werkt dit? meegeven als twigVar?

//
//  Mimoto.styleWhenEquals(‘type’, ‘regular’, ‘background-color:#ff9900’)
//
//  Mimoto.styleWhenEquals(‘subprojects.{type=x}’, 2, ‘background-color:#ff9900’)
//
//  Mimoto.styleWhenEquals(‘parent, ‘regular’, ‘background-color:#ff9900’)
//
//  Mimoto.loadWhenEquals(‘type’, ‘explainer’, ‘/your/api/with/html/output’)


}

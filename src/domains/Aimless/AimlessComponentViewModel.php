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



    // --- empty ---


    public function showWhenEmpty($sPropertySelector)
    {
        return $this->_component->showWhenEmpty($sPropertySelector);
//
//            public function showWhenEmpty($sPropertySelector)
//        {
//
//    //            // cleanup
//    //            $nSeparatorPos = strpos($sPropertySelector, '.');
//    //
//    //
//    //        $sSubpropertySelector = substr($sPropertySelector, $nSeparatorPos + 1);
//    //        $selector = MimotoDataUtils::getConditionalsAndSubselector($sSubpropertySelector);
//    //
//    //            // compose
//    //            $sFilter = (!empty($selector->conditionals)) ? " data-aimless-filter='".json_encode($selector->conditionals)."'" : '';
//
//
//
//            if (isset($this->_entity) && $this->hasProperty($sPropertySelector))
//            {
//                $sDisplayState = (!empty($this->data($sPropertySelector))) ? 'style="display:none"' : '';
//
//                return 'data-aimless-showonempty="'.$this->_entity->getAimlessId().'.'.$sPropertySelector.'" '.$sDisplayState;
//            }
//            else
//            {
//                if (isset($this->_aSelections[$sPropertySelector]))
//                {
//                    $sDisplayState = (!$this->_aSelections[$sPropertySelector]->aEntities->isEmpty()) ? 'style="display:none"' : '';
//
//                    return 'data-aimless-showonempty="'.$sPropertySelector.'" '.$sDisplayState;
//                }
//            }
//
//            return '';
//        }



    }

    public function hideWhenEmpty($sPropertySelector)
    {
        return $this->_component->hideWhenEmpty($sPropertySelector);
    }


//    public function showWhenNotEmpty($sPropertySelector)
//    {
//        return $this->_component->showWhenNotEmpty($sPropertySelector);
//    }
//
//    public function hideWhenNotEmpty($sPropertySelector)
//    {
//        return $this->_component->hideWhenNotEmpty($sPropertySelector);
//    }



    // --- equals ---


//    public function showWhenEquals($sPropertySelector, $value)
//    {
//        //return $this->_component->showWhenEquals($sPropertySelector);
//    }
//
//    public function hideWhenEquals($sPropertySelector, $value)
//    {
//        //return $this->_component->hideWhenEquals($sPropertySelector);
//    }
//

//    public function showWhenNotEquals($sPropertySelector, $value)
//    {
//        return $this->_component->showWhenNotEquals($sPropertySelector);
//    }
//
//    public function hideWhenNotEquals($sPropertySelector, $value)
//    {
//        return $this->_component->hideWhenNotEquals($sPropertySelector);
//    }


//    public function showWhenGreaterThan($sPropertySelector, $value)
//    {
//        return $this->_component->showWhenGreaterThan($sPropertySelector);
//    }
//
//    public function hideWhenGreaterThan($sPropertySelector, $value)
//    {
//        return $this->_component->showWhenGreaterThan($sPropertySelector);
//    }


//    public function showWhenLessThan($sPropertySelector, $value)
//    {
//        return $this->_component->showWhenSmallerThan($sPropertySelector);
//    }
//
//    public function hideWhenLessThan($sPropertySelector, $value)
//    {
//        return $this->_component->hideWhenSmallerThan($sPropertySelector);
//    }

//    public function showWhenGreaterOrEqual($sPropertySelector, $value)
//    {
//        return $this->_component->showWhenSmallerThan($sPropertySelector);
//    }

//    public function hideWhenGreaterOrEqual($sPropertySelector, $value)
//    {
//        return $this->_component->hideWhenSmallerThan($sPropertySelector);
//    }

//    public function showWhenLessOrEqual($sPropertySelector, $value)
//    {
//        return $this->_component->showWhenSmallerThan($sPropertySelector);
//    }

//    public function hideWhenLessOrEqual($sPropertySelector, $value)
//    {
//        return $this->_component->hideWhenSmallerThan($sPropertySelector);
//    }



    // --- style ---


//    public function styleWhenEmpty($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenEmpty($sPropertySelector, $value, $sStyle);
//    }
//
//    public function styleWhenNotEmpty($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenEmpty($sPropertySelector, $value, $sStyle);
//    }


//    public function styleWhenEquals($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenEquals($sPropertySelector, $value, $sStyle);
//    }
//
//    public function styleWhenNotEquals($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenNotEquals($sPropertySelector, $value, $sStyle);
//    }


//    public function styleWhenGreaterThan($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenGreaterThan($sPropertySelector, $value, $sStyle);
//    }
//
//    public function styleWhenNotGreaterThan($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenNotGreaterThan($sPropertySelector, $value, $sStyle);
//    }

//    public function styleWhenGreaterOrEqual($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenGreaterThan($sPropertySelector, $value, $sStyle);
//    }
//
//    public function styleWhenNotGreaterOrEqual($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenNotGreaterThan($sPropertySelector, $value, $sStyle);
//    }

//    public function styleWhenLessOrEqual($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenGreaterThan($sPropertySelector, $value, $sStyle);
//    }
//
//    public function styleWhenNotLessOrEqual($sPropertySelector, $value, $sStyle)
//    {
//        return $this->_component->styleWhenNotGreaterThan($sPropertySelector, $value, $sStyle);
//    }



    // --- class ---


//    public function classWhenEmpty($sPropertySelector, $sClass) // #todo - args
//    {
//        return $this->_component->styleWhenEmpty($sPropertySelector, $value, $sStyle);
//    }
//
//    public function classWhenNotEmpty($sPropertySelector, $value, $sClass)
//    {
//        return $this->_component->styleWhenEmpty($sPropertySelector, $value, $sStyle);
//    }


//    public function classWhenEquals($sPropertySelector, $value, $sClass)
//    {
//        return $this->_component->styleWhenEquals($sPropertySelector, $value, $sStyle);
//    }
//
//    public function classWhenNotEquals($sPropertySelector, $value, $sClass)
//    {
//        return $this->_component->styleWhenNotEquals($sPropertySelector, $value, $sStyle);
//    }


//    public function classWhenGreaterThan($sPropertySelector, $value, $sClass)
//    {
//        return $this->_component->styleWhenGreaterThan($sPropertySelector, $value, $sStyle);
//    }
//
//    public function classWhenNotGreaterThan($sPropertySelector, $value, $sClass)
//    {
//        return $this->_component->styleWhenNotGreaterThan($sPropertySelector, $value, $sStyle);
//    }

//    public function classWhenGreaterOrEqual($sPropertySelector, $value, $sClass)
//    {
//        return $this->_component->styleWhenGreaterThan($sPropertySelector, $value, $sStyle);
//    }
//
//    public function classWhenNotGreaterOrEqual($sPropertySelector, $value, $sClass)
//    {
//        return $this->_component->styleWhenNotGreaterThan($sPropertySelector, $value, $sStyle);
//    }

//    public function classWhenLessOrEqual($sPropertySelector, $value, $sClass)
//    {
//        return $this->_component->styleWhenGreaterThan($sPropertySelector, $value, $sStyle);
//    }
//
//    public function classWhenNotLessOrEqual($sPropertySelector, $value, $sClass)
//    {
//        return $this->_component->styleWhenNotGreaterThan($sPropertySelector, $value, $sStyle);
//    }



// Mimoto.classWhenInArray('???') ? hoe werkt dit? meegeven als twigVar?


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
//Mimoto.styleWhenEquals(‘parent, ‘regular’, ‘background-color:#ff9900’)
//
//
//Mimoto.loadWhenEquals(‘type’, ‘explainer’, ‘/your/api/with/html/output’)

    private function comparePropertyToValue()
    {



    }

}

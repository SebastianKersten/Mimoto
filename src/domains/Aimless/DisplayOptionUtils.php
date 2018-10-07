<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Aimless\AimlessComponent;


/**
 * DisplayOptionUtils
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class DisplayOptionUtils
{

    // tags
    const DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENEMPTY              = 'data-mimoto-display-hidewhenempty';
    const DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY           = 'data-mimoto-display-hidewhennotempty';
    const DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENVALUE              = 'data-mimoto-display-hidewhenvalue';
    const DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTVALUE           = 'data-mimoto-display-hidewhennotvalue';
    const DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENREGEX              = 'data-mimoto-display-hidewhenregex';
    const DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTREGEX           = 'data-mimoto-display-hidewhennotregex';

    const DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENEMPTY              = 'data-mimoto-display-showwhenempty';
    const DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY           = 'data-mimoto-display-showwhennotempty';
    const DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENVALUE              = 'data-mimoto-display-showwhenvalue';
    const DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTVALUE           = 'data-mimoto-display-showwhennotvalue';
    const DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENREGEX              = 'data-mimoto-display-showwhenregex';
    const DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTREGEX           = 'data-mimoto-display-showwhennotregex';

    const DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY          = 'data-mimoto-display-addclasswhenempty';
    const DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY       = 'data-mimoto-display-addclasswhennotempty';
    const DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENVALUE          = 'data-mimoto-display-addclasswhenvalue';
    const DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE       = 'data-mimoto-display-addclasswhennotvalue';
    const DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENREGEX          = 'data-mimoto-display-addclasswhenregex';
    const DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX       = 'data-mimoto-display-addclasswhennotregex';

    const DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY       = 'data-mimoto-display-removeclasswhenempty';
    const DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY    = 'data-mimoto-display-removeclasswhennotempty';
    const DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE       = 'data-mimoto-display-removeclasswhenvalue';
    const DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE    = 'data-mimoto-display-removeclasswhennotvalue';
    const DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX       = 'data-mimoto-display-removeclasswhenregex';
    const DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX    = 'data-mimoto-display-removeclasswhennotregex';



    // ----------------------------------------------------------------------------
    // --- Publi methods ----------------------------------------------------------
    // ----------------------------------------------------------------------------



    public static function classWhen($sAction, $sPropertyName, AimlessComponent $component, $xClasses, $xValues = null)
    {
        // 1. init
        $aClasses = [];

        // 2. verify
        if (is_array($xClasses))
        {
            foreach ($xClasses as $sKey => $sValue)
            {
                if (is_string($xClasses[$sKey]) && is_string($sValue)) $aClasses[] = $sValue;
            }
        }
        else if (is_string($xClasses))
        {
            $aClasses[] = $xClasses;
        }

        // 3. init and compose
        $instructions = (object) array(
            'classes' => $aClasses
        );

        // 4. collect, build and send
        return self::buildDirective($instructions, $sAction, $sPropertyName, $component, $xValues);
    }

    public static function visibleWhen($sAction, $sPropertyName, AimlessComponent $component, $xValues = null, $options = null)
    {
        // 1. init
        $instructions = (object) array();

        // 2. collect, build and send
        return self::buildDirective($instructions, $sAction, $sPropertyName, $component, $xValues, $options);
    }



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    private static function buildDirective($instructions, $sAction, $sPropertyName, AimlessComponent $component, $xValues = null, $options = null)
    {
        // 1. add action specific data
        switch($sAction)
        {
            case self::DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENEMPTY:
            case self::DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENEMPTY:
            case self::DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENEMPTY:
            case self::DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENEMPTY:

                $instructions->initialState = $component->isEmpty($sPropertyName);
                break;

            case self::DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTEMPTY:
            case self::DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTEMPTY:
            case self::DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTEMPTY:
            case self::DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTEMPTY:

                $instructions->initialState = !$component->isEmpty($sPropertyName);
                break;

            case self::DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENVALUE:
            case self::DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENVALUE:
            case self::DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENVALUE:
            case self::DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENVALUE:

                $instructions->values = self::prepareValues($xValues);
                $instructions->initialState = self::isValue($component->data($sPropertyName), $instructions->values);
                break;

            case self::DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTVALUE:
            case self::DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTVALUE:
            case self::DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTVALUE:
            case self::DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTVALUE:

                $instructions->values = self::prepareValues($xValues);
                $instructions->initialState = !self::isValue($component->data($sPropertyName), $instructions->values);
                break;

            case self::DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENREGEX:
            case self::DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENREGEX:
            case self::DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENREGEX:
            case self::DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENREGEX:

                $instructions->patterns = self::prepareValues($xValues);
                $instructions->initialState = self::isRegex($component->data($sPropertyName), $instructions->patterns);
                break;

            case self::DIRECTIVE_MIMOTO_DISPLAY_HIDEWHENNOTREGEX:
            case self::DIRECTIVE_MIMOTO_DISPLAY_SHOWWHENNOTREGEX:
            case self::DIRECTIVE_MIMOTO_DISPLAY_ADDCLASSWHENNOTREGEX:
            case self::DIRECTIVE_MIMOTO_DISPLAY_REMOVECLASSWHENNOTREGEX:

                $instructions->patterns = self::prepareValues($xValues);
                $instructions->initialState = !self::isRegex($component->data($sPropertyName), $instructions->patterns);
                break;
        }


        // 2. complete selector
        $sPropertySelector = $component->getPropertySelector($sPropertyName);

        // 3. add information
        $instructions->propertyType = $component->getPropertyType($sPropertyName);

        // 4. compose and send
        return $sAction.'="'.$sPropertySelector.'|'.htmlentities(json_encode($instructions), ENT_QUOTES, 'UTF-8').'"';
    }


    private static function prepareValues($xValues)
    {
        // init
        $aValues = [];

        if (is_array($xValues))
        {
            foreach ($xValues as $sKey => $sValue)
            {
                if (is_string($xValues[$sKey]) && is_string($sValue)) $aValues[] = $sValue;
            }
        }
        else
        {
            $aValues[] = $xValues;
        }

        // send
        return $aValues;
    }

    private static function isValue($value, $aValues)
    {
        // 1. init
        $bValidated = false;

        // 2. find
        $nValueCount = count($aValues);
        for ($nValueIndex = 0; $nValueIndex < $nValueCount; $nValueIndex++)
        {
            if ($value == $aValues[$nValueIndex])
            {
                // toggle
                $bValidated = true;
                break;
            }
        }

        // 3. send
        return $bValidated;
    }

    private static function isRegex($value, $aPatterns)
    {
        // 1. init
        $bValidated = false;

        // 2. find
        $nPatternCount = count($aPatterns);
        for ($nPatternIndex = 0; $nPatternIndex < $nPatternCount; $nPatternIndex++)
        {
            $sPattern = "/".$aPatterns[$nPatternIndex]."/";

            if (preg_match($sPattern, $value) == 1)
            {
                // toggle
                $bValidated = true;
                break;
            }
        }

        // 3. send
        return $bValidated;
    }

}

<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Aimless\AimlessComponent;


/**
 * DataManipulationUtils
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class DataManipulationUtils
{

    // tags
    const MIMOTO_DATA_EDIT  = 'data-mimoto-edit';
    const MIMOTO_DATA_ADD   = 'data-mimoto-add';




    // ----------------------------------------------------------------------------
    // --- Publi methods ----------------------------------------------------------
    // ----------------------------------------------------------------------------



    public static function manipulate($sDirective, $sPropertyName, AimlessComponent $component, $instructions = null, $options = null)
    {
        // 1. validate or init
        if (empty($instructions)) $instructions = (object) array();

        // 2. complete selector
        $sPropertySelector = $component->getPropertySelector($sPropertyName);

        // 3. setup
        $instructions->propertyType = $component->getPropertyType($sPropertyName);
        if (!empty($options)) $instructions->options = $options;

        // 4. compose and send
        return 'data-mimoto '.$sDirective.'="'.$sPropertySelector.'|'.htmlentities(json_encode($instructions), ENT_QUOTES, 'UTF-8').'"';
    }

}

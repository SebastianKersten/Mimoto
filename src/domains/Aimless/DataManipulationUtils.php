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
    const MIMOTO_DATA_EDIT   = 'data-mimoto-edit';
    const MIMOTO_DATA_ADD    = 'data-mimoto-add';
    const MIMOTO_DATA_REMOVE = 'data-mimoto-remove';
    const MIMOTO_DATA_SELECT = 'data-mimoto-select';




    // ----------------------------------------------------------------------------
    // --- Publi methods ----------------------------------------------------------
    // ----------------------------------------------------------------------------



    public static function manipulate($sDirective, $sPropertyName, AimlessComponent $component, $instructions = null, $options = null)
    {
        // 1. validate or init
        if (empty($instructions)) $instructions = (object) array();

        // 2. complete selector
        if (empty($sPropertyName))
        {
            $sSelector = $component->meta('type').'.'.$component->meta('id');
        }
        else
        {
            $sSelector = $component->getPropertySelector($sPropertyName);

            // setup
            $instructions->propertyType = $component->getPropertyType($sPropertyName);
        }

        // 3. setup
        if (!empty($options)) $instructions->options = $options;

        // 4. compose and send
        return 'data-mimoto '.$sDirective.'="'.$sSelector.'|'.htmlentities(json_encode($instructions), ENT_QUOTES, 'UTF-8').'"';
    }

}

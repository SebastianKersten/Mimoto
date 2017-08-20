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
    const MIMOTO_DATA_SET    = 'data-mimoto-set';




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
            // check if valid selector
            if (strpos($sPropertyName, '.') === false) // #todo - move to data utils
            {
                $sSelector = $component->getPropertySelector($sPropertyName);

                // setup
                $instructions->propertyType = $component->getPropertyType($sPropertyName);
            }
            else
            {

                $sSelector = $sPropertyName; // #todo - rename

                // #todo - get property type from config service
            }


        }

        // 3. setup
        if (!empty($options)) $instructions->options = $options;

        // 4. compose and send
        return 'data-mimoto '.$sDirective.'="'.$sSelector.'|'.htmlentities(json_encode($instructions), ENT_QUOTES, 'UTF-8').'"';
    }

}

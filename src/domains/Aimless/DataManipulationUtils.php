<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Mimoto;
use Mimoto\Aimless\AimlessComponent;


/**
 * DataManipulationUtils
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class DataManipulationUtils
{

    // manipulation
    const MIMOTO_DATA_EDIT            = 'data-mimoto-edit';
    const MIMOTO_DATA_ADD             = 'data-mimoto-add';
    const MIMOTO_DATA_REMOVE          = 'data-mimoto-remove';
    const MIMOTO_DATA_SELECT          = 'data-mimoto-select';
    const MIMOTO_DATA_SET             = 'data-mimoto-set';
    const MIMOTO_DATA_CREATE          = 'data-mimoto-create';
    const MIMOTO_DATA_CLEAR           = 'data-mimoto-clear';

    const MIMOTO_DATA_SORTABLE        = 'data-mimoto-sortable';
    const MIMOTO_DATA_SORTHANDLE      = 'data-mimoto-sorthandle';

    const MIMOTO_DATA_ATTRIBUTE       = 'data-mimoto-attribute';
    const MIMOTO_DATA_EDITABLE        = 'data-mimoto-editable';
    const MIMOTO_DATA_TOGGLE_EDITMODE = 'data-mimoto-toggle-editmode';
    const MIMOTO_DATA_COLLABORATE     = 'data-mimoto-collaborate';

    // utils
    const MIMOTO_DATA_API      = 'data-mimoto-api';

    // communication
    const MIMOTO_DATA_CHANNEL  = 'data-mimoto-channel';




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
            $sSelector = MimotoDataUtils::buildSelector($component->meta('type'), $component->meta('id'));
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
        return $sDirective.'="'.$sSelector.'|'.htmlentities(json_encode($instructions), ENT_QUOTES, 'UTF-8').'"';
    }

}

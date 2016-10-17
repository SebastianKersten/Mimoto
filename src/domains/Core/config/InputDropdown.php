<?php

// classpath
namespace Mimoto\Core\config;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * InputDropdown
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputDropdown
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN,
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--options',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'options',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--options-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE, // #todo ---> kan Selection worden
                            'value' => CoreConfig::DATA_VALUE_TEXTBLOCK
                        )
                    ]
                )
            ]
        );
    }

    public static function getData()
    {
        // hierin komen de velden die nodig zijn voor entity-management etc
    }

}

<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * InputCheckbox
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputCheckbox
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX,
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX.'--label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX.'--label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'--option',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'option',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'--option_type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX.'--description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX.'--description-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
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

<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * CoreConfig__Mimoto_Form_Input_Radiobutton
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CoreConfig__Mimoto_Form_Input_Radiobutton
{

    static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON,
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'__label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'__label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'__options',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'options',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'__options-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE, // #todo ---> kan Selection worden
                            'value' => CoreConfig::DATA_VALUE_TEXTBLOCK
                        )
                    ]
                )



                // TEMP - varname
                , (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'__varname',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'varname',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'__varname-type',
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

    static function getData()
    {
        // hierin komen de velden die nodig zijn voor entity-management etc
    }

}
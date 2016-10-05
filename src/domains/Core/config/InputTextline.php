<?php

// classpath
namespace Mimoto\Core\config;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * InputTextline
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputTextline
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__description-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__placeholder',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'placeholder',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__placeholder-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__optional',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'optional',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__optional-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_BOOLEAN,
                            'value' => true
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__regexp',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'regexp',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__regexp-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__maxchars',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'maxchars',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'__maxchars-type',
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

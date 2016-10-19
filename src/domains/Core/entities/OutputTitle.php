<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * OutputTitle
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class OutputTitle
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
            'extends' => null,
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'__title',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'title',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'__title-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'__subtitle',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'subtitle',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'__subtitle-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'__description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'__description-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
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

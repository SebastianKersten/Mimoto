<?php

// classpath
namespace Mimoto\Core\config;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * InputValue
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputValue
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUTVALUE,
            'extends' => null,
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'__vartype',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'vartype',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'__vartype-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'__varname',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'varname',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'__varname-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'__entityproperty',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'entityproperty',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'__entityproperty-allowedEntityType',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityType',
                            'type' => 'value',
                            'value' => CoreConfig::MIMOTO_ENTITYPROPERTY
                        )
                    ]
                )

                // 1. validation
                // 2. values
                // 3.

            ]
        );
    }

    public static function getData()
    {
        // hierin komen de velden die nodig zijn voor entity-management etc
    }

}

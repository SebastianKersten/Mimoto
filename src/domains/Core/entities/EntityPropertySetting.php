<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * EntityPropertySetting
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertySetting
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING,
            'extends' => null,
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--key',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'key',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--key-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--type',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'type',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--type-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--value',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'value',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--value-type',
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

    }

}

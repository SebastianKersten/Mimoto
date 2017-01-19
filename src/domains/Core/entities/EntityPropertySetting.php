<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


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
            'forms' => [],
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
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
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
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
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
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityType',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'allowedEntityType',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityType-allowedEntityType',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityType',
                            'type' => '', // #todo - fixme
                            'value' => CoreConfig::MIMOTO_ENTITY
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityTypes',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'allowedEntityTypes',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityTypes-allowedEntityTypes',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => 'array',
                            'value' => [CoreConfig::MIMOTO_ENTITY]
                        ),
                        'allowDuplicates' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityTypes-allowDuplicates',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowDuplicates',
                            'value' => CoreConfig::DATA_VALUE_FALSE,
                            'type' => CoreConfig::DATA_TYPE_BOOLEAN
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

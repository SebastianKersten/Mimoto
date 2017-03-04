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
            //'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING,
            'extends' => null,
            'forms' => [
                CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE,
                CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE,
                CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES,
                CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES
            ],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--key',
                    // ---
                    'name' => 'key',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--type',
                    // ---
                    'name' => 'type',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--value',
                    // ---
                    'name' => 'value',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityType',
                    // ---
                    'name' => 'allowedEntityType',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => 'id',
                            'value' => null
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityTypes',
                    // ---
                    'name' => 'allowedEntityTypes',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => 'array',
                            'value' => []
                        ),
                        'allowDuplicates' => (object) array(
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

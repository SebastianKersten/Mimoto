<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * CoreConfig__Mimoto_EntityProperty
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CoreConfig__Mimoto_EntityProperty
{

    static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ENTITYPROPERTY,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_ENTITYPROPERTY,
            'properties' => [
                (object) array(

                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'__name',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'name',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'__name-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'__type',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'type',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'__type-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'__settings',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'settings',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'__settings-allowedEntityTypes',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => 'array',
                            'value' => '["'.CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'"]'

                        ),
                        'allowDuplicates' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'__settings-allowDuplicates',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowDuplicates',
                            'type' => CoreConfig::DATA_TYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                )
            ]
        );
    }

    static function getData()
    {

    }

}
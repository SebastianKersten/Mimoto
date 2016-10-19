<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * Entity
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Entity
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ENTITY,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_ENTITY,
            'extends' => null,
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITY.'--name',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'name',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--name-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITY.'--properties',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'properties',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--properties-allowedEntityTypes',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => 'array',
                            'value' => '["'.CoreConfig::MIMOTO_ENTITY.'"]'
                        ),
                        'allowDuplicates' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--properties-allowDuplicates',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowDuplicates',
                            'type' => CoreConfig::DATA_TYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITY.'--extends',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'extends',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--extends-allowedEntityType',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityType',
                            'type' => 'value',
                            'value' => CoreConfig::MIMOTO_ENTITY
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

<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * FormattingOptionAttribute
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormattingOptionAttribute
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORMATTINGOPTION,
            //'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORMATTINGOPTION,
            'extends' => null,
            'forms' => [
                CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE,
                CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS,
                CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE,
                CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES,
                CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES
            ],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--name',
                    // ---
                    'name' => 'name',
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
                    'id' => CoreConfig::MIMOTO_FORMATTINGOPTION.'--attributes',
                    // ---
                    'name' => 'attributes',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => 'array',
                            'value' => [CoreConfig::MIMOTO_FORMATTINGOPTION_ATTRIBUTE]
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

<?php

// classpath
namespace Mimoto\Core\entities;

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
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--vartype',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'vartype',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--vartype-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--varname',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'varname',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--varname-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--entityproperty',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'entityproperty',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--entityproperty-allowedEntityType',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityType',
                            'type' => 'value',
                            'value' => CoreConfig::MIMOTO_ENTITYPROPERTY
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--options',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'options',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--options-allowedEntityTypes',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => 'array',
                            'value' => [CoreConfig::MIMOTO_FORM_INPUTVALUESETTING]
                        ),
                        'allowDuplicates' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--options-allowDuplicates',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowDuplicates',
                            'type' => CoreConfig::DATA_TYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--validation',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'validation',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--validation-allowedEntityTypes',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => 'array',
                            'value' => [CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION]
                        ),
                        'allowDuplicates' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--validation-allowDuplicates',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowDuplicates',
                            'type' => CoreConfig::DATA_TYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--optional',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'optional',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--optional-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => CoreConfig::DATA_TYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
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

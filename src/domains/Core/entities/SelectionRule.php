<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;
use Mimoto\Selection\SelectionRuleTypes;


/**
 * SelectionRule
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SelectionRule
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_SELECTIONRULE,
            // ---
            'name' => CoreConfig::MIMOTO_SELECTIONRULE,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_SELECTIONRULE],
            'properties' => [

                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--typeAsVar',
                    // ---
                    'name' => 'typeAsVar',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => null
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--typeVarName',
                    // ---
                    'name' => 'typeVarName',
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
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--type',
                    // ---
                    'name' => 'type',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_ENTITY
                        )
                    ]
                ),


                // ---


                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--idAsVar',
                    // ---
                    'name' => 'idAsVar',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => null
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--idVarName',
                    // ---
                    'name' => 'idVarName',
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
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--instance',
                    // ---
                    'name' => 'instance',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => null
                        )
                    ]
                ),


                // ---


                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--propertyAsVar',
                    // ---
                    'name' => 'propertyAsVar',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => null
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--propertyVarName',
                    // ---
                    'name' => 'propertyVarName',
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
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--property',
                    // ---
                    'name' => 'property',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_ENTITYPROPERTY
                        )
                    ]
                ),


                // ---


                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTION.'--values',
                    // ---
                    'name' => 'values',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_SELECTIONRULEVALUE]
                        ),
                        'allowDuplicates' => (object) array(
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),


                // ---


                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--childTypeAsVar',
                    // ---
                    'name' => 'childTypeAsVar',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => null
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--childTypeVarName',
                    // ---
                    'name' => 'childTypeVarName',
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
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--childType',
                    // ---
                    'name' => 'childType',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_ENTITY
                        )
                    ]
                ),


                // ---


                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTION.'--childValues',
                    // ---
                    'name' => 'childValues',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_SELECTIONRULEVALUE]
                        ),
                        'allowDuplicates' => (object) array(
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                )
            ]
        );
    }

    public static function getData()
    {

    }



    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_SELECTIONRULE,
            'name' => CoreConfig::MIMOTO_SELECTIONRULE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'typeAsVar'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'typeVarName'),
                //CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'type'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'idAsVar'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'idVarName'),
                //CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'instance'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'propertyAsVar'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'propertyVarName'),
                //CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'property'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'values'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'childTypeAsVar'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'childTypeVarName'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'childType'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'childValues')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_SELECTIONRULE);

        // setup
        CoreFormUtils::addField_title($form, 'Selection rule', '', "Configure a selection rule to select specific sets of data.");


        CoreFormUtils::addField_groupStart($form);
        
        CoreFormUtils::addField_checkbox
        (
            $form, 'typeAsVar', CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTIONRULE, 'typeAsVar'),
            'Type as variable',
            'Use a variable to define the type'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'typeVarName', CoreConfig::MIMOTO_SELECTIONRULE.'--typeVarName',
            'Var name for the entity type', 'Enter the variable name', 'The variable`s name should be unique'
        );


        CoreFormUtils::addField_groupEnd($form);


        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------




}

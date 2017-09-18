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
            'id' => CoreConfig::MIMOTO_SELECTION_RULE,
            // ---
            'name' => CoreConfig::MIMOTO_SELECTION_RULE,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_SELECTION_RULE],
            'properties' => [

                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--typeAsVar',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--typeVarName',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--type',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--idAsVar',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--idVarName',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--instance',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--propertyAsVar',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--propertyVarName',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--property',
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
                            'value' => [CoreConfig::MIMOTO_SELECTION_RULEVALUE]
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--childTypeAsVar',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--childTypeVarName',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE.'--childType',
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
                            'value' => [CoreConfig::MIMOTO_SELECTION_RULEVALUE]
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
            'id' => CoreConfig::MIMOTO_SELECTION_RULE,
            'name' => CoreConfig::MIMOTO_SELECTION_RULE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'typeAsVar'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'typeVarName'),
                //CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'type'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'idAsVar'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'idVarName'),
                //CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'instance'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'propertyAsVar'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'propertyVarName'),
                //CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'property'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'values'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'childTypeAsVar'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'childTypeVarName'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'childType'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'childValues')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_SELECTION_RULE);

        // setup
        CoreFormUtils::addField_title($form, 'Selection rule', '', "Configure a selection rule to select specific sets of data.");


        CoreFormUtils::addField_groupStart($form);
        
        CoreFormUtils::addField_checkbox
        (
            $form, 'typeAsVar', CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'typeAsVar'),
            'Type as variable',
            'Use a variable to define the type'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'typeVarName', CoreConfig::MIMOTO_SELECTION_RULE.'--typeVarName',
            'Var name for the entity type', 'Enter the variable name', 'The variable`s name should be unique'
        );

        CoreFormUtils::addField_checkbox
        (
            $form, 'idAsVar', CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'idAsVar'),
            'Instance id as variable',
            'Use a variable to define the id'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'idVarName', CoreConfig::MIMOTO_SELECTION_RULE.'--idVarName',
            'Var name for the instance id', 'Enter the variable name', 'The variable`s name should be unique'
        );

        CoreFormUtils::addField_checkbox
        (
            $form, 'propertyAsVar', CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE, 'propertyAsVar'),
            'Property as variable',
            'Use a variable to define the property'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'propertyVarName', CoreConfig::MIMOTO_SELECTION_RULE.'--propertyVarName',
            'Var name for the property', 'Enter the variable name', 'The variable`s name should be unique'
        );


        CoreFormUtils::addField_groupEnd($form);


        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------




}

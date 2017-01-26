<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * EntityProperty
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityProperty
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ENTITYPROPERTY,
            //'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_ENTITYPROPERTY,
            'extends' => null,
            'forms' => [
                CoreConfig::COREFORM_ENTITYPROPERTY
            ],
            'properties' => [
                (object) array(

                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--name',
                   // 'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'name',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            //'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--name-type',
                            //'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--type',
                    //'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'type',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            //'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--type-type',
                            //'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--settings',
                    //'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'settings',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            //'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--settings-allowedEntityTypes',
                            //'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_ENTITYPROPERTYSETTING]

                        ),
                        'allowDuplicates' => (object) array(
                            //'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--settings-allowDuplicates',
                            //'created' => CoreConfig::EPOCH,
                            // ---
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
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_ENTITYPROPERTY);

        // setup
        CoreFormUtils::addField_title($form, 'Property', '', "Entities are composed of 'properties'. Add properties to your entity and decide what type they are. A property can have three types: <i>value</i>, <i>entity</i> or <i>collection</i>");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_ENTITYPROPERTY.'--name',
            'Name', 'Property name', 'The property name should be unique'
        );
        self::setNameValidation($field);


        $form->addValue('fields', self::getField_type());

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------



    /**
     * Get field: name
     */
    private static function setNameValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation2');
        $validationRule->setValue('key', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The property name can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // validation rule #2
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation1');
        $validationRule->setValue('key', 'regex_custom');
        $validationRule->setValue('value', '^[a-z][a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'Name should be in lowerCamelCase, starting with a letter followed by [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);


//
//        // validation rule #3
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE_VALIDATION);
//        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation3');
//        $validationRule->setValue('key', 'regex_custom');
//        $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
//        $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
//        $field->addValue('validation', $validationRule);
//
//        // validation rule #4
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE_VALIDATION);
//        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation4');
//        $validationRule->setValue('key', 'api');
//        $validationRule->setValue('value', '/mimoto.cms/entityproperty/validatename');
//        $validationRule->setValue('errorMessage', 'The name needs to be unique');
//        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Get field: type
     */
    private static function getField_type()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type');
        $field->setValue('label', 'Type');

        // 3. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--type');
        $field->setValue('value', $connectedEntityProperty);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-value');
        $option->setValue('key', MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-entity');
        $option->setValue('key', MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-collection');
        $option->setValue('key', MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_validation1');
        $validationRule->setValue('key', 'regex_custom');
        $validationRule->setValue('value', '^('.MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE.'|'.MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY.'|'.MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

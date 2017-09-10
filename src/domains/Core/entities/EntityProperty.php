<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\Data\MimotoEntity;
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
            // ---
            'name' => CoreConfig::MIMOTO_ENTITYPROPERTY,
            'extends' => null,
            'forms' => [
                CoreConfig::COREFORM_ENTITYPROPERTY
            ],
            'properties' => [
                (object) array(

                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--name',
                    // ---
                    'name' => 'name',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => EntityConfig::SETTING_VALUE_TYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--type',
                    // ---
                    'name' => 'type',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => EntityConfig::SETTING_VALUE_TYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--subtype',
                    // ---
                    'name' => 'subtype',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => EntityConfig::SETTING_VALUE_TYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITYPROPERTY.'--settings',
                    // ---
                    'name' => 'settings',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_ENTITYPROPERTYSETTING]

                        ),
                        'allowDuplicates' => (object) array(
                            'key' => EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES,
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

    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_ENTITYPROPERTY,
            'name' => CoreConfig::COREFORM_ENTITYPROPERTY,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_ENTITYPROPERTY, 'name'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_ENTITYPROPERTY, 'type')
            ]
        );
    }



    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form
     */
    public static function getForm($eEntityProperty = null)
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_ENTITYPROPERTY, true);

        // setup
        CoreFormUtils::addField_title($form, 'Property', '', "Entities are composed of 'properties'. Add properties to your entity and decide what type they are. A property can have three types: <i>value</i>, <i>entity</i> or <i>collection</i>");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_ENTITYPROPERTY.'--name',
            'Name', 'Property name', 'The property name should be unique'
        );
        self::setNameValidation($field);

        // only show when unset
        if (empty($eEntityProperty) || empty($eEntityProperty->getValue('type'))) $form->addValue('fields', self::getField_type());


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
    private static function setNameValidation(MimotoEntity $field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation2');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The property name can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // validation rule #2
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^[a-z][a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'Name should be in lowerCamelCase, starting with a letter followed by [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);


//
//        // validation rule #3
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE_VALIDATION);
//        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation3');
//        $validationRule->setValue('type', 'regex_custom');
//        $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
//        $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
//        $field->addValue('validation', $validationRule);
//
//        // validation rule #4
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE_VALIDATION);
//        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation4');
//        $validationRule->setValue('type', 'api');
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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::COREFORM_ENTITYPROPERTY, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ENTITYPROPERTY, 'type');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-value');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-entity');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-collection');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-image');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-video');
        $option->setValue('label', MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO);
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE.'|'.MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY.'|'.MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION.'|'.MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE.'|'.MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

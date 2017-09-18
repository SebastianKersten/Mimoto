<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\Data\MimotoEntity;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * RoutePathElement
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class RoutePathElement
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT,
            // ---
            'name' => CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--type',
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
                    'id' => CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--staticValue',
                    // ---
                    'name' => 'staticValue',
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
                    'id' => CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--varName',
                    // ---
                    'name' => 'varName',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
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
            'id' => CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT,
            'name' => CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT, 'type'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT, 'value')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT);

        // setup
        CoreFormUtils::addField_title($form, 'Path element', '', "The core element of data is called an 'entity'. Entities are the data objects that contain a certain set of properties, for instance <i>Person</i> containing a <i>name</i> and a <i>date of birth</i>");
        CoreFormUtils::addField_groupStart($form);

        $form->addValue('fields', self::getField_type());

        $field = CoreFormUtils::addField_textline
        (
            $form, 'staticValue', CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--staticValue',
            'Static part of the path', 'Enter the path`s element'
        );
        //self::setStaticValueValidation($field);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'varName', CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--varName',
            'Variable name', 'The variable`s name', "The variable`s name should be unique"
        );
        //self::setVarNameValidation($field);


        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get field: type
     */
    private static function getField_type()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT, 'type');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--type_value_options-var');
        $option->setValue('label', 'Static');
        $option->setValue('value', 'static');
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--type_value_options-var');
        $option->setValue('label', 'Slash');
        $option->setValue('value', 'slash');
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--type_value_options-static');
        $option->setValue('label', 'Variable');
        $option->setValue('value', 'var');
        $field->addValue('options', $option);


        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^(static|slash|var)$');
        $validationRule->setValue('errorMessage', 'Select one of the types above');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Set validation for staticValue
     */
    private static function setStaticValueValidation(MimotoEntity $field)
    {


        // 1. activate only when type = 'static'
        // 2. conditional validation



        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--staticValue_value_validation2');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', 'The value can`t be empty');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // validation rule #2
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--staticValue_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^[a-z][a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'Name should be in lowerCamelCase, starting with a letter followed by [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Set validation for varName
     */
    private static function setVarNameValidation(MimotoEntity $field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--name_value_validation2');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The var name can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // validation rule #2
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT.'--name_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^[a-z][a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'The variable`s name should be in lowerCamelCase, starting with a letter followed by [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputValidation
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputValidation
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUTVALIDATION,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUTVALIDATION,
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_FORM_INPUTVALIDATION],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALIDATION.'--type',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALIDATION.'--value',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALIDATION.'--errorMessage',
                    // ---
                    'name' => 'errorMessage',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALIDATION.'--trigger',
                    // ---
                    'name' => 'trigger',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
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




    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_FORM_INPUTVALIDATION,
            'name' => CoreConfig::COREFORM_FORM_INPUTVALIDATION,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_FORM_INPUTVALIDATION, 'type'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_FORM_INPUTVALIDATION, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_FORM_INPUTVALIDATION, 'errorMessage'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_FORM_INPUTVALIDATION, 'trigger')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_FORM_INPUTVALIDATION);

        // setup
        CoreFormUtils::addField_title($form, 'Validation', 'Set a validation rule', '');
        CoreFormUtils::addField_groupStart($form);


        $form->addValue('fields', self::getField_type());


        $field = CoreFormUtils::addField_textline
        (
            $form, 'value', CoreConfig::MIMOTO_FORM_INPUTVALIDATION.'--value',
            'Value', 'Enter the value', 'Enter the corresponding value on which should be checked'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'errorMessage', CoreConfig::MIMOTO_FORM_INPUTVALIDATION.'--errorMessage',
            'Error message', 'Enter an error message', 'Describe the problem to the user'
        );

        $form->addValue('fields', self::getField_trigger());

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }

    /**
     * Get field: type
     */
    private static function getField_type()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::COREFORM_FORM_INPUTVALIDATION, 'type');
        $field->setValue('label', 'Type');
        $field->setValue('description', 'Define the type of the validation rule');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_FORM_INPUTVALIDATION, 'type');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_FORM_INPUTVALIDATION.'--type_value_options-maxchars');
        $option->setValue('label', 'Maximum amount of charaters');
        $option->setValue('value', 'maxchars');
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_FORM_INPUTVALIDATION.'--type_value_options-minchars');
        $option->setValue('label', 'Minimum amount of charaters');
        $option->setValue('value', 'minchars');
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_FORM_INPUTVALIDATION.'--type_value_options-regex_custom');
        $option->setValue('label', 'Regular expression');
        $option->setValue('value', 'regex_custom');
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_FORM_INPUTVALIDATION.'--type_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Get field: trigger
     */
    private static function getField_trigger()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::COREFORM_FORM_INPUTVALIDATION, 'trigger');
        $field->setValue('label', 'Trigger');
        $field->setValue('description', 'Define when the rule needs to be applied'); // #todo - needs multiselect support

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_FORM_INPUTVALIDATION, 'trigger');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_FORM_INPUTVALIDATION.'--type_value_options-maxchars');
        $option->setValue('label', 'On submit');
        $option->setValue('value', 'onSubmit');
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_FORM_INPUTVALIDATION.'--type_value_options-minchars');
        $option->setValue('label', 'While typing');
        $option->setValue('value', 'onChange');
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_FORM_INPUTVALIDATION.'--tirgger_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

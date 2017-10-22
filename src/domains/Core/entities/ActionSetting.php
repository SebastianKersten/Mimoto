<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\Validation;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * ActionSetting
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ActionSetting
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ACTION_SETTING,
            // ---
            'name' => CoreConfig::MIMOTO_ACTION_SETTING,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_ACTION_SETTING],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ACTION_SETTING.'--key',
                    // ---
                    'name' => 'key',
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
                    'id' => CoreConfig::MIMOTO_ACTION_SETTING.'--value',
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
                )
            ]
        );
    }

    public static function getData() {}




    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ACTION_SETTING,
            'name' => CoreConfig::MIMOTO_ACTION_SETTING,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_ACTION_SETTING, 'key'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_ACTION_SETTING, 'value')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_ACTION_SETTING, true);

        // setup
        CoreFormUtils::addField_title($form, 'Action setting', 'Configure the service', "Pass action specific settings to the service being called");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_ACTION_SETTING.'--key',
            'Key', 'Enter the key', ''
        );
        self::setKeyValidation($field);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'value', CoreConfig::MIMOTO_ACTION_SETTING.'--value',
            'Value', 'Enter the value', ''
        );

        // send
        return $form;
    }


    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Set name validation
     */
    private static function setKeyValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_ACTION_SETTING.'--key_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\Validation;
use Mimoto\Event\ConditionalTypes;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * ActionProperty
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ActionConditional
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ACTION_CONDITIONAL,
            // ---
            'name' => CoreConfig::MIMOTO_ACTION_CONDITIONAL,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_ACTION_CONDITIONAL],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ACTION_CONDITIONAL.'--entityProperty',
                    // ---
                    'name' => 'entityProperty',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_ENTITYPROPERTY
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ACTION_CONDITIONAL.'--type',
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
                    'id' => CoreConfig::MIMOTO_ACTION_CONDITIONAL.'--value1',
                    // ---
                    'name' => 'value1',
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
                    'id' => CoreConfig::MIMOTO_ACTION_CONDITIONAL.'--value2',
                    // ---
                    'name' => 'value2',
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

    public static function getData($sInstanceId = null)
    {
        // 1. init
        $aData = [];

        // 2. send
        return $aData;
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
            'id' => CoreConfig::MIMOTO_ACTION_CONDITIONAL,
            'name' => CoreConfig::MIMOTO_ACTION_CONDITIONAL,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_ACTION_CONDITIONAL, 'value')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_ACTION_CONDITIONAL, true);

        // setup
        CoreFormUtils::addField_title($form, 'Action property', 'Configure the trigger', "Only execute if this condional");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'event', CoreConfig::MIMOTO_ACTION_CONDITIONAL.'--event',
            'Event', 'Enter the event', ''
        );
        self::setKeyValidation($field);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'value', CoreConfig::MIMOTO_ACTION_CONDITIONAL.'--value',
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
        $validationRule->setId(CoreConfig::MIMOTO_ACTION_CONDITIONAL.'--key_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

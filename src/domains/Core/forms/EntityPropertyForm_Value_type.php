<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;


/**
 * EntityPropertyForm_Value_type
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyForm_Value_type
{

    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE,
            'name' => CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE, 'type')
            ]
        );
    }

    /**
     * Get structure
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE, true);

        // setup
        CoreFormUtils::addField_title($form, 'Configure');
        CoreFormUtils::addField_groupStart($form);

        $form->addValue('fields', self::getField_type());

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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ENTITYPROPERTYSETTING, 'value');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.CoreConfig::DATA_VALUE_TEXTLINE);
        $option->setValue('label', CoreConfig::DATA_VALUE_TEXTLINE);
        $option->setValue('value', CoreConfig::DATA_VALUE_TEXTLINE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.CoreConfig::DATA_VALUE_TEXTBLOCK);
        $option->setValue('label', CoreConfig::DATA_VALUE_TEXTBLOCK);
        $option->setValue('value', CoreConfig::DATA_VALUE_TEXTBLOCK);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN);
        $option->setValue('label', MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN);
        $option->setValue('value', MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME);
        $option->setValue('label', MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME);
        $option->setValue('value', MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD);
        $option->setValue('label', MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD);
        $option->setValue('value', MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.MimotoEntityPropertyValueTypes::VALUETYPE_JSON);
        $option->setValue('label', MimotoEntityPropertyValueTypes::VALUETYPE_JSON);
        $option->setValue('value', MimotoEntityPropertyValueTypes::VALUETYPE_JSON);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.CoreConfig::DATA_VALUE_TEXTLINE.'|'.CoreConfig::DATA_VALUE_TEXTBLOCK.'|'.MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN.'|'.MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME.'|'.MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD.'|'.MimotoEntityPropertyValueTypes::VALUETYPE_JSON.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

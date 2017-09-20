<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;


/**
 * EntityPropertyForm_Value_defaultValue
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyForm_Value_defaultValue
{

    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_DEFAULTVALUE,
            'name' => CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_DEFAULTVALUE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_DEFAULTVALUE, 'type')
            ]
        );
    }

    /**
     * Get structure
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_DEFAULTVALUE, true);

        // setup
        CoreFormUtils::addField_title($form, 'Default value');
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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_DEFAULTVALUE, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ENTITYPROPERTYSETTING, 'type');

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_DEFAULTVALUE.'--type_value_options-none');
        $option->setValue('label', 'None');
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_SETTING_DEFAULTVALUE_TYPE_NONE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_DEFAULTVALUE.'--type_value_options-currentTimestamp');
        $option->setValue('label', 'Current timestamp');
        $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_SETTING_DEFAULTVALUE_TYPE_CURRENTTIMESTAMP);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_DEFAULTVALUE.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.MimotoEntityPropertyTypes::PROPERTY_SETTING_DEFAULTVALUE_TYPE_NONE.'|'.MimotoEntityPropertyTypes::PROPERTY_SETTING_DEFAULTVALUE_TYPE_CURRENTTIMESTAMP.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }
}

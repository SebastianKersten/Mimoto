<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
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
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE);

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

        // 3. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--value');
        $field->setValue('value', $connectedEntityProperty);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.CoreConfig::DATA_VALUE_TEXTLINE);
        $option->setValue('key', CoreConfig::DATA_VALUE_TEXTLINE);
        $option->setValue('value', CoreConfig::DATA_VALUE_TEXTLINE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.CoreConfig::DATA_VALUE_TEXTBLOCK);
        $option->setValue('key', CoreConfig::DATA_VALUE_TEXTBLOCK);
        $option->setValue('value', CoreConfig::DATA_VALUE_TEXTBLOCK);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.CoreConfig::DATA_VALUE_BOOLEAN);
        $option->setValue('key', CoreConfig::DATA_VALUE_BOOLEAN);
        $option->setValue('value', CoreConfig::DATA_VALUE_BOOLEAN);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.CoreConfig::DATA_VALUE_TEXTLINE.'|'.CoreConfig::DATA_VALUE_TEXTBLOCK.'|'.CoreConfig::DATA_VALUE_BOOLEAN.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

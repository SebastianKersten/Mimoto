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
            'id' => CoreConfig::MIMOTO_SELECTIONRULE,
            // ---
            'name' => CoreConfig::MIMOTO_SELECTIONRULE,
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_SELECTIONRULE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTIONRULE.'--type',
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
                    'id' => CoreConfig::COREFORM_SELECTIONRULE.'--entity',
                    // ---
                    'name' => 'entity',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_ENTITY
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
            'id' => CoreConfig::COREFORM_SELECTIONRULE,
            'name' => CoreConfig::COREFORM_SELECTIONRULE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_SELECTIONRULE, 'type'),
                //CoreFormUtils::composeFieldName(CoreConfig::COREFORM_SELECTIONRULE, 'entity'),
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_SELECTIONRULE);

        // setup
        CoreFormUtils::addField_title($form, 'Selection rule', '', "Configure a selection rule to select specific sets of data.");
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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::COREFORM_SELECTIONRULE, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_SELECTIONRULE, 'type');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::MIMOTO_SELECTIONRULE.'--type_value_options-value');
        $option->setValue('label', 'Child of');
        $option->setValue('value', SelectionRuleTypes::CHILDOF);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::MIMOTO_SELECTIONRULE.'--type_value_options-entity');
        $option->setValue('label', 'Type');
        $option->setValue('value', SelectionRuleTypes::TYPE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::MIMOTO_SELECTIONRULE.'--type_value_options-collection');
        $option->setValue('label', 'Instance');
        $option->setValue('value', SelectionRuleTypes::INSTANCE);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_SELECTIONRULE.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.SelectionRuleTypes::CHILDOF.'|'.SelectionRuleTypes::TYPE.'|'.SelectionRuleTypes::INSTANCE.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }


}

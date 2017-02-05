<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
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

        $field = CoreFormUtils::addField_textline
        (
            $form, 'type', CoreConfig::MIMOTO_FORM_INPUTVALIDATION.'--type',
            'Type', '#todo - Needs to be a dropdown!!!', 'The label should be unique'
        );

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

        $field = CoreFormUtils::addField_textline
        (
            $form, 'trigger', CoreConfig::MIMOTO_FORM_INPUTVALIDATION.'--trigger',
            'Trigger', '#todo - Needs to be a dropdown/radiobutton!!!', 'Define when the rule needs to be applied'
        );

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }
}

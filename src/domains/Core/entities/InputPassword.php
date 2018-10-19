<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputTextline
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputPassword
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_PASSWORD,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_PASSWORD,
            'visualName' => 'Password',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::MIMOTO_FORM_INPUT_PASSWORD],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_PASSWORD.'--label',
                    // ---
                    'name' => 'label',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_PASSWORD.'--description',
                    // ---
                    'name' => 'description',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_PASSWORD.'--placeholder',
                    // ---
                    'name' => 'placeholder',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => EntityConfig::SETTING_VALUE_TYPE,
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
            'id' => CoreConfig::MIMOTO_FORM_INPUT_PASSWORD,
            'name' => CoreConfig::MIMOTO_FORM_INPUT_PASSWORD,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORM_INPUT_PASSWORD, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORM_INPUT_PASSWORD, 'description'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORM_INPUT_PASSWORD, 'placeholder'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORM_INPUT_PASSWORD, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORM_INPUT_PASSWORD, 'options'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_FORM_INPUT_PASSWORD, 'validation')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm($eInputPassword = null)
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_FORM_INPUT_PASSWORD, true);

        // setup
        CoreFormUtils::addField_title($form, 'Password');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_PASSWORD.'--label',
            'Label', 'Enter the input\'s label', 'Clarify what is required from the content editor'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::MIMOTO_FORM_INPUT_PASSWORD.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_PASSWORD.'--description',
            'Description',
            'Enter a description',
            'Clarify what is required from the content editor'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'placeholder', CoreConfig::MIMOTO_FORM_INPUT_PASSWORD.'--placeholder',
            'Placeholder',
            'Enter a placeholder',
            'Clarify what is required from the content editor'
        );

        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form, $eInputPassword);

        // send
        return $form;
    }

}

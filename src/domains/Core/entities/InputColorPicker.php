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
 * InputColorPicker
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputColorPicker
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER,
            'visualName' => 'ColorPicker',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_COLORPICKER],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER.'--label',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER.'--description',
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
            'id' => CoreConfig::COREFORM_INPUT_COLORPICKER,
            'name' => CoreConfig::COREFORM_INPUT_COLORPICKER,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_COLORPICKER, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_COLORPICKER, 'description'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_COLORPICKER, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_COLORPICKER, 'options'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_COLORPICKER, 'validation')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm($eInputColorPicker = null)
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUT_COLORPICKER, true);

        // setup
        CoreFormUtils::addField_title($form, 'ColorPicker');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER.'--label',
            'Label', 'Enter the input\'s label', 'Clarify what is required from the content editor'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER.'--description',
            'Description',
            'Enter a description',
            'Clarify what is required from the content editor'
        );

        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form, $eInputColorPicker);

        // send
        return $form;
    }

}

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
class InputTextline
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
            'visualName' => 'Textline',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_TEXTLINE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--label',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--description',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--placeholder',
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
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--prefix',
                    // ---
                    'name' => 'prefix',
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
            'id' => CoreConfig::COREFORM_INPUT_TEXTLINE,
            'name' => CoreConfig::COREFORM_INPUT_TEXTLINE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTLINE, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTLINE, 'description'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTLINE, 'placeholder'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTLINE, 'prefix'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTLINE, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTLINE, 'options'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTLINE, 'validation')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUT_TEXTLINE);

        // setup
        CoreFormUtils::addField_title($form, 'Textline');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--label',
            'Label', 'Enter the input\'s label', 'Clarify what is required from the content editor'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--description',
            'Description',
            'Enter a description',
            'Clarify what is required from the content editor'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'placeholder', CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--placeholder',
            'Placeholder',
            'Enter a placeholder',
            'Clarify what is required from the content editor'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'prefix', CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--prefix',
            'Prefix', 'Enter a prefix',
            'Clarify what is required from the content editor'
        );

        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form);

        // send
        return $form;
    }

}

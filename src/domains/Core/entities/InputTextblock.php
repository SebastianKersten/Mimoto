<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputTextblock
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputTextblock
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK,
            'visualName' => 'Textblock',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_TEXTBLOCK],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--description-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--placeholder',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'placeholder',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--placeholder-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
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
            'id' => CoreConfig::COREFORM_INPUT_TEXTBLOCK,
            'name' => CoreConfig::COREFORM_INPUT_TEXTBLOCK,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTBLOCK, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTBLOCK, 'description'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTBLOCK, 'placeholder'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTBLOCK, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTBLOCK, 'options'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_TEXTBLOCK, 'validation')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm($eInputTextblock = null)
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUT_TEXTBLOCK);

        // setup
        CoreFormUtils::addField_title($form, 'Textline');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--label',
            'Label', 'Enter the input\'s label', 'Clarify what is required from the content editor'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--description',
            'Description',
            'Enter a description',
            'Clarify what is required from the content editor'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'placeholder', CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK.'--placeholder',
            'Placeholder',
            'Enter a placeholder',
            'Clarify what is required from the content editor'
        );

        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form, $eInputTextblock);

        // send
        return $form;
    }

}

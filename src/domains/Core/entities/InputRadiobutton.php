<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreFormUtils;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputRadioButton
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputRadioButton
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON,
            'visualName' => 'Radiobutton',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_RADIOBUTTON],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'--label',
                    // ---
                    'name' => 'label',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'--description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
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
            'id' => CoreConfig::COREFORM_INPUT_RADIOBUTTON,
            'name' => CoreConfig::COREFORM_INPUT_RADIOBUTTON,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_RADIOBUTTON, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_RADIOBUTTON, 'description'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_RADIOBUTTON, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_RADIOBUTTON, 'options'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_RADIOBUTTON, 'validation')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUT_RADIOBUTTON);

        // setup
        CoreFormUtils::addField_title($form, 'Radiobutton');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'--label',
            'Label', 'Enter the input\'s label', 'Clearly describe the field\'s purpose'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'--description',
            'Description', 'Enter a description', 'If needed, add additional explaination regarding the input field'
        );

        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form, true);

        // send
        return $form;
    }

}

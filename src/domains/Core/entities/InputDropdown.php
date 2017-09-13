<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputDropdown
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputDropdown
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN,
            'visualName' => 'Dropdown',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_DROPDOWN],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--description_type',
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
            'id' => CoreConfig::COREFORM_INPUT_DROPDOWN,
            'name' => CoreConfig::COREFORM_INPUT_DROPDOWN,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_DROPDOWN, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_DROPDOWN, 'description'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_DROPDOWN, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_DROPDOWN, 'options'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_DROPDOWN, 'validation')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm($eInputDropdown = null)
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUT_DROPDOWN, true);

        // setup
        CoreFormUtils::addField_title($form, 'Dropdown');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--label',
            'Label', 'Enter the input\'s label', 'Clearly describe the field\'s purpose'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--description',
            'Description', 'Enter a description', 'If needed, add additional explaination regarding the input field'
        );

        CoreFormUtils::addField_optionsForListConfig($form);

        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form, $eInputDropdown);

        // send
        return $form;
    }

}

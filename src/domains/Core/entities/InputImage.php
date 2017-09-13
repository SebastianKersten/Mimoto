<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputImage
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputImage
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_IMAGE,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_IMAGE,
            'visualName' => 'Image',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_IMAGE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_IMAGE.'--label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_IMAGE.'--label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_IMAGE.'--description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_IMAGE.'--description-type',
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
            'id' => CoreConfig::COREFORM_INPUT_IMAGE,
            'name' => CoreConfig::COREFORM_INPUT_IMAGE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_IMAGE, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_IMAGE, 'description')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm($eInputImage = null)
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUT_IMAGE, true);

        // setup
        CoreFormUtils::addField_title($form, 'Image');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_IMAGE.'--label',
            'Label',
            'Enter the label',
            'Enter a good describing label for the input field'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::COREFORM_INPUT_IMAGE.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_IMAGE.'--description',
            'Description',
            'Enter a description',
            'Clarify what is required from the content editor'
        );

        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form, $eInputImage);

        // send
        return $form;
    }

}

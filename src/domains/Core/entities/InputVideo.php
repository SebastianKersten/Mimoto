<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputVideo
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputVideo
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_VIDEO,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_VIDEO,
            'visualName' => 'Video',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_VIDEO],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_VIDEO.'--label',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_VIDEO.'--description',
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
            'id' => CoreConfig::COREFORM_INPUT_VIDEO,
            'name' => CoreConfig::COREFORM_INPUT_VIDEO,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_VIDEO, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_VIDEO, 'description'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_VIDEO, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_VIDEO, 'options'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUT_VIDEO, 'validation')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm($eInputVideo = null)
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUT_VIDEO, true);

        // setup
        CoreFormUtils::addField_title($form, 'Video');
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUT_VIDEO.'--label',
            'Label', 'Enter the input\'s label', 'Clarify what is required from the content editor'
        );
        CoreFormUtils::setLabelValidation($field, CoreConfig::MIMOTO_FORM_INPUT_VIDEO.'--label');

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_VIDEO.'--description',
            'Description',
            'Enter a description',
            'Clarify what is required from the content editor'
        );

        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form, $eInputVideo);

        // send
        return $form;
    }

}

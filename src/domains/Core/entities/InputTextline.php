<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityConfig;
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
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
            'visualName' => 'Textline',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_TEXTLINE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => MimotoEntityConfig::SETTING_VALUE_TYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--description-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => MimotoEntityConfig::SETTING_VALUE_TYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--placeholder',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'placeholder',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--placeholder-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => MimotoEntityConfig::SETTING_VALUE_TYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--prefix',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'prefix',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--prefix-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => MimotoEntityConfig::SETTING_VALUE_TYPE,
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

        $field = CoreFormUtils::addField_textline
        (
            $form, 'description', CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--description',
            'Label',
            'Enter the input\'s description',
            'Clarify what is required from the content editor'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'placeholder', CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--placeholder',
            'Label',
            'Enter the input\'s placeholder',
            'Clarify what is required from the content editor'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'prifix', CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--prefix',
            'Prefix', 'Enter the input\'s prefix',
            'Clarify what is required from the content editor'
        );

        CoreFormUtils::addField_groupEnd($form);

        // add value input
        CoreFormUtils::addFieldsValueInput($form);

        // send
        return $form;
    }

}

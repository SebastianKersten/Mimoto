<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputOption
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputOption
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUTOPTION,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUTOPTION,
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_FORM_INPUTOPTION],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTOPTION.'--label',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUTOPTION.'--value',
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
                    'id' => CoreConfig::MIMOTO_FORM_INPUTOPTION.'--form',
                    // ---
                    'name' => 'form',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => 'value',
                            'value' => CoreConfig::MIMOTO_FORM
                        )
                    ]
                ),
                // mapping
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
            'id' => CoreConfig::COREFORM_FORM_INPUTOPTION,
            'name' => CoreConfig::COREFORM_FORM_INPUTOPTION,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_FORM_INPUTOPTION, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_FORM_INPUTOPTION, 'value')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_FORM_INPUTOPTION);

        // setup
        CoreFormUtils::addField_title($form, 'Option', '', "Entities are composed of 'properties'. Add properties to your entity and decide what type they are. A property can have three types: <i>value</i>, <i>entity</i> or <i>collection</i>");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_INPUTOPTION.'--label',
            'Label', 'Describe the value that is being presented', 'The label should be unique'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'value', CoreConfig::MIMOTO_FORM_INPUTOPTION.'--value',
            'Value', 'Enter the value that is presented', 'The value should be unique'
        );

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }

}

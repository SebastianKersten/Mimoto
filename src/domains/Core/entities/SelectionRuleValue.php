<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;
use Mimoto\Selection\SelectionRuleTypes;


/**
 * SelectionRuleValue
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SelectionRuleValue
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_SELECTION_RULE_VALUE,
            // ---
            'name' => CoreConfig::MIMOTO_SELECTION_RULE_VALUE,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_SELECTION_RULE_VALUE],
            'properties' => [

                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE_VALUE.'--propertyName',
                    // ---
                    'name' => 'propertyName',
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
                    'id' => CoreConfig::MIMOTO_SELECTION_RULE_VALUE.'--value',
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
                )
            ]
        );
    }

    public static function getData()
    {

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
            'id' => CoreConfig::MIMOTO_SELECTION_RULE_VALUE,
            'name' => CoreConfig::MIMOTO_SELECTION_RULE_VALUE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE_VALUE, 'propertyName'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SELECTION_RULE_VALUE, 'value'),
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_SELECTION_RULE_VALUE);

        // setup
        CoreFormUtils::addField_title($form, 'Selection rule value', '', "Define the required property value");

        $field = CoreFormUtils::addField_textline
        (
            $form, 'propertyName', CoreConfig::MIMOTO_SELECTION_RULE_VALUE.'--propertyName',
            'Property name', 'Property name', 'Add the property name'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'value', CoreConfig::MIMOTO_SELECTION_RULE_VALUE.'--value',
            'Value', 'Value', ''
        );


        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------




}

<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * LayoutContainer
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ComponentContainer
{
    
    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_COMPONENT_CONTAINER,
            // ---
            'name' => CoreConfig::MIMOTO_COMPONENT_CONTAINER,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_COMPONENT_CONTAINER],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT_CONTAINER.'--name',
                    // ---
                    'name' => 'name',
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
            'id' => CoreConfig::MIMOTO_COMPONENT_CONTAINER,
            'name' => CoreConfig::MIMOTO_COMPONENT_CONTAINER,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_COMPONENT_CONTAINER, 'name')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_COMPONENT_CONTAINER, true);

        // setup
        CoreFormUtils::addField_title($form, 'Container', 'Use containers to setup layouts with which you can buid pages.');

        CoreFormUtils::addField_groupStart($form);
        $form->addValue('fields', $field = self::getField_name());
        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;


    }


    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get field: type
     */
    private static function getField_name()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE, CoreConfig::MIMOTO_COMPONENT_CONTAINER, 'name');
        $field->setValue('label', 'Name');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_COMPONENT_CONTAINER, 'name');

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_COMPONENT_CONTAINER.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', '1');
        $validationRule->setValue('errorMessage', "Please enter the container's name");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

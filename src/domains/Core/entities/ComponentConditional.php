<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * ComponentConditional
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ComponentConditional
{

    const ENTITY_TYPE = 'entityType';
    const PROPERTY_VALUE = 'propertyValue';


    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_COMPONENT_CONDITIONAL,
            // ---
            'name' => CoreConfig::MIMOTO_COMPONENT_CONDITIONAL,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_COMPONENT_CONDITIONAL],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--type',
                    // ---
                    'name' => 'type',
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
                    'id' => CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--entityType',
                    // ---
                    'name' => 'entityType',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_ENTITY
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--entityProperty',
                    // ---
                    'name' => 'entityProperty',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_ENTITYPROPERTY
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--value',
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
            'id' => CoreConfig::MIMOTO_COMPONENT_CONDITIONAL,
            'name' => CoreConfig::MIMOTO_COMPONENT_CONDITIONAL,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL, 'entityProperty'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL, 'value')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL);

        // setup
        CoreFormUtils::addField_title($form, 'Component conditional', 'The component conditional is a powerful feature to render a collection with multiple types of items (think of for instance a feed with different article types), all with different templates but for you as a developer still only <u>one</u> line of code!');

        CoreFormUtils::addField_groupStart($form);
        $form->addValue('fields', $field = self::getField_type());
        CoreFormUtils::addField_groupEnd($form);


        CoreFormUtils::addField_groupStart($form, 'Settings for entity type', 'group_entityType');
        $form->addValue('fields', $field = self::getField_entityType());
        CoreFormUtils::addField_groupEnd($form, 'group_entityType');


        CoreFormUtils::addField_groupStart($form, 'Settings for property value', 'group_propertyValue');

        $field = self::getField_entityProperty();
        $form->addValue('fields', $field);
        //self::setEntityPropertyValidation($field);


        $field = CoreFormUtils::addField_textline
        (
            $form, 'value', CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--value',
            'Value', 'The property\'s value', 'Enter the value you would like to check'
        );
        //self::setValueValidation($field);

        CoreFormUtils::addField_groupEnd($form, 'group_propertyValue');

        // send
        return $form;


    }


    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get field: type
     */
    private static function getField_type()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::MIMOTO_COMPONENT_CONDITIONAL, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_COMPONENT_CONDITIONAL, 'type');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--type_value_option-entityType');
        $option->setValue('label', ComponentConditional::ENTITY_TYPE);
        $option->setValue('value', ComponentConditional::ENTITY_TYPE);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--type_value_option-propertyValue');
        $option->setValue('label', ComponentConditional::PROPERTY_VALUE);
        $option->setValue('value', ComponentConditional::PROPERTY_VALUE);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.ComponentConditional::ENTITY_TYPE.'|'.ComponentConditional::PROPERTY_VALUE.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Get field: entityType
     */
    private static function getField_entityType()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::COREFORM_ENTITY, 'entityType');
        $field->setValue('label', 'Entity type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_COMPONENT_CONDITIONAL, 'entityType');



        // 1. use core selection with exclusion of current



        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_ENTITY]);

        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            //output('$entity->getValue(\'name\')', $entity->getValue('name'));
            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
            $option->setId(CoreConfig::COREFORM_ENTITY.'--entityType_value_options-valuesettings-collection-'.$entity->getId());
            $option->setValue('value', $entity->getEntityTypeName().'.'.$entity->getId());
            $option->setValue('label', $entity->getValue('name'));
            $field->addValue('options', $option);
        }

        // send
        return $field;
    }



    /**
     * Get field: entityProperty
     */
    private static function getField_entityProperty()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::MIMOTO_COMPONENT_CONDITIONAL, 'entityProperty');
        $field->setValue('label', 'The property');
        $field->setValue('description', "Select the property you want to connect");

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_COMPONENT_CONDITIONAL, 'entityProperty');


        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_ENTITY]);
        $nEntityCount = count($aEntities);
        for ($nEntityIndex = 0; $nEntityIndex < $nEntityCount; $nEntityIndex++)
        {
            // register
            $entity = $aEntities[$nEntityIndex];

            // read
            $aEntityProperties = $entity->getValue('properties');
            $nEntityPropertyCount = count($aEntityProperties);
            for ($nEntityPropertyIndex = 0; $nEntityPropertyIndex < $nEntityPropertyCount; $nEntityPropertyIndex++)
            {
                // register
                $entityProperty = $aEntityProperties[$nEntityPropertyIndex];

                // compose
                $sLabel = $entity->getValue('name').'.'.$entityProperty->getValue('name');


                $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--entityProperty_value_options-valuesettings-collection-'.$entityProperty->getId());
                $option->setValue('label', $sLabel);
                $option->setValue('value', $entityProperty->getEntityTypeName().'.'.$entityProperty->getId());

                $field->addValue('options', $option);
            }
        }

        // send
        return $field;
    }

    /**
     * Set entityProperty validation
     */
    private static function setEntityPropertyValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--entityProperty_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Please select one of the properties");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }


    /**
     * Set value validation
     */
    private static function setValueValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_COMPONENT_CONDITIONAL.'--value_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^[a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'Value can only contain the characters [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

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

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_COMPONENTCONDITIONAL,
            // ---
            'name' => CoreConfig::MIMOTO_COMPONENTCONDITIONAL,
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_COMPONENTCONDITIONAL],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENTCONDITIONAL.'--entityProperty',
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
                    'id' => CoreConfig::MIMOTO_COMPONENTCONDITIONAL.'--value',
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
            'id' => CoreConfig::COREFORM_COMPONENTCONDITIONAL,
            'name' => CoreConfig::COREFORM_COMPONENTCONDITIONAL,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_COMPONENTCONDITIONAL, 'entityProperty'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_COMPONENTCONDITIONAL, 'value')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_COMPONENTCONDITIONAL);

        // setup
        CoreFormUtils::addField_title($form, 'Component conditional', 'The component conditional is a powerful feature to render a collection with multiple types of items (think of for instance a feed with different article types), all with different templates but for you as a developer still only <u>one</u> line of code!');
        CoreFormUtils::addField_groupStart($form);

        $field = self::getField_entityProperty();
        $form->addValue('fields', $field);
        self::setEntityPropertyValidation($field);


        $field = CoreFormUtils::addField_textline
        (
            $form, 'value', CoreConfig::MIMOTO_COMPONENTCONDITIONAL.'--value',
            'Value', 'The property\'s value', 'Enter the value you would like to check'
        );
        self::setValueValidation($field);

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;


    }


    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get field: entityProperty
     */
    private static function getField_entityProperty()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::COREFORM_COMPONENTCONDITIONAL, 'entityProperty');
        $field->setValue('label', 'The property');
        $field->setValue('description', "Select the property you want to connect");

        // 2. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_COMPONENTCONDITIONAL.'--entityProperty');
        $field->setValue('value', $connectedEntityProperty);

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


                $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
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
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_COMPONENTCONDITIONAL.'--entityProperty_value_validation1');
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
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_COMPONENTCONDITIONAL.'--value_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^[a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'Value can only contain the characters [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

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
class LayoutContainer
{
    
    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_LAYOUTCONTAINER,
            // ---
            'name' => CoreConfig::MIMOTO_LAYOUTCONTAINER,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_LAYOUTCONTAINER],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_LAYOUTCONTAINER.'--name',
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
            'id' => CoreConfig::MIMOTO_LAYOUTCONTAINER,
            'name' => CoreConfig::MIMOTO_LAYOUTCONTAINER,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_LAYOUTCONTAINER, 'name')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_LAYOUTCONTAINER);

        // setup
        CoreFormUtils::addField_title($form, 'Layout container', 'The layout container is a container for components and is used for buiding pages.');

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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE, CoreConfig::MIMOTO_LAYOUTCONTAINER, 'name');
        $field->setValue('label', 'Name');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_LAYOUTCONTAINER, 'name');

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_LAYOUTCONTAINER.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', '1');
        $validationRule->setValue('errorMessage', "Please enter the container's name");
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
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_LAYOUTCONTAINER, 'entityType');



        // 1. use core selection with exclusion of current



        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_ENTITY]);

        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            //output('$entity->getValue(\'name\')', $entity->getValue('name'));
            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::MIMOTO_LAYOUTCONTAINER, 'entityProperty');
        $field->setValue('label', 'The property');
        $field->setValue('description', "Select the property you want to connect");

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_LAYOUTCONTAINER, 'entityProperty');


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
        $validationRule->setId(CoreConfig::MIMOTO_LAYOUTCONTAINER.'--entityProperty_value_validation1');
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
        $validationRule->setId(CoreConfig::MIMOTO_LAYOUTCONTAINER.'--value_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^[a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'Value can only contain the characters [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

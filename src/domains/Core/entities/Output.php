<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * Output
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Output
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_OUTPUT,
            // ---
            'name' => CoreConfig::MIMOTO_OUTPUT,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_OUTPUT],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITY.'--layout',
                    // ---
                    'name' => 'layout',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_LAYOUT
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_OUTPUT.'--selection',
                    // ---
                    'name' => 'selection',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_SELECTION
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_OUTPUT.'--containers',
                    // ---
                    'name' => 'containers',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_OUTPUT_CONTAINER]
                        ),
                        'allowDuplicates' => (object) array(
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
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
            'id' => CoreConfig::MIMOTO_OUTPUT,
            'name' => CoreConfig::MIMOTO_OUTPUT,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_OUTPUT, 'component'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_OUTPUT, 'selection'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_OUTPUT, 'containers')
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
//        // init
//        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_ENTITY);
//
//        // setup
//        CoreFormUtils::addField_title($form, 'Entity', '', "The core element of data is called an 'entity'. Entities are the data objects that contain a certain set of properties, for instance <i>Person</i> containing a <i>name</i> and a <i>date of birth</i>");
//        CoreFormUtils::addField_groupStart($form);
//
//        $field = CoreFormUtils::addField_textline
//        (
//            $form, 'name', CoreConfig::MIMOTO_ENTITY.'--name',
//            'Name', 'Entity name', 'The entity name should be unique'
//        );
//        self::setNameValidation($field);
//
////        $form->addValue('fields', self::getField_extends());
////
////        CoreFormUtils::addField_checkbox
////        (
////            $form, 'isAbstract', CoreFormUtils::composeFieldName(CoreConfig::COREFORM_ENTITY, 'isAbstract'),
////            'Configuration',
////            'Skip dedicated table for this entity'
////        );
//
//        CoreFormUtils::addField_groupEnd($form);
//
//        // send
//        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Set name validation
     */
    private static function setNameValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITY.'--name_value_validation2');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The entity name can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // validation rule #2
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITY.'--name_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^[a-z][a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'Name should be in lowerCamelCase, starting with a letter followed by [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Get field: extends
     */
    private static function getField_extends()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::COREFORM_ENTITY, 'extends');
        $field->setValue('label', 'Extend other entity');
        $field->setValue('description', "Inherit that entity's properties");

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ENTITY, 'extends');


        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_ENTITY]);

        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            //output('$entity->getValue(\'name\')', $entity->getValue('name'));
            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
            $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--extends_value_options-valuesettings-collection-'.$entity->getId());
            $option->setValue('key', $entity->getEntityTypeName().'.'.$entity->getId());
            $option->setValue('value', $entity->getValue('name'));
            $field->addValue('options', $option);
        }

        // send
        return $field;
    }

}

<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\Validation;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * Action
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Action
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ACTION,
            // ---
            'name' => CoreConfig::MIMOTO_ACTION,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_ACTION],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ACTION.'--title',
                    // ---
                    'name' => 'title',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        ),
                        'validation' => (object) array(
                            'type' => Validation::UNIQUE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ACTION.'--entity',
                    // ---
                    'name' => 'entity',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_ENTITY
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ACTION.'--event',
                    // ---
                    'name' => 'event',
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
                    'id' => CoreConfig::MIMOTO_ACTION.'--conditionals',
                    // ---
                    'name' => 'conditionals',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_ACTION_CONDITIONAL]
                        ),
                        'allowDuplicates' => (object) array(
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ACTION.'--service',
                    // ---
                    'name' => 'service',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_SERVICE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ACTION.'--function',
                    // ---
                    'name' => 'function',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_SERVICE_FUNCTION
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ACTION.'--settings',
                    // ---
                    'name' => 'settings',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_ACTION_SETTING]
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

    public static function getData() {}




    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_ACTION,
            'name' => CoreConfig::MIMOTO_ACTION,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_ACTION, 'name')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_ACTION, true);

        // setup
        CoreFormUtils::addField_title($form, 'Action', '', "Add an action to a data event (CREATED, CHANGED or DELETED) to add functionality to your project");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'title', CoreConfig::MIMOTO_ACTION.'--title',
            'Title', 'Action title', 'The action title should be unique to avoid confusion'
        );

        $form->addValue('fields', self::getField_entities());

        $form->addValue('fields', self::getField_eventType());

        $form->addValue('fields', self::getField_services());

        // send
        return $form;
    }


    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get field: entities
     */
    private static function getField_entities()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::MIMOTO_ACTION, 'entity');
        $field->setValue('label', 'Entity');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ACTION, 'entity');


        // load
        $aEntities = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_ENTITY]);

        $nEntityCount = count($aEntities);
        for ($nEntityIndex = 0; $nEntityIndex < $nEntityCount; $nEntityIndex++)
        {
            // register
            $eEntity = $aEntities[$nEntityIndex];

            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
            $option->setId(CoreConfig::MIMOTO_ACTION.'--entity-options-'.$eEntity->getId());
            $option->setValue('label', $eEntity->getValue('name'));
            $option->setValue('value', $eEntity->getEntityTypeName().'.'.$eEntity->getId());
            $field->addValue('options', $option);
        }

//        // validation rule #1
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
//        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE.'--allowedEntityType_value_validation1');
//        $validationRule->setValue('type', 'minchars');
//        $validationRule->setValue('value', 1);
//        $validationRule->setValue('errorMessage', "Value can't be empty");
//        $validationRule->setValue('trigger', 'submit');
//        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }


    /**
     * Get field: type
     */
    private static function getField_eventType()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::MIMOTO_ACTION, 'event');
        $field->setValue('label', 'Event');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ACTION, 'event');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-value');
        $option->setValue('label', 'Created');
        $option->setValue('value', CoreConfig::DATA_EVENT_CREATED);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-entity');
        $option->setValue('label', 'Updated');
        $option->setValue('value', CoreConfig::DATA_EVENT_UPDATED);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-collection');
        $option->setValue('label', 'Deleted');
        $option->setValue('value', CoreConfig::DATA_EVENT_DELETED);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.CoreConfig::DATA_EVENT_CREATED.'|'.CoreConfig::DATA_EVENT_UPDATED.'|'.CoreConfig::DATA_EVENT_DELETED.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }


    /**
     * Get field: services
     */
    private static function getField_services()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::MIMOTO_ACTION, 'service');
        $field->setValue('label', 'Service');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ACTION, 'service');


        // load
        $aServices = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_SERVICE]);

        $nServiceCount = count($aServices);
        for ($nServiceIndex = 0; $nServiceIndex < $nServiceCount; $nServiceIndex++)
        {
            // register
            $eService = $aServices[$nServiceIndex];

            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
            $option->setId(CoreConfig::MIMOTO_ACTION.'--service-options-'.$eService->getId());
            $option->setValue('label', $eService->getValue('name'));
            $option->setValue('value', $eService->getEntityTypeName().'.'.$eService->getId());
            $field->addValue('options', $option);
        }

//        // validation rule #1
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
//        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE.'--allowedEntityType_value_validation1');
//        $validationRule->setValue('type', 'minchars');
//        $validationRule->setValue('value', 1);
//        $validationRule->setValue('errorMessage', "Value can't be empty");
//        $validationRule->setValue('trigger', 'submit');
//        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }


}

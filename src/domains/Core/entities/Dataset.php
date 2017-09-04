<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * Dataset
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Dataset
{
    const TYPE_ITEM = 'item';
    const TYPE_GROUP = 'group';


    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_DATASET,
            // ---
            'name' => CoreConfig::MIMOTO_DATASET,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_DATASET],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_DATASET.'--name',
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
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_DATASET.'--form',
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
                (object) array(
                    'id' => CoreConfig::MIMOTO_DATASET.'--isHiddenFromMenu',
                    // ---
                    'name' => 'isHiddenFromMenu',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_DATASET.'--type',
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
                    'id' => CoreConfig::MIMOTO_DATASET.'--contentItem',
                    // ---
                    'name' => 'contentItem',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => null
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_DATASET.'--contentItems',
                    // ---
                    'name' => 'contentItems',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => []
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
            'id' => CoreConfig::MIMOTO_DATASET,
            'name' => CoreConfig::MIMOTO_DATASET,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_DATASET, 'name'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_DATASET, 'type'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_DATASET, 'form'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_DATASET, 'isHiddenFromMenu')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_DATASET);

        // setup
        CoreFormUtils::addField_title($form, 'Dataset', '', "With datasets you allow different groups of users to enter content via the CMS. Datasets are added to the side menu by default but can be hidden if their only purpose is to use them as centralized helper values.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_DATASET.'--name',
            'Name', 'Enter the name', 'The content name is preferably unique'
        );
        self::setNameValidation($field);

        $form->addValue('fields', self::getField_type());
        $form->addValue('fields', self::getField_form());

        CoreFormUtils::addField_checkbox
        (
            $form, 'isHiddenFromMenu', CoreConfig::MIMOTO_DATASET.'--isHiddenFromMenu',
            'Visibility',
            'Hide from menu'
        );

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
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
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITY.'--name_value_validation2');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The section name can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Get field: type
     */
    private static function getField_type()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::MIMOTO_DATASET, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_DATASET, 'type');


        // 3b. set options
        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::MIMOTO_DATASET.'--type_value_options-item');
        $option->setValue('value', Dataset::TYPE_ITEM);
        $option->setValue('label', 'Item');
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::MIMOTO_DATASET.'--type_value_options-group');
        $option->setValue('value', Dataset::TYPE_GROUP);
        $option->setValue('label', 'Group');
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_DATASET.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.Dataset::TYPE_ITEM.'|'.Dataset::TYPE_GROUP.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Get field: extends
     */
    private static function getField_form()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::MIMOTO_DATASET, 'form');
        $field->setValue('label', 'Form');
        $field->setValue('description', "What form would you like to use?");

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_DATASET, 'form');


        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_FORM]);

        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            //output('$entity->getValue(\'name\')', $entity->getValue('name'));
            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
            $option->setId(CoreConfig::MIMOTO_DATASET.'--form_value_options-valuesettings-collection-'.$entity->getId());
            $option->setValue('value', $entity->getEntityTypeName().'.'.$entity->getId());
            $option->setValue('label', $entity->getValue('name'));
            $field->addValue('options', $option);
        }

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_DATASET.'--form_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Please select a form");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * ContentSection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ContentSection
{
    const TYPE_ITEM = 'item';
    const TYPE_GROUP = 'group';


    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_CONTENTSECTION,
            // ---
            'name' => CoreConfig::MIMOTO_CONTENTSECTION,
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_CONTENTSECTION],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--name',
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
                    'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--form',
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
                    'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--isHiddenFromMenu',
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
                    'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--type',
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
                    'id' => CoreConfig::MIMOTO_ENTITY.'--contentItem',
                    // ---
                    'name' => 'contentItem',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::WILDCARD
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITY.'--contentItems',
                    // ---
                    'name' => 'contentItems',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::WILDCARD]
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
            'id' => CoreConfig::COREFORM_CONTENTSECTION,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_CONTENTSECTION, 'name'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_CONTENTSECTION, 'type'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_CONTENTSECTION, 'form'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_CONTENTSECTION, 'isHiddenFromMenu')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_CONTENTSECTION);

        // setup
        CoreFormUtils::addField_title($form, 'Content section', '', "With content sections you allow different groups of users to enter actual content via the CMS. Content sections are added to the side menu by default but can be hidden if their only purpose is to use them as centralized helper values.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_CONTENTSECTION.'--name',
            'Name', 'Enter the name', 'The content name is preferably unique'
        );
        self::setNameValidation($field);

        $form->addValue('fields', self::getField_type());
        $form->addValue('fields', self::getField_form());

        CoreFormUtils::addField_checkbox
        (
            $form, 'isHiddenFromMenu', CoreConfig::MIMOTO_CONTENTSECTION.'--isHiddenFromMenu',
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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::COREFORM_CONTENTSECTION, 'type');
        $field->setValue('label', 'Type');

        // 3a. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--type');
        $field->setValue('value', $connectedEntityProperty);

        // 3b. set options
        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--type_value_options-value');
        $option->setValue('key', ContentSection::TYPE_ITEM);
        $option->setValue('value', 'Item');
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $option->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--type_value_options-entity');
        $option->setValue('key', ContentSection::TYPE_GROUP);
        $option->setValue('value', 'Group');
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.ContentSection::TYPE_ITEM.'|'.ContentSection::TYPE_GROUP.')$');
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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::COREFORM_CONTENTSECTION, 'form');
        $field->setValue('label', 'Form');
        $field->setValue('description', "What form would you like to use?");

        // 2. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--form');
        $field->setValue('value', $connectedEntityProperty);

        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_FORM]);

        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            //output('$entity->getValue(\'name\')', $entity->getValue('name'));
            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
            $option->setId(CoreConfig::COREFORM_CONTENTSECTION.'--form_value_options-valuesettings-collection-'.$entity->getId());
            $option->setValue('key', $entity->getEntityTypeName().'.'.$entity->getId());
            $option->setValue('value', $entity->getValue('name'));
            $field->addValue('options', $option);
        }

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_CONTENTSECTION.'--form_value_validation2');
        $validationRule->setValue('key', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Please select a form");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

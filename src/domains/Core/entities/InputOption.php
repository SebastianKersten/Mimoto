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

    const VALUE = 'value';
    const FORM = 'form';
    const SELECTION = 'selection';


    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_FIELD_OPTION,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_FIELD_OPTION,
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_INPUTOPTION],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--label',
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
                    'id' => CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--type',
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
                    'id' => CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--value',
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
                    'id' => CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--form',
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
                    'id' => CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--selection',
                    // ---
                    'name' => 'selection',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => 'value',
                            'value' => CoreConfig::MIMOTO_SELECTION
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--mappingLabel',
                    // ---
                    'name' => 'mappingLabel',
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
                    'id' => CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--mappingValue',
                    // ---
                    'name' => 'mappingValue',
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
            'id' => CoreConfig::COREFORM_INPUTOPTION,
            'name' => CoreConfig::COREFORM_INPUTOPTION,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUTOPTION, 'label'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUTOPTION, 'type'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUTOPTION, 'value'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUTOPTION, 'form'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_INPUTOPTION, 'selection')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_INPUTOPTION, true);

        // setup
        CoreFormUtils::addField_title($form, 'Option', '', "Entities are composed of 'properties'. Add properties to your entity and decide what type they are. A property can have three types: <i>value</i>, <i>entity</i> or <i>collection</i>");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'label', CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--label',
            'Label', 'Describe the value that is being presented', 'The label should be unique'
        );

        $form->addValue('fields', self::getField_type());

        CoreFormUtils::addField_groupEnd($form);


        // --- value


        CoreFormUtils::addField_groupStart($form, 'Settings for the value type', 'group_value');
        $field = CoreFormUtils::addField_textline
        (
            $form, 'value', CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--value',
            'Value', 'Enter the value that is presented', 'The value should be unique'
        );
        CoreFormUtils::addField_groupEnd($form, 'group_value');

        // --- form

        CoreFormUtils::addField_groupStart($form, 'Settings for the form type', 'group_form');
        $form->addValue('fields', self::getField_form());
        CoreFormUtils::addField_groupEnd($form, 'group_form');


        // --- selection

        CoreFormUtils::addField_groupStart($form, 'Settings for the selection type', 'group_selection');

        $form->addValue('fields', self::getField_selection());


        $field = CoreFormUtils::addField_textline
        (
            $form, 'mappingLabel', CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--mappingLabel',
            'Mapping label', 'Which property do you want to use as a label', 'Only use value properties'
        );

        $field = CoreFormUtils::addField_textline
        (
            $form, 'mappingValue', CoreConfig::MIMOTO_FORM_FIELD_OPTION.'--mappingValue',
            'Mapping value', 'Which property do you want to use as the value', 'Only use value properties'
        );

        CoreFormUtils::addField_groupEnd($form, 'group_selection');

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
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::COREFORM_INPUTOPTION, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_FORM_FIELD_OPTION, 'type');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_INPUTOPTION.'--type_value_options-value');
        $option->setValue('label', 'A new value');
        $option->setValue('value', InputOption::VALUE); // ?? is deze nodig?
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_INPUTOPTION.'--type_value_options-form');
        $option->setValue('label', 'Create a list item using a form');
        $option->setValue('value', InputOption::FORM);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::COREFORM_INPUTOPTION.'--type_value_options-selection');
        $option->setValue('label', 'Select from existing items');
        $option->setValue('value', InputOption::SELECTION);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.InputOption::VALUE.'|'.InputOption::FORM.'|'.InputOption::SELECTION.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Get field: form
     */
    private static function getField_form()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::COREFORM_INPUTOPTION, 'form');
        $field->setValue('label', 'Form');
        $field->setValue('description', "What form would you like to use?");

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_FORM_FIELD_OPTION, 'form');


        // load
        $aEntities = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_FORM]);

        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
            $option->setId(CoreConfig::COREFORM_INPUTOPTION.'--form_value_options-valuesettings-collection-'.$entity->getId());
            $option->setValue('value', $entity->getEntityTypeName().'.'.$entity->getId());
            $option->setValue('label', $entity->getValue('name'));
            $field->addValue('options', $option);
        }

        // send
        return $field;
    }

    /**
     * Get field: form
     */
    private static function getField_selection()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, CoreConfig::COREFORM_INPUTOPTION, 'selection');
        $field->setValue('label', 'Selection');
        $field->setValue('description', "What selection would you like to use?");

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_FORM_FIELD_OPTION, 'selection');


        // load
        $aSelections = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_SELECTION]);

        $nSelectionCount = count($aSelections);
        for ($nSelectionIndex = 0; $nSelectionIndex < $nSelectionCount; $nSelectionIndex++)
        {
            // register
            $entity = $aSelections[$nSelectionIndex];

            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
            $option->setId(CoreConfig::COREFORM_INPUTOPTION.'--selection_value_options-'.$entity->getId());
            $option->setValue('value', $entity->getEntityTypeName().'.'.$entity->getId());
            $option->setValue('label', $entity->getValue('name'));
            $field->addValue('options', $option);
        }

        // send
        return $field;
    }

}

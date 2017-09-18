<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * Selection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Selection
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_SELECTION,
            // ---
            'name' => CoreConfig::MIMOTO_SELECTION,
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_SELECTION],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_SELECTION.'--name',
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
                    'id' => CoreConfig::MIMOTO_SELECTION.'--rules',
                    // ---
                    'name' => 'rules',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_SELECTION_RULE]
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
        // 1. set value
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
            'id' => CoreConfig::COREFORM_SELECTION,
            'name' => CoreConfig::COREFORM_SELECTION,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_SELECTION, 'name'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_SELECTION, 'rules'),
            ]
        );
    }


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_SELECTION);

        // setup
        CoreFormUtils::addField_title($form, 'Selection', '', "Use selections to find specific predefined sets of data. Selections are cached, so by using them you profoundly improve performance as opposed to direct database queries.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_SELECTION.'--name',
            'Name', 'Selection name', 'The selection name should be unique'
        );
        self::setNameValidation($field);

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
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_SELECTION.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "The entity name can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // validation rule #2
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_SELECTION.'--name_value_validation2');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^[a-z][a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'Name should be in lowerCamelCase, starting with a letter followed by [a-zA-Z0-9-_]');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

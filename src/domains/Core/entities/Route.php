<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * Route
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Route
{

    public static function getStructure()
    {
        return (object) array
        (
            'id' => CoreConfig::MIMOTO_PAGE,
            // ---
            'name' => CoreConfig::MIMOTO_PAGE,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_PAGE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_PAGE.'--name',
                    // ---
                    'name' => 'name',
                    'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_PAGE.'--path',
                    // ---
                    'name' => 'path',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_PATH_ELEMENT]
                        ),
                        'allowDuplicates' => (object) array(
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_PAGE.'--output',
                    // ---
                    'name' => 'output',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_OUTPUT
                        ),
                        'defaultValue' => (object) array(
                            'key' => EntityConfig::SETTING_ENTITY_DEFAULTVALUE,
                            'type' => MimotoEntityPropertyTypes::PROPERTY_SETTING_DEFAULTVALUE_TYPE_NEWENTITYINSTANCE,
                            'value' => CoreConfig::MIMOTO_OUTPUT,
                            'defaultValues' => (object) array(
                                'isRoot' => CoreConfig::DATA_VALUE_TRUE
                            )
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_PAGE.'--allowedUserRoles',
                    // ---
                    'name' => 'allowedUserRoles',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_USER_ROLE]
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



    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_PAGE,
            'name' => CoreConfig::MIMOTO_PAGE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_PAGE, 'name')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_PAGE, true);

        // setup
        CoreFormUtils::addField_title($form, 'Page', '', "");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_PAGE.'--name',
            'Name', "The page name", ''
        );
        self::setNameValidation($field);


        CoreFormUtils::addField_groupEnd($form);


        // --- permissions

        CoreFormUtils::addField_groupStart($form, 'Permissions', 'permissions');

        CoreFormUtils::addUserRolesTofield($form, CoreConfig::MIMOTO_PAGE, 'allowedUserRoles');

        CoreFormUtils::addField_groupEnd($form, 'permissions');


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
        $validationRule->setId(CoreConfig::MIMOTO_PAGE.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

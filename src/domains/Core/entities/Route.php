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
            'id' => CoreConfig::MIMOTO_ROUTE,
            // ---
            'name' => CoreConfig::MIMOTO_ROUTE,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_ROUTE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_ROUTE.'--name',
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
                    'id' => CoreConfig::MIMOTO_ROUTE.'--path',
                    // ---
                    'name' => 'path',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT]
                        ),
                        'allowDuplicates' => (object) array(
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ROUTE.'--output',
                    // ---
                    'name' => 'output',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::MIMOTO_OUTPUT
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ROUTE.'--allowedUserRoles',
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
            'id' => CoreConfig::MIMOTO_ROUTE,
            'name' => CoreConfig::MIMOTO_ROUTE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_ROUTE, 'name')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_ROUTE);

        // setup
        CoreFormUtils::addField_title($form, 'Page', '', "");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_ROUTE.'--name',
            'Name', "The page name", ''
        );
        self::setNameValidation($field);


        CoreFormUtils::addField_groupEnd($form);


        // --- permissions

        CoreFormUtils::addField_groupStart($form, 'Permissions', 'permissions');

        $form->addValue('fields', self::getField_UserRoles());

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
        $validationRule->setId(CoreConfig::MIMOTO_ROUTE.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }


    /**
     * Get field: user roles
     */
    private static function getField_userRoles()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT, CoreConfig::MIMOTO_ROUTE, 'allowedUserRoles');
        $field->setValue('label', 'User roles');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_ROUTE, 'allowedUserRoles');


        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_USER_ROLE]);


        //if (Mimoto::user()->hasRole('superuser'))
        {
            $aCoreUserRoles = [
                (object)array('label' => 'Mimoto Superuser', 'id' => CoreConfig::MIMOTO_USER_ROLE . '-superuser')
            ];

            $nCoreUserRoleCount = count($aCoreUserRoles);
            for ($nCoreUserRoleIndex = 0; $nCoreUserRoleIndex < $nCoreUserRoleCount; $nCoreUserRoleIndex++) {
                // register
                $coreUserRole = $aCoreUserRoles[$nCoreUserRoleIndex];

                // load
                $entity = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER_ROLE, $coreUserRole->id);

                // store
                $aEntities[] = $entity;
            }
        }


        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
            $option->setId(CoreConfig::MIMOTO_ROUTE.'--allowedUserRoles_value_options-'.$entity->getId());
            $option->setValue('label', $entity->getValue('name'));
            $option->setValue('value', $entity->getEntityTypeName().'.'.$entity->getId());
            $field->addValue('options', $option);
        }

        // send
        return $field;
    }

}

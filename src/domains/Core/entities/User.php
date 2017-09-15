<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * User
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class User
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_USER,
            // ---
            'name' => CoreConfig::MIMOTO_USER,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_USER],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_USER.'--firstName',
                    // ---
                    'name' => 'firstName',
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
                    'id' => CoreConfig::MIMOTO_USER.'--lastName',
                    // ---
                    'name' => 'lastName',
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
                    'id' => CoreConfig::MIMOTO_USER.'--email',
                    // ---
                    'name' => 'email',
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
                    'id' => CoreConfig::MIMOTO_USER.'--password', // #todo add encryption-delegate to field
                    // ---
                    'name' => 'password',
                    'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_PASSWORD
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_USER.'--avatar',
                    // ---
                    'name' => 'avatar',
                    'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY,
                    'subtype' => MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'key' => 'allowedEntityType',
                            'type' => 'value',
                            'value' => CoreConfig::MIMOTO_FILE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_USER.'--roles',
                    // ---
                    'name' => 'roles',
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
                ),
//                (object) array(
//                    'id' => CoreConfig::MIMOTO_USER.'--settings',
//                    // ---
//                    'name' => 'settings',
//                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
//                    'settings' => [
//                        'allowedEntityTypes' => (object) array(
//                            'key' => 'allowedEntityTypes',
//                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
//                            'value' => [CoreConfig::MIMOTO_USER_SETTING]
//                        ),
//                        'allowDuplicates' => (object) array(
//                            'key' => 'allowDuplicates',
//                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
//                            'value' => CoreConfig::DATA_VALUE_FALSE
//                        )
//                    ]
//                )
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
            'id' => CoreConfig::MIMOTO_USER,
            'name' => CoreConfig::MIMOTO_USER,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_USER, 'firstName'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_USER, 'lastName'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_USER, 'email'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_USER, 'password'),
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_USER, 'avatar')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm($eUser = null)
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_USER, true);

        // setup
        CoreFormUtils::addField_title($form, 'User', '', "");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'firstName', CoreConfig::MIMOTO_USER.'--firstName',
            'First name', "The user's first name", ''
        );
        self::setNameValidation($field);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'lastName', CoreConfig::MIMOTO_USER.'--lastName',
            'Last name', "The user's last name", ''
        );
        self::setNameValidation($field);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'email', CoreConfig::MIMOTO_USER.'--email',
            'Email', "Enter the user's email address", 'Also functions as the username'
        );
        self::setEmailValidation($field);

        $field = CoreFormUtils::addField_password
        (
            $form, 'password', CoreConfig::MIMOTO_USER.'--password',
            'Password', "Please enter a password", 'Use a strong password for better security'
        );

        $field = CoreFormUtils::addField_image
        (
            $form, 'avatar', CoreConfig::MIMOTO_USER.'--avatar',
            'Avatar'
        );

        CoreFormUtils::addField_groupEnd($form);


        // --- permissions

        CoreFormUtils::addField_groupStart($form, 'Permissions', 'permissions');

        $form->addValue('fields', self::getField_userRoles($eUser));

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
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_USER.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Set file validation
     */
    private static function setEmailValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_USER.'--file_value_validation1');
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
    private static function getField_userRoles($eUser = null)
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT, CoreConfig::MIMOTO_USER, 'roles');
        $field->setValue('label', 'User roles');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_USER, 'roles');


        // init
        $selection = Mimoto::service('selection')->create();

        // setup
        $selection->setType(CoreConfig::MIMOTO_USER_ROLE);
        //$selection->setValue('name', 'author');


        if (Mimoto::user()->hasRole('owner') || Mimoto::user()->hasRole('superuser') || Mimoto::user()->hasRole('admin') || self::userHasRole($eUser, 'contenteditor'))
        {
            // init
            $aCoreUserRoleIds = [CoreConfig::MIMOTO_USER_ROLE.'-contenteditor'];

            // verify
            if (Mimoto::user()->hasRole('owner') || Mimoto::user()->hasRole('superuser') || self::userHasRole($eUser, 'admin'))
            {
                // add permissions
                array_push($aCoreUserRoleIds, CoreConfig::MIMOTO_USER_ROLE.'-admin');

                // verify
                if (Mimoto::user()->hasRole('owner') || self::userHasRole($eUser, 'superuser'))
                {
                    // add permissions
                    array_push($aCoreUserRoleIds, CoreConfig::MIMOTO_USER_ROLE.'-superuser');

                    // verify
                    if (Mimoto::user()->hasRole('owner'))
                    {
                        // add permissions
                        array_push($aCoreUserRoleIds, CoreConfig::MIMOTO_USER_ROLE.'-owner');
                    }
                }
            }

            $nCoreUserRoleIdCount = count($aCoreUserRoleIds);
            for ($nCoreUserRoleIdIndex = 0; $nCoreUserRoleIdIndex < $nCoreUserRoleIdCount; $nCoreUserRoleIdIndex++)
            {
                // register
                $coreUserRoleId = $aCoreUserRoleIds[$nCoreUserRoleIdIndex];

                // add core user roles
                $rule = $selection->addRule();

                // setup
                $rule->setType(CoreConfig::MIMOTO_USER_ROLE);
                $rule->setId($coreUserRoleId);
            }
        }


        // load
        $aEntities = Mimoto::service('data')->select($selection);

        // add options
        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
            $option->setId(CoreConfig::MIMOTO_USER.'--roles_value_options-'.$entity->getId());
            $option->setValue('label', $entity->getValue('name'));
            $option->setValue('value', $entity->getEntityTypeName().'.'.$entity->getId());
            $field->addValue('options', $option);
        }

        // send
        return $field;
    }


    private static function userHasRole($eUser, $sRole)
    {
        // 1. init
        $bHasRole = false;

        // 2. validate
        if (empty($eUser)) return $bHasRole;


        // ---


        // 3. read
        $aRoles = $eUser->getValue('roles');

        // 4. find
        $nRoleCount = count($aRoles);
        for ($nRoleIndex = 0; $nRoleIndex < $nRoleCount; $nRoleIndex++)
        {
            // register
            $eRole = $aRoles[$nRoleIndex];

            // verify
            if ($eRole->getValue('name') == $sRole)
            {
                // toglle
                $bHasRole = true;
                break;
            }
        }

        // 5. send
        return $bHasRole;
    }
}

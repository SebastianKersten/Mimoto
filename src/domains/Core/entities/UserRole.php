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
class UserRole
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_USER_ROLE,
            // ---
            'name' => CoreConfig::MIMOTO_USER_ROLE,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_USER_ROLE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_USER_ROLE.'--name',
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
                )
            ]
        );
    }


    public static function getData($sItemId)
    {
        // init
        $aData = [];

        // inline
        $aData[CoreConfig::MIMOTO_USER_ROLE.'-owner'] = (object) array('name' => 'owner');
        $aData[CoreConfig::MIMOTO_USER_ROLE.'-superuser'] = (object) array('name' => 'superuser');
        $aData[CoreConfig::MIMOTO_USER_ROLE.'-admin'] = (object) array('name' => 'admin');
        $aData[CoreConfig::MIMOTO_USER_ROLE.'-contenteditor'] = (object) array('name' => 'contenteditor');

        // send
        return $aData[$sItemId];
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
            'id' => CoreConfig::MIMOTO_USER_ROLE,
            'name' => CoreConfig::MIMOTO_USER_ROLE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_USER_ROLE, 'name'),
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_USER_ROLE);

        // setup
        CoreFormUtils::addField_title($form, 'User role', '', "");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_USER_ROLE.'--name',
            'Name', "The role's name", ''
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
        $validationRule->setId(CoreConfig::MIMOTO_USER_ROLE.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

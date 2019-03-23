<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\Validation;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * ServiceFunction
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ServiceFunction
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_SERVICE_FUNCTION,
            // ---
            'name' => CoreConfig::MIMOTO_SERVICE_FUNCTION,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_SERVICE_FUNCTION],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_SERVICE_FUNCTION.'--name',
                    // ---
                    'name' => 'name',
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
                )
            ]
        );
    }

    public static function getData($sInstanceId)
    {
        // 1. init
        $aData = [];

        // 2. ServiceFunction: Data.create
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Data-create')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_SERVICE_FUNCTION);
            $eInstance->setId(CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Data-create');
            $eInstance->set('name', 'create');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 3. ServiceFunction: Data.update
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Data-update')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_SERVICE_FUNCTION);
            $eInstance->setId(CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Data-update');
            $eInstance->set('name', 'update');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 4. ServiceFunction: Data.delete
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Data-delete')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_SERVICE_FUNCTION);
            $eInstance->setId(CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Data-delete');
            $eInstance->set('name', 'delete');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 4. ServiceFunction: Slack.sendMessage
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Slack-sendMessage')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_SERVICE_FUNCTION);
            $eInstance->setId(CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Slack-sendMessage');
            $eInstance->set('name', 'sendMessage');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 5. ServiceFunction: SendGrid.sendMail
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_SERVICE_FUNCTION.'-SendGridService-sendMail')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_SERVICE_FUNCTION);
            $eInstance->setId(CoreConfig::MIMOTO_SERVICE_FUNCTION.'-SendGridService-sendMail');
            $eInstance->set('name', 'sendMail');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 6. send
        return $aData;
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
            'id' => CoreConfig::MIMOTO_SERVICE_FUNCTION,
            'name' => CoreConfig::MIMOTO_SERVICE_FUNCTION,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SERVICE_FUNCTION, 'name')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_SERVICE_FUNCTION, true);

        // setup
        CoreFormUtils::addField_title($form, 'Service function', '', "Register a function that can be called when a certain data change triggers an action");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_SERVICE_FUNCTION.'--name',
            'Name', 'Function name', 'The function name that is part of the Service'
        );
        self::setNameValidation($field);

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
        $validationRule->setId(CoreConfig::MIMOTO_SERVICE_FUNCTION.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

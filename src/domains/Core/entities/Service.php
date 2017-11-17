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
 * Service
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Service
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_SERVICE,
            // ---
            'name' => CoreConfig::MIMOTO_SERVICE,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_SERVICE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_SERVICE.'--name',
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
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_SERVICE.'--file',
                    // ---
                    'name' => 'file',
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
                    'id' => CoreConfig::MIMOTO_SERVICE.'--functions',
                    // ---
                    'name' => 'functions',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_SERVICE_FUNCTION]
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

    public static function getData($sInstanceId = null)
    {
        // 1. init
        $aData = [];

        // 2. Service: Data
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_SERVICE.'-Data')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_SERVICE);
            $eInstance->setId(CoreConfig::MIMOTO_SERVICE.'-Data');
            $eInstance->set('name', 'Data');
            $eInstance->set('file', 'Data/Data.php');
            $eInstance->add('functions', ServiceFunction::getData(CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Data-create'));
            $eInstance->add('functions', ServiceFunction::getData(CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Data-update'));
            $eInstance->add('functions', ServiceFunction::getData(CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Data-delete'));

            // e. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 3. Service: Slack
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_SERVICE.'-Slack')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_SERVICE);
            $eInstance->setId(CoreConfig::MIMOTO_SERVICE.'-Slack');
            $eInstance->set('name', 'Slack');
            $eInstance->set('file', 'Slack/Slack.php');
            $eInstance->add('functions', ServiceFunction::getData(CoreConfig::MIMOTO_SERVICE_FUNCTION.'-Slack-sendMessage'));

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 4. send
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
            'id' => CoreConfig::MIMOTO_SERVICE,
            'name' => CoreConfig::MIMOTO_SERVICE,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_SERVICE, 'name')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_SERVICE, true);

        // setup
        CoreFormUtils::addField_title($form, 'Service', '', "To add automation flows to your project it's possible to add custom services that can add intelligence to your basic data actions.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_SERVICE.'--name',
            'Name', 'Service name', 'The service name should be unique to avoid confusion'
        );
        self::setNameValidation($field);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'file', CoreConfig::MIMOTO_SERVICE.'--file',
            'File', 'your-service-file.php', 'Enter the name of the service file', Mimoto::value('ProjectConfig.serviceroot')
        );
        self::setFileValidation($field);

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
        $validationRule->setId(CoreConfig::MIMOTO_SERVICE.'--name_value_validation1');
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
    private static function setFileValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_SERVICE.'--file_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

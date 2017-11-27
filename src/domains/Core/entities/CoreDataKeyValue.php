<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
use Mimoto\Core\Validation;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;
use Mimoto\Event\ConditionalTypes;


/**
 * CoreDataKeyValue
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CoreDataKeyValue
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_COREDATA_KEYVALUE,
            // ---
            'name' => CoreConfig::MIMOTO_COREDATA_KEYVALUE,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_COREDATA_KEYVALUE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_COREDATA_KEYVALUE.'--label',
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
                    'id' => CoreConfig::MIMOTO_COREDATA_KEYVALUE.'--key',
                    // ---
                    'name' => 'key',
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
                    'id' => CoreConfig::MIMOTO_COREDATA_KEYVALUE.'--value',
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
                )
            ]
        );
    }

    public static function getData($sInstanceId = null)
    {
        // 1. init
        $aData = [];


        // --- events ---


        // 2. Event: CREATED
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-event-CREATED')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-event-CREATED');
            $eInstance->set('label', 'Created');
            $eInstance->set('key', 'created');
            $eInstance->set('value', 'created');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 3. Event: UPDATED
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-event-UPDATED')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-event-UPDATED');
            $eInstance->set('label', 'Updated');
            $eInstance->set('key', 'updated');
            $eInstance->set('value', 'updated');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 4. Event: DELETED
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-event-DELETED')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-event-DELETED');
            $eInstance->set('label', 'Deleted');
            $eInstance->set('key', 'deleted');
            $eInstance->set('value', 'deleted');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }



        // --- action conditionals ---


        // 5. Conditional type: CHANGED
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED)
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED);
            $eInstance->set('label', 'Changed');
            $eInstance->set('key', ConditionalTypes::CHANGED);
            $eInstance->set('value', ConditionalTypes::CHANGED);

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 6. Conditional type: CHANGED_INTO
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED_INTO)
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED_INTO);
            $eInstance->set('label', 'Changed into');
            $eInstance->set('key', ConditionalTypes::CHANGED_INTO);
            $eInstance->set('value', ConditionalTypes::CHANGED_INTO);

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 7. Conditional type: CHANGED_FROM
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED_FROM)
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED_FROM);
            $eInstance->set('label', 'Changed from');
            $eInstance->set('key', ConditionalTypes::CHANGED_FROM);
            $eInstance->set('value', ConditionalTypes::CHANGED_FROM);

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 8. Conditional type: CHANGED_FROM_INTO
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED_FROM_INTO)
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED_FROM_INTO);
            $eInstance->set('label', 'Changed from .. into ..');
            $eInstance->set('key', ConditionalTypes::CHANGED_FROM_INTO);
            $eInstance->set('value', ConditionalTypes::CHANGED_FROM_INTO);

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 9. Conditional type: EQUALS
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::EQUALS)
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::EQUALS);
            $eInstance->set('label', 'Equals');
            $eInstance->set('key', ConditionalTypes::EQUALS);
            $eInstance->set('value', ConditionalTypes::EQUALS);

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 10. Conditional type: DOES_NOT_EQUAL
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::DOES_NOT_EQUAL)
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::DOES_NOT_EQUAL);
            $eInstance->set('label', 'Does not equal');
            $eInstance->set('key', ConditionalTypes::DOES_NOT_EQUAL);
            $eInstance->set('value', ConditionalTypes::DOES_NOT_EQUAL);

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 11. Conditional type: CONTAINS
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CONTAINS)
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CONTAINS);
            $eInstance->set('label', 'Contains');
            $eInstance->set('key', ConditionalTypes::CONTAINS);
            $eInstance->set('value', ConditionalTypes::CONTAINS);

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 12. Conditional type: DID_NOT_CHANGE
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::DID_NOT_CHANGE)
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::DID_NOT_CHANGE);
            $eInstance->set('label', 'Did not change');
            $eInstance->set('key', ConditionalTypes::DID_NOT_CHANGE);
            $eInstance->set('value', ConditionalTypes::DID_NOT_CHANGE);

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }


        // 13. send
        return $aData;
    }

}

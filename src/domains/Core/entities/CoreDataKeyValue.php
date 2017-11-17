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

        // 2. Service: Data
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-events-CREATED')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-events-CREATED');
            $eInstance->set('label', 'Created');
            $eInstance->set('key', 'created');
            $eInstance->set('value', 'created');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 3. Service: Data
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-events-UPDATED')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-events-UPDATED');
            $eInstance->set('label', 'Updated');
            $eInstance->set('key', 'updated');
            $eInstance->set('value', 'updated');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 4. Service: Data
        if (empty($sInstanceId) || $sInstanceId == CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-events-DELETED')
        {
            // a. init
            $eInstance = Mimoto::service('data')->create(CoreConfig::MIMOTO_COREDATA_KEYVALUE);
            $eInstance->setId(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-events-DELETED');
            $eInstance->set('label', 'Deleted');
            $eInstance->set('key', 'deleted');
            $eInstance->set('value', 'deleted');

            // b. add or send
            if (empty($sInstanceId)) $aData[] = $eInstance;
            else return $eInstance;
        }

        // 5. send
        return $aData;
    }

}

<?php


// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\EntityConfig\EntityConfigTableUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


class CoreData // extends MimotoService
{

    public function __construct()
    {
//        $this->setServiceName('CoreData');
//        $this->setVendorName('Mimoto');
//        $this->setVersion('1.0');
    }


    public function createEntityTable(MimotoEntity $eInstance, $settings = null)
    {
        // 1. read
        $sTableName = $this->getTablePrefix($eInstance).$eInstance->getValue('name');

        // 2. check if entity table name is unique
        if (!EntityConfigTableUtils::tableNameIsUnique($sTableName))
        {
            Mimoto::service('log')->error("Duplicate table name", "Table '$sTableName' already exists", true);
        }

        // 3. create table
        if (!EntityConfigTableUtils::createEntityTable($sTableName))
        {
            Mimoto::service('log')->error("Table creation issue", "Error while creating table for '$sTableName'", true);
        }

        // 4. cleanup cache
        EntityConfigTableUtils::flushEntityConfigCache();
    }

    public function renameEntityTable(MimotoEntity $eInstance, $settings = null)
    {
        // 1. register
        $sPreviousTableName = $this->getTablePrefix($eInstance).$eInstance->getValue('name', false, true);
        $sNewTableName = $this->getTablePrefix($eInstance).$eInstance->getValue('name');

        // 2. check if entity table name is unique
        if (!EntityConfigTableUtils::tableNameIsUnique($sNewTableName))
        {
            Mimoto::service('log')->error("Duplicate table name", "Table '$sNewTableName' for entity '$sPreviousTableName' already exists", true);
        }

        // 3. rename table
        if (!EntityConfigTableUtils::renameEntityTable($sPreviousTableName, $sNewTableName))
        {
            Mimoto::service('log')->error("Entity table rename issue", "Error while renaming entity table from '$sPreviousTableName' to '$sNewTableName'", true);
        }

        // 4. cleanup cache
        EntityConfigTableUtils::flushEntityConfigCache();
    }

    public function deleteEntityTable(MimotoEntity $eInstance, $settings = null)
    {
        // 1. read
        $sTableName = $this->getTablePrefix($eInstance).$eInstance->getValue('name');

        // 2. delete table
        if (!EntityConfigTableUtils::deleteEntityTable($sTableName))
        {
            Mimoto::service('log')->error("Error deleting table", "Can't delete table '$sTableName'", true);
        }

        // 3. cleanup cache
        EntityConfigTableUtils::flushEntityConfigCache();
    }


    public function addEntityPropertyColumn(MimotoEntity $eInstance, $settings = null)
    {
        // 1. check if changes were made
        if (!$eInstance->hasChanges()) return;

        // 2. read changes
        $aChanges = $eInstance->getChanges();

        // 3. check if any properties were changed
        if (isset($aChanges['properties']))
        {
            // 4a. add columns
            if (isset($aChanges['properties']->added))
            {
                $nConnectionCount = count($aChanges['properties']->added);
                for ($nConnectionIndex = 0; $nConnectionIndex < $nConnectionCount; $nConnectionIndex++)
                {
                    // register
                    $connection = $aChanges['properties']->added[$nConnectionIndex];

                    // load property
                    $eEntityProperty = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $connection->getChildId());


                    // 1. toggle on type
                    switch($eEntityProperty->getValue('type'))
                    {
                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                            $this->createValuePropertySettings($eEntityProperty);
                            break;

                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                        case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE:
                        case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO:
                        case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_AUDIO:
                        case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_FILE:

                            $this->createEntityPropertySettings($eEntityProperty);
                            break;

                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                            $this->createCollectionPropertySettings($eEntityProperty);
                            break;
                    }


                    if ($eEntityProperty->getValue('type') == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
                    {
                        // load
                        $sColumnType = $this->getColumnTypeFromSetting($eEntityProperty);

                        // search
                        $sColumnOnTheLeft = $this->getColumnOntheLeft($eInstance, $eEntityProperty->getValue('name'));

                        // add
                        EntityConfigTableUtils::addPropertyColumnToEntityTable($eInstance->getValue('name'), $eEntityProperty->getValue('name'), $sColumnType, $sColumnOnTheLeft);
                    }
                }
            }
        }

        // 7. cleanup cache
        EntityConfigTableUtils::flushEntityConfigCache();
    }

    public function updateEntityPropertyColumn(MimotoEntity $eInstance, $settings = null)
    {
        // 1. verify
        if ($eInstance->getValue('type') != MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) return; // #todo - only action if type = value

        // 2. check if changes were made
        if (!$eInstance->hasChanges()) return;

        // 3. read changes
        $aChanges = $eInstance->getChanges();

        // 4. check if name was changed
        if (!isset($aChanges['name'])) return;

        // 5. register
        $sOldPropertyName = $eInstance->getValue('name', false, true);
        $sNewPropertyName = $eInstance->getValue('name');

        // 6. get parent entity
        $eParent = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--properties', $eInstance);

        // 7. check if parentEntity is known (something to do with store and acceptChanges)
        if (empty($eParent)) return;

        // 8 verify
        if ($eInstance->getValue('type') != MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) return;

        // 9. determinde
        $sColumnType = $this->getColumnTypeFromSetting($eInstance);

        // 10. rename
        EntityConfigTableUtils::renamePropertyColumn($this->getTablePrefix($eParent).$eParent->getValue('name'), $sOldPropertyName, $sNewPropertyName, $sColumnType);
    }

    public function removeEntityPropertyColumn(MimotoEntity $eInstance, $settings = null)
    {
        // 1. verify
        if ($eInstance->getValue('type') != MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) return; // #todo - only action if type = value

        // 2. get parent entity
        $eEntity = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--properties', $eInstance);

        // 3. remove column
        EntityConfigTableUtils::removePropertyColumnFromEntityTable($eEntity->get('name'), $eInstance->get('name'));
    }


    public function onEntityPropertySettingUpdated(MimotoEntity $eEntityPropertySetting)
    {
        // 1. load parent property
        $eEntityProperty = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITYPROPERTY, CoreConfig::MIMOTO_ENTITYPROPERTY.'--settings', $eEntityPropertySetting);

        // 2. verify
        if (empty($eEntityProperty) || $eEntityProperty->getValue('type') != MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) return;

        // 3. load parent entity
        $eEntity = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--properties', $eEntityProperty);

        // 4. register
        $sPropertyName = $eEntityProperty->getValue('name');

        // 5. determine
        $sNewColumnType = $this->getColumnTypeFromSetting($eEntityProperty);

        // 6. rename
        EntityConfigTableUtils::alterPropertyColumnType($eEntity->getValue('name'), $sPropertyName, $sNewColumnType);
    }



    private function getTablePrefix($eInstance)
    {
        // 1. init
        $sTablePrefix = '';

        // 2. define
        switch($eInstance->getEntityTypeName())
        {
            case CoreConfig::MIMOTO_ENTITY: $sTablePrefix = ''; break;
            case CoreConfig::MIMOTO_COMPONENT: $sTablePrefix = '|Mimoto_component|_'; break;
        }

        // 3. send
        return $sTablePrefix;
    }


    /**
     * Create "value" property settings
     * @param MimotoEntity $entityProperty
     */
    private function createValuePropertySettings(MimotoEntity $entityProperty)
    {

        // --- A. type ---

        // 1. init property setting
        $entityPropertySetting = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

        // 2. setup property setting
        $entityPropertySetting->setValue('key', EntityConfig::SETTING_VALUE_TYPE);
        $entityPropertySetting->setValue('type', MimotoEntityPropertyValueTypes::VALUETYPE_TEXT);
        $entityPropertySetting->setValue('value', CoreConfig::DATA_VALUE_TEXTLINE);

        // 3. persist property setting
        Mimoto::service('data')->store($entityPropertySetting);

        // 4. connect property setting to property
        $entityProperty->addValue('settings', $entityPropertySetting);



        // --- B. formatting options ---


        // 1. init property setting
        $entityPropertySetting = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

        // 2. setup property setting
        $entityPropertySetting->setValue('key', EntityConfig::SETTING_VALUE_FORMATTINGOPTIONS);
        $entityPropertySetting->setValue('type', '');
        $entityPropertySetting->setValue('value', '');

        // 3. persist property setting
        Mimoto::service('data')->store($entityPropertySetting);

        // 4. connect property setting to property
        $entityProperty->addValue('settings', $entityPropertySetting);


        // --- C. default value ---


        // 1. init property setting
        $entityPropertySetting = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

        // 2. setup property setting
        $entityPropertySetting->setValue('key', EntityConfig::SETTING_VALUE_DEFAULTVALUE);
        $entityPropertySetting->setValue('type', MimotoEntityPropertyTypes::PROPERTY_SETTING_DEFAULTVALUE_TYPE_NONE);
        $entityPropertySetting->setValue('value', '');

        // 3. persist property setting
        Mimoto::service('data')->store($entityPropertySetting);

        // 4. connect property setting to property
        $entityProperty->addValue('settings', $entityPropertySetting);



        // 5. persist connection
        Mimoto::service('data')->store($entityProperty);
    }

    /**
     * Create "entity" property settings
     * @param MimotoEntity $entityProperty
     */
    private function createEntityPropertySettings(MimotoEntity $entityProperty)
    {
        switch($entityProperty->getValue('type'))
        {
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE:
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO:
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_AUDIO:
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_FILE:

                $entityProperty->setValue('subtype', $entityProperty->getValue('type'));
                $entityProperty->setValue('type', MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);

                // store
                Mimoto::service('data')->store($entityProperty);

                switch($entityProperty->getValue('subtype'))
                {
                    case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE:
                    case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO:
                    case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_AUDIO:
                    case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_FILE:

                        // init
                        $entityPropertySetting = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

                        // setup
                        $entityPropertySetting->setValue('key', EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE);

                        // create
                        $connectedAllowedEntityType = Mimoto::service('data')->create(CoreConfig::MIMOTO_FILE);
                        $connectedAllowedEntityType->setId(CoreConfig::MIMOTO_FILE);

                        // connect
                        $entityPropertySetting->setValue('allowedEntityType', $connectedAllowedEntityType);

                        // create
                        Mimoto::service('data')->store($entityPropertySetting);


                        // #todo - add specific image/video/audio/file settings ...



                        // connect
                        $entityProperty->addValue('settings', $entityPropertySetting);

                        // store
                        Mimoto::service('data')->store($entityProperty);

                        break;
                }

                break;

            default:


                // --- A. allowed entity type ---

                // init
                $entityPropertySetting = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

                // setup
                $entityPropertySetting->setValue('key', EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE);
                $entityPropertySetting->setValue('type', '');
                $entityPropertySetting->setValue('value', '');

                // create
                Mimoto::service('data')->store($entityPropertySetting);

                // connect
                $entityProperty->addValue('settings', $entityPropertySetting);



                // --- B. default value ---


                // 1. init property setting
                $entityPropertySetting = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

                // 2. setup property setting
                $entityPropertySetting->setValue('key', EntityConfig::SETTING_ENTITY_DEFAULTVALUE);
                $entityPropertySetting->setValue('type', MimotoEntityPropertyTypes::PROPERTY_SETTING_DEFAULTVALUE_TYPE_NONE);
                $entityPropertySetting->setValue('value', '');

                // 3. persist property setting
                Mimoto::service('data')->store($entityPropertySetting);

                // 4. connect property setting to property
                $entityProperty->addValue('settings', $entityPropertySetting);



                // store
                Mimoto::service('data')->store($entityProperty);

        }
    }

    private function createImagePropertySettings(MimotoEntity $entityProperty)
    {

    }

    /**
     * Create "collection" property settings
     * @param MimotoEntity $entityProperty
     */
    private function createCollectionPropertySettings(MimotoEntity $entityProperty)
    {
        // init
        $entityPropertySetting = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

        // setup
        $entityPropertySetting->setValue('key', EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES);
        $entityPropertySetting->setValue('type', '');
        $entityPropertySetting->setValue('value', '');

        // create
        Mimoto::service('data')->store($entityPropertySetting);

        // connect
        $entityProperty->addValue('settings', $entityPropertySetting);

        // init
        $entityPropertySetting = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

        // setup
        $entityPropertySetting->setValue('key', EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES);
        $entityPropertySetting->setValue('type', MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN);
        $entityPropertySetting->setValue('value', false);

        // create
        Mimoto::service('data')->store($entityPropertySetting);

        // connect
        $entityProperty->addValue('settings', $entityPropertySetting);

        // store
        Mimoto::service('data')->store($entityProperty);
    }



    private function getColumnTypeFromSetting(MimotoEntity $entityProperty)
    {
        // init
        $sColumnType = null;

        // register
        $aSettings = $entityProperty->getValue('settings');

        // search for type setting
        $nSettingCount = count($aSettings);
        for ($nSettingIndex = 0; $nSettingIndex < $nSettingCount; $nSettingIndex++)
        {
            // register
            $setting = $aSettings[$nSettingIndex];

            // verify
            if ($setting->getValue('key') == EntityConfig::SETTING_VALUE_TYPE)
            {
                $sColumnType = $setting->getValue('value');
                break;
            }
        }

        // send
        return $sColumnType;
    }



    private function getColumnOntheLeft(MimotoEntity $entity, $sRequestedColumn)
    {
        // load
        $aAllProperties = $entity->getValue('properties');

        // search
        $sColumnOnTheLeft = 'id';
        $nPropertyCount = count($aAllProperties);
        for ($nPropertyIndex = 0; $nPropertyIndex < $nPropertyCount; $nPropertyIndex++)
        {
            // register
            $sPropertyName = $aAllProperties[$nPropertyIndex]->getValue('name');
            $sPropertyType = $aAllProperties[$nPropertyIndex]->getValue('type');

            // verify
            if ($sPropertyType == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE && $sPropertyName != $sRequestedColumn)
            {
                $sColumnOnTheLeft = $sPropertyName;
                break;
            }
        }

        // send
        return $sColumnOnTheLeft;
    }
}
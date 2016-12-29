<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\EntityConfigTableUtils;
use Mimoto\EntityConfig\MimotoEntityConfig;

use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * MimotoEntityConfigService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityConfigService
{

    // config
    private $_aEntityConfigs = [];
    
    // components
    private $_entityConfigRepository;


    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param object $entityConfigRepository
     */
    public function __construct($entityConfigRepository)
    {
        // store
        $this->_entityConfigRepository = $entityConfigRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get entity by id
     * @param int $nId
     * @return MimotoEntityConfig The requested entity config
     */
    public function getEntityConfigById($nId)
    {
        try
        {
            $entityConfig = $this->_entityConfigRepository->get($nId);
        }
        catch(MimotoEntityException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $entityConfig;
    }
    
    public function getAllEntityConfigData()
    {
        return $this->_entityConfigRepository->getAllEntityConfigData();
    }
    
    
    
    /**
     * Get entity config by name
     */
    public function getEntityConfigByName($sEntityConfigName)
    {
        return $this->_entityConfigRepository->getEntityConfigByName($sEntityConfigName);
    }
    
    
    /**
     * Get all entities
     */
    public function getAllEntityConfigs()
    {
        return $this->_entityConfigRepository->getAllEntityConfigs();
    }
    
    public function getEntityNameById($nId)
    {
        return $this->_entityConfigRepository->getEntityNameById($nId);
    }
    
    public function getEntityIdByName($sName)
    {
        return $this->_entityConfigRepository->getEntityIdByName($sName);
    }

    public function getPropertyNameById($nId)
    {
        return $this->_entityConfigRepository->getPropertyNameById($nId);
    }

    public function getPropertyIdByName($sName)
    {
        return $this->_entityConfigRepository->getPropertyIdByName($sName);
    }

    public function getPropertyTypeById($nId)
    {
        return $this->_entityConfigRepository->getPropertyTypeById($nId);
    }

    public function getEntityNameByPropertyId($nId)
    {
        return $this->_entityConfigRepository->getEntityNameByPropertyId($nId);
    }

    /**
     * Get all entities
     */
    public function find($criteria)
    {
        // init
        $aEntityConfigs= [];

        if (isset($criteria['typeOf']))
        {
            // read
            $sEntityTypeName = $criteria['typeOf'];

            // load
            $aEntityConfigs = $this->_entityConfigRepository->getEntityConfigsTypeOf($sEntityTypeName);
        }

        // send
        return $aEntityConfigs;
    }



    public function entityCreateTable($entity)
    {
        // 1. read entity name
        $sEntityName = $entity->getValue('name');

        // 2. check if entity table name is unique
        if (!EntityConfigTableUtils::tableNameIsUnique($sEntityName))
        {
            $GLOBALS['Mimoto.Log']->error("Duplicate table name", "Table '$sEntityName' for new entity already exists");
            die();
        }

        // 3. create table
        if (!EntityConfigTableUtils::createEntityTable($sEntityName))
        {
            $GLOBALS['Mimoto.Log']->error("Entity table creation issue", "Error while creating table for entity '$sEntityName'");
            die();
        }

        // 4. cleanup cache
        $this->flushEntityConfigCache();
    }

    public function entityUpdateTable(MimotoEntity $entity)
    {
        // 1. check if changes were made
        if (!$entity->hasChanges()) return;

        // 2. read changes
        $aChanges = $entity->getChanges();

        // 3. check if name was changed
        if (isset($aChanges['name'])) $this->renameEntityTable($entity);

        // 4. check if any properties were changed
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
                    $entityProperty = $GLOBALS['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $connection->getChildId());

                    if ($entityProperty->getValue('type') == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
                    {
                        // get column type
                        $sColumnType = 'textline';

                        $sColumnOnTheLeft = $this->getColumnOntheLeft($entity, $entityProperty->getValue('name'));

                        // add
                        EntityConfigTableUtils::addPropertyColumnToEntityTable($entity->getValue('name'), $entityProperty->getValue('name'), $sColumnType, $sColumnOnTheLeft);
                    }
                }
            }

            // 4b. change sortindex
            if (isset($aChanges['properties']->changed))
            {

            }


            // 4c. remove columns
            if (isset($aChanges['properties']->removed))
            {
                $nConnectionCount = count($aChanges['properties']->removed);
                for ($nConnectionIndex = 0; $nConnectionIndex < $nConnectionCount; $nConnectionIndex++)
                {
                    // register
                    $connection = $aChanges['properties']->removed[$nConnectionIndex];

                    // load property
                    $entityProperty = $GLOBALS['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $connection->getChildId());

                    if ($entityProperty->getValue('type') == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
                    {
                        // remove
                        EntityConfigTableUtils::removePropertyColumnFromEntityTable($entity->getValue('name'), $entityProperty->getValue('name'));
                    }
                }
            }
        }

        // 7. cleanup cache
        $this->flushEntityConfigCache();
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

            // verify
            if ($sPropertyName != $sRequestedColumn)
            {
                $sColumnOnTheLeft = $sPropertyName;
            }
            else
            {
                break;
            }
        }

        // send
        return $sColumnOnTheLeft;
    }

    private function renameEntityTable(MimotoEntity $entity)
    {
        // 4. register
        $sPreviousEntityName = $entity->getValue('name', false, true);
        $sNewEntityName = $entity->getValue('name');

        // 5. check if entity table name is unique
        if (!EntityConfigTableUtils::tableNameIsUnique($sNewEntityName))
        {
            $GLOBALS['Mimoto.Log']->error("Duplicate table name", "Table '$sNewEntityName' for entity '$sPreviousEntityName' already exists");
            die();
        }

        // 6. rename table
        if (!EntityConfigTableUtils::renameEntityTable($sPreviousEntityName, $sNewEntityName))
        {
            $GLOBALS['Mimoto.Log']->error("Entity table rename issue", "Error while renaming entity table from '$sPreviousEntityName' to '$sNewEntityName'");
            die();
        }
    }

    public function entityDelete(MimotoEntity $entity)
    {
        // 1. read
        $sEntityName = $entity->getValue('name');

        // 2. delete table
        if (!$this->deleteEntityTable($sEntityName)) error("Error while deleting entity table '$sEntityName'"); // #todo

        // 3. cleanup cache
        $this->flushEntityConfigCache();
    }

    public function onEntityPropertyCreated(MimotoEntity $entityProperty)
    {
        // 1. toggle on type
        switch($entityProperty->getValue('type'))
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                $this->createValuePropertySettings($entityProperty);
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                $this->createEntityPropertySettings($entityProperty);
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                $this->createCollectionPropertySettings($entityProperty);
                break;
        }

        // 2. cleanup cache
        $this->flushEntityConfigCache();
    }

    public function onEntityPropertyUpdated(MimotoEntity $entityProperty)
    {
        // 1. verify
        if ($entityProperty->getValue('type') != MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) return; // #todo - only action if type = value

        // 2. check if changes were made
        if (!$entityProperty->hasChanges()) return;

        // 3. read changes
        $aChanges = $entityProperty->getChanges();

        // 4. check if name was changed
        if (!isset($aChanges['name'])) return;

        // 5. register
        $sOldPropertyName = $entityProperty->getValue('name', false, true);
        $sNewPropertyName = $entityProperty->getValue('name');

        // 6. get parent entity
        $parentEntity = $this->getParentEntity($entityProperty); // #todo foei!

        // 7. check if parentEntity is known (something to do with store and acceptChanges)
        if (empty($parentEntity)) return;


        if ($entityProperty->getValue('type') == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
        {
            // 7. prepare
            $sColumnType = 'textline'; //$this->getColumnTypeFromSetting($entityProperty);

            // 8. rename
            EntityConfigTableUtils::renamePropertyColumn($parentEntity->getValue('name'), $sOldPropertyName, $sNewPropertyName, $sColumnType);
        }
    }

    public function getParentEntity(MimotoEntity $entityProperty)
    {
        // load all connections
        $stmt = $GLOBALS['database']->prepare(
            "SELECT * FROM ".CoreConfig::MIMOTO_CONNECTIONS_CORE." WHERE ".
            "parent_entity_type_id = :parent_entity_type_id && ".
            "parent_property_id = :parent_property_id && ".
            "child_entity_type_id = :child_entity_type_id && ".
            "child_id = :child_id ".
            "ORDER BY parent_id ASC, sortindex ASC"
        );
        $params = array(
            ':parent_entity_type_id' => CoreConfig::MIMOTO_ENTITY,
            ':parent_property_id' => CoreConfig::MIMOTO_ENTITY.'--properties',
            ':child_entity_type_id' => $entityProperty->getEntityTypeId(),
            ':child_id' => $entityProperty->getId(),
        );
        $stmt->execute($params);

        //output('$stmt', $stmt);
        //output('$params', $params);

        // load
        $aResults = $stmt->fetchAll();

        // register
        $nResultCount = count($aResults);

        //output('$nResultCount', $nResultCount);

        // validate
        if ($nResultCount != 1) return null;

        // load
        $entity = $GLOBALS['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, $aResults[0]['parent_id']);

        // send
        return $entity;
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
            if ($setting->getValue('name') == MimotoEntityConfig::SETTING_VALUE_TYPE)
            {
                $sColumnType = $setting->getValue('value');
                break;
            }
        }

        // send
        return $sColumnType;
    }

    private function createValuePropertySettings(MimotoEntity $entityProperty)
    {
        // 1. init property setting
        $entityPropertySetting = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

        // 2. setup property setting
        $entityPropertySetting->setValue('key', MimotoEntityConfig::SETTING_VALUE_TYPE);
        $entityPropertySetting->setValue('type', MimotoEntityPropertyValueTypes::VALUETYPE_TEXT);
        $entityPropertySetting->setValue('value', CoreConfig::DATA_VALUE_TEXTLINE);

        // 3. persist property setting
        $GLOBALS['Mimoto.Data']->store($entityPropertySetting);

        // 4. connect property setting to property
        $entityProperty->addValue('settings', $entityPropertySetting);

        // 5. persist connection
        $GLOBALS['Mimoto.Data']->store($entityProperty);
    }

    private function createEntityPropertySettings(MimotoEntity $entityProperty)
    {
        // init
        $entityPropertySetting = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

        // setup
        $entityPropertySetting->setValue('key', MimotoEntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE);
        $entityPropertySetting->setValue('type', '');
        $entityPropertySetting->setValue('value', '');

        // create
        $GLOBALS['Mimoto.Data']->store($entityPropertySetting);

        // connect
        $entityProperty->addValue('settings', $entityPropertySetting);

        // store
        $GLOBALS['Mimoto.Data']->store($entityProperty);
    }

    private function createCollectionPropertySettings(MimotoEntity $entityProperty)
    {
        // init
        $entityPropertySetting = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

        // setup
        $entityPropertySetting->setValue('key', MimotoEntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES);
        $entityPropertySetting->setValue('type', '');
        $entityPropertySetting->setValue('value', '');

        // create
        $GLOBALS['Mimoto.Data']->store($entityPropertySetting);

        // connect
        $entityProperty->addValue('settings', $entityPropertySetting);

        // init
        $entityPropertySetting = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);

        // setup
        $entityPropertySetting->setValue('key', MimotoEntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES);
        $entityPropertySetting->setValue('type', MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN);
        $entityPropertySetting->setValue('value', false);

        // create
        $GLOBALS['Mimoto.Data']->store($entityPropertySetting);

        // connect
        $entityProperty->addValue('settings', $entityPropertySetting);

        // store
        $GLOBALS['Mimoto.Data']->store($entityProperty);
    }



    public function entityIsTypeOf($sTypeOfEntity, $sTypeToCompare)
    {
        return $this->_entityConfigRepository->entityIsTypeOf($sTypeOfEntity, $sTypeToCompare);
    }


    private function flushEntityConfigCache()
    {
        // TODO Flush memcache
    }






    public function onInputFieldCreated(MimotoEntity $eInput)
    {
        // 1. init property setting
        $eValue = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);

        // 2. setup property setting
        $eValue->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        // 3. persist property setting
        $GLOBALS['Mimoto.Data']->store($eValue);

        // 4. connect property setting to property
        $eInput->setValue('value', $eValue);

        // 5. persist connection
        $GLOBALS['Mimoto.Data']->store($eInput);

        output('$eInput', $eInput);
    }
}

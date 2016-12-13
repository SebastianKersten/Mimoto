<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;
use Mimoto\EntityConfig\MimotoEntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
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
            // 1. add columns
            // 2. remove columns
            // 3. check sortindex
        }

        // 7. cleanup cache
        $this->flushEntityConfigCache();
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
//        // 1. toggle on type
//        switch($entityProperty->getValue('type'))
//        {
//            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:
//
//                $this->createValuePropertySettings($entityProperty);
//                break;
//
//            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
//
//                $this->createEntityPropertySettings($entityProperty);
//                break;
//
//            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:
//
//                $this->createCollectionPropertySettings($entityProperty);
//                break;
//        }
//
//        // 2. cleanup cache
//        $this->flushEntityConfigCache();
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

}

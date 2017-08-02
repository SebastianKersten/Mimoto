<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Core\CoreFormUtils;
use Mimoto\Core\entities\Entity;
use Mimoto\Mimoto;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\EntityConfigTableUtils;
use Mimoto\EntityConfig\EntityConfig;

use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * EntityConfigService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityConfigService
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
     * @return EntityConfig The requested entity config
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

    public function getPropertyIdByName($sName, $nParentEntityTypeId = null)
    {
        return $this->_entityConfigRepository->getPropertyIdByName($sName, $nParentEntityTypeId);
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



    public function entityCreateTable(MimotoEntity $entity)
    {
        // 1. read entity name
        $sEntityName = $entity->getValue('name');

        // 2. check if entity table name is unique
        if (!EntityConfigTableUtils::tableNameIsUnique($sEntityName))
        {
            Mimoto::service('log')->error("Duplicate table name", "Table '$sEntityName' for new entity already exists", true);
        }

        // 3. create table
        if (!EntityConfigTableUtils::createEntityTable($sEntityName))
        {
            Mimoto::service('log')->error("Entity table creation issue", "Error while creating table for entity '$sEntityName'", true);
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
                    $entityProperty = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $connection->getChildId());

                    if ($entityProperty->getValue('type') == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
                    {
                        // load
                        $sColumnType = $this->getColumnTypeFromSetting($entityProperty);

                        // search
                        $sColumnOnTheLeft = $this->getColumnOntheLeft($entity, $entityProperty->getValue('name'));

                        // add
                        EntityConfigTableUtils::addPropertyColumnToEntityTable($entity->getValue('name'), $entityProperty->getValue('name'), $sColumnType, $sColumnOnTheLeft);
                    }
                }
            }

            // 4b. change sortindex
            if (isset($aChanges['properties']->changed))
            {
                // 1. do nothing
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
                    $entityProperty = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $connection->getChildId());

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

    private function renameEntityTable(MimotoEntity $entity)
    {
        // 4. register
        $sPreviousEntityName = $entity->getValue('name', false, true);
        $sNewEntityName = $entity->getValue('name');

        // 5. check if entity table name is unique
        if (!EntityConfigTableUtils::tableNameIsUnique($sNewEntityName))
        {
            Mimoto::service('log')->error("Duplicate table name", "Table '$sNewEntityName' for entity '$sPreviousEntityName' already exists");
            die();
        }

        // 6. rename table
        if (!EntityConfigTableUtils::renameEntityTable($sPreviousEntityName, $sNewEntityName))
        {
            Mimoto::service('log')->error("Entity table rename issue", "Error while renaming entity table from '$sPreviousEntityName' to '$sNewEntityName'");
            die();
        }
    }

    public function entityDelete(MimotoEntity $entity)
    {
        // 1. read
        $sEntityName = $entity->getValue('name');

        // 2. delete table
        if (!$this->deleteEntityTable($sEntityName)) Mimoto::error("Error while deleting entity table '$sEntityName'"); // #todo

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
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE:
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO:
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_AUDIO:
            case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_FILE:

                $this->createEntityPropertySettings($entityProperty);
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                $this->createCollectionPropertySettings($entityProperty);
                break;
        }

        // 2. cleanup cache
        $this->flushEntityConfigCache();
    }

    public function onEntityPropertyUpdated(MimotoEntity $eEntityProperty)
    {
        // 1. verify
        if ($eEntityProperty->getValue('type') != MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) return; // #todo - only action if type = value

        // 2. check if changes were made
        if (!$eEntityProperty->hasChanges()) return;

        // 3. read changes
        $aChanges = $eEntityProperty->getChanges();

        // 4. check if name was changed
        if (!isset($aChanges['name'])) return;

        // 5. register
        $sOldPropertyName = $eEntityProperty->getValue('name', false, true);
        $sNewPropertyName = $eEntityProperty->getValue('name');

        // 6. get parent entity
        $eEntity = self::getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--properties', $eEntityProperty);

        // 7. check if parentEntity is known (something to do with store and acceptChanges)
        if (empty($eEntity)) return;

        // 8 verify
        if ($eEntityProperty->getValue('type') != MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) return;

        // 9. determinde
        $sColumnType = $this->getColumnTypeFromSetting($eEntityProperty);

        // 10. rename
        EntityConfigTableUtils::renamePropertyColumn($eEntity->getValue('name'), $sOldPropertyName, $sNewPropertyName, $sColumnType);
    }

    public function onEntityPropertySettingUpdated(MimotoEntity $eEntityPropertySetting)
    {
        // 1. load parent property
        $eEntityProperty = self::getParent(CoreConfig::MIMOTO_ENTITYPROPERTY, CoreConfig::MIMOTO_ENTITYPROPERTY.'--settings', $eEntityPropertySetting);

        // 2. verify
        if (empty($eEntityProperty) || $eEntityProperty->getValue('type') != MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE) return;

        // 3. load parent entity
        $eEntity = self::getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--properties', $eEntityProperty);

        // 4. register
        $sPropertyName = $eEntityProperty->getValue('name');

        // 5. determine
        $sNewColumnType = $this->getColumnTypeFromSetting($eEntityProperty);

        // 6. rename
        EntityConfigTableUtils::alterPropertyColumnType($eEntity->getValue('name'), $sPropertyName, $sNewColumnType);
    }

    public function getParent($sParentEntityTypeId, $sParentPropertyId, MimotoEntity $child)
    {
        $xId = $child->getId();

        if (substr($xId, 0, strlen(CoreConfig::CORE_PREFIX)) == CoreConfig::CORE_PREFIX)
        {
            return $this->_entityConfigRepository->getEntityNameByFormId($xId);
        }
        else
        {
            if (!MimotoDataUtils::isValidId($sParentEntityTypeId))
            {
                if (MimotoDataUtils::isValidEntityName($sParentEntityTypeId))
                {
                    // convert
                    $sParentEntityTypeId = Mimoto::service('config')->getEntityIdByName($sParentEntityTypeId);
                }
            }

            if (!MimotoDataUtils::isValidId($sParentPropertyId))
            {
                if (MimotoDataUtils::validatePropertyName($sParentPropertyId))
                {
                    // convert
                    $sParentPropertyId = Mimoto::service('config')->getPropertyIdByName($sParentPropertyId);
                }
            }

            // validate
            if (empty($sParentEntityTypeId) || empty($sParentPropertyId)) return null;


            // load all connections
            $stmt = Mimoto::service('database')->prepare(
                "SELECT * FROM `".CoreConfig::MIMOTO_CONNECTION."` WHERE ".
                "parent_entity_type_id = :parent_entity_type_id && ".
                "parent_property_id = :parent_property_id && ".
                "child_entity_type_id = :child_entity_type_id && ".
                "child_id = :child_id ".
                "ORDER BY parent_id ASC, sortindex ASC"
            );
            $params = array(
                ':parent_entity_type_id' => $sParentEntityTypeId,
                ':parent_property_id' => $sParentPropertyId,
                ':child_entity_type_id' => $child->getEntityTypeId(),
                ':child_id' => $child->getId(),
            );
            $stmt->execute($params);

//            output('$stmt', $stmt);
//            output('$params', $params);

            // load
            $aResults = $stmt->fetchAll();

            // register
            $nResultCount = count($aResults);

            //output('$nResultCount', $nResultCount);

            // validate
            if ($nResultCount != 1) return null;

            // load
            $entity = Mimoto::service('data')->get($sParentEntityTypeId, $aResults[0]['parent_id']);

            // send
            return $entity;
        }
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


    /**
     * Create "value" property settings
     * @param MimotoEntity $entityProperty
     */
    private function createValuePropertySettings(MimotoEntity $entityProperty)
    {
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


        // --- formatting options

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


    public function entityIsTypeOf($sTypeOfEntity, $sTypeToCompare)
    {
        return $this->_entityConfigRepository->entityIsTypeOf($sTypeOfEntity, $sTypeToCompare);
    }


    private function flushEntityConfigCache()
    {
        // TODO Flush memcache
    }

    private function deleteEntityTable($sEntityName)
    {
        // 1. check in table comments if item id is similar
        $stmt = Mimoto::service('database')->prepare(
            "DROP TABLE `".$sEntityName."`"
        );
        $params = array();
        $stmt->execute($params);

        return true;
    }

}

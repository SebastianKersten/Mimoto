<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Data\MimotoEntityException;


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

    public function getPropertyTypeById($nId)
    {
        return $this->_entityConfigRepository->getPropertyTypeById($nId);
    }

    public function getEntityNameByPropertyId($nId)
    {
        return $this->_entityConfigRepository->getEntityNameByPropertyId($nId);
    }



    public function entityCreate($sEntityName)
    {
        // 1. validate name (mysql worthy)
        if (!$this->entityNameIsValid($sEntityName)) error("Entity name '$sEntityName' formatted invalid");

        // 2. check if entity name is unique
        if (!$this->entityNameIsUnique($sEntityName)) error("Entity name '$sEntityName' already exists");

        // 3. check if entity table name is unique
        if (!$this->tableNameIsUnique($sEntityName)) error("Table '$sEntityName' for new entity already exists");

        // 4. create new entity
        $entity = $GLOBALS['Mimoto.Data']->create('_mimoto_entity');
        $entity->setValue('name', $sEntityName);
        $GLOBALS['Mimoto.Data']->store($entity);

        // 5. create table
        if (!$this->createEntityTable($sEntityName)) error("Error while creating table for entity '$sEntityName'");

        // 6. cleanup cache
        $this->flushEntityConfigCache();
    }

    public function entityUpdate($nEntityId, $sNewEntityName)
    {
        // 1. validate name (mysql worthy)
        if (!$this->entityNameIsValid($sNewEntityName)) error("New entity name '$sNewEntityName' formatted invalid");

        // 2. check if entity name is unique
        if (!$this->entityNameIsUnique($sNewEntityName)) error("Entity name '$sNewEntityName' already exists");

        // 3. check if entity table name is unique
        if (!$this->tableNameIsUnique($sNewEntityName)) error("Table '$sNewEntityName' for new entity already exists");

        // 4. load current name
        $entity = $GLOBALS['Mimoto.Data']->get('_mimoto_entity', $nEntityId);
        $sCurrentEntityName = $entity->getValue('name');

        // 5. change name
        $entity->setValue('name', $sNewEntityName);
        $GLOBALS['Mimoto.Data']->store($entity);

        // 6. rename table
        if (!$this->renameEntityTable($sCurrentEntityName, $sNewEntityName)) error("Error while renaming entity table from '$sCurrentEntityName' to '$sNewEntityName'");

        // 7. cleanup cache
        $this->flushEntityConfigCache();
    }

    public function entityDelete($nEntityId)
    {
        // 1. load entity
        $entity = $GLOBALS['Mimoto.Data']->get('_mimoto_entity', $nEntityId);
        $sEntityName = $entity->getValue('name');

        // 2. cleanup
        $GLOBALS['Mimoto.Data']->delete($entity);

        // 3. delete table
        if (!$this->deleteEntityTable($sEntityName)) error("Error while deleting entity table '$sEntityName'");

        // 4. cleanup cache
        $this->flushEntityConfigCache();
    }

    public function entityPropertyCreate($nEntityId, $sEntityPropertyName, $sEntityPropertyType)
    {
        // 1. validate name
        if (!MimotoDataUtils::validatePropertyName($sEntityPropertyName)) error("EntityProperty name '$sEntityPropertyName' formatted invalid");

        // 2. load the Entity (and check if it actually exists)
        if (!($entity = $GLOBALS['Mimoto.Data']->get('_mimoto_entity', $nEntityId))) error("I can't find the entity with id='$nEntityId'");

        // 3. check if EntityProperty name is unique
        if (!$this->entityPropertyNameIsUnique($nEntityId, $sEntityPropertyName)) error("Entity property name '$sEntityPropertyName' already exists for this entity");

        // 4. create new EntityProperty
        $entityProperty = $GLOBALS['Mimoto.Data']->create('_mimoto_entityproperty');
        $entityProperty->setValue('name', $sEntityPropertyName);
        $entityProperty->setValue('type', $sEntityPropertyType);
        $GLOBALS['Mimoto.Data']->store($entityProperty);

        // 5. add new EntityProperty to Entity
        $entity->addValue('properties', $entityProperty);
        $GLOBALS['Mimoto.Data']->store($entity);

        // 6. cleanup cache
        $this->flushEntityConfigCache();
    }

    public function entityIsTypeOf($sTypeOfEntity, $sTypeToCompare)
    {
        return $this->_entityConfigRepository->entityIsTypeOf($sTypeOfEntity, $sTypeToCompare);
    }



    private function entityNameIsValid($sEntityName)
    {
        // validate
        return (preg_match("/[a-zA-Z0-9-_]+/", $sEntityName));
    }

    private function entityNameIsUnique($sEntityName)
    {
        $stmt = $GLOBALS['database']->prepare("SELECT * FROM _mimoto_entity WHERE name = :name");
        $params = array(':name' => $sEntityName);
        if ($stmt->execute($params) === false) error("Error while searching for duplicates of entity name '$sEntityName'");
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($aResults) == 0) ? true : false;
    }

    private function tableNameIsUnique($sEntityName)
    {
        $stmt = $GLOBALS['database']->prepare("SHOW TABLES LIKE '".$sEntityName."'");
        $params = array();
        if ($stmt->execute($params) === false) error("Error while checking for duplicate entity table '$sEntityName'");
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($aResults) == 0) ? true : false;
    }

    private function createEntityTable($sEntityName)
    {
        $stmt = $GLOBALS['database']->prepare(
            "CREATE TABLE `".$sEntityName."` (".
            "   `id` int(10) unsigned NOT NULL AUTO_INCREMENT, ".
            "   `created` datetime DEFAULT NULL, ".
            "   PRIMARY KEY (`id`) ".
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
        $params = array();
        return $stmt->execute($params);
    }

    private function renameEntityTable($sCurrentEntityName, $sNewEntityName)
    {
        $stmt = $GLOBALS['database']->prepare(
            "RENAME TABLE `".$sCurrentEntityName."` TO `$sNewEntityName`"
        );
        $params = array();
        return $stmt->execute($params);
    }

    private function deleteEntityTable($sEntityName)
    {
        $stmt = $GLOBALS['database']->prepare("DROP TABLE IF EXISTS `" . $sEntityName . "`");
        $params = array();
        return $stmt->execute($params);
    }

    private function createEntityConnectionTable($sEntityName)
    {
        $stmt = $GLOBALS['database']->prepare(
            "CREATE TABLE `".$sEntityName."_connections` (".
            "   `id` int(10) unsigned NOT NULL AUTO_INCREMENT, ".
            "   `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL, ".
            "   `created` datetime DEFAULT NULL, ".
            "   PRIMARY KEY (`id`) ".
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
        $params = array();
        return $stmt->execute($params);
    }

    private function entityPropertyNameIsUnique($nEntityId, $sEntityPropertyName)
    {
        $stmt = $GLOBALS['database']->prepare(
            "SELECT * FROM _mimoto_entityproperty LEFT JOIN _mimoto_entity_connections ".
            "ON _mimoto_entityproperty.id = _mimoto_entity_connections.child_id ".
            "WHERE _mimoto_entity_connections.parent_id = :parent_id ".
            "&& _mimoto_entity_connections.parent_property_id = :parent_property_id ".
            "&& _mimoto_entityproperty.name = :name");
        $params = array(
            "parent_id" => $nEntityId,
            "parent_property_id" => 'pid2',
            "name" => $sEntityPropertyName
        );
        if ($stmt->execute($params) === false) error("Error while checking for duplicate EntityProperty '$sEntityPropertyName'");
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($aResults) == 0) ? true : false;
    }


    private function flushEntityConfigCache()
    {
        // TODO Flush memcache
    }
    
}

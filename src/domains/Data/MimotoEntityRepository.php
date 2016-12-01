<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Data\MimotoEntityConnection;
use Mimoto\EntityConfig\MimotoEntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Data\MimotoCollection;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;
use Mimoto\Event\MimotoEvent;


/**
 * MimotoEntityRepository
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityRepository
{
    
    /**
     * The EventService
     * @var class
     */
    private $_EventService;
    
    /**
     * The requested entities
     * @var array
     */
    private $_aEntities = [];
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param EventService $EventService
     */
    public function __construct($EventService)
    {
        // register
        $this->_EventService = $EventService;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods - runtime usage -----------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Create new entity
     * @return MimotoEntity
     */
    public function create(MimotoEntityConfig $entityConfig)
    {
        // init and send
        return $this->createEntity($entityConfig);
    }
    
    /**
     * Get single entity by id
     * @param int $nId
     * @return MimotoEntity
     * @throws MimotoEntityException
     */
    public function get(MimotoEntityConfig $entityConfig, $nEntityId)
    {
        // validate
        //if (is_nan($nEntityId) || $nEntityId < 0) { throw new MimotoEntityException("( '-' ) - Sorry, the entity id '$nEntityId' you passed is not a valid. Should be an integer > 0"); }

        // load
        $stmt = $GLOBALS['database']->prepare('SELECT * FROM '.$entityConfig->getMySQLTable().' WHERE id = :id');
        $params = array(
            ':id' => $nEntityId
        );
        $stmt->execute($params);

        // load
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // verify
        if (count($aResults) !== 1)
        {
            throw new MimotoEntityException("( '-' ) - Sorry, I can't find the the '".$entityConfig->getName()."' entity with id='$nEntityId'");
        }
        else
        {
            // setup
            $entity = $this->createEntity($entityConfig, $aResults[0]);

            // send
            return $entity;
        }
    }
    
    /**
     * Find a collection entities
     * @return MimotoCollection containing zero or more entities
     */
    public function find(MimotoEntityConfig $entityConfig, $criteria)
    {
        
        // init
        $aEntities = new MimotoCollection();
        
        // setup
        $aEntities->setCriteria($criteria);



        $sQuery = 'SELECT * FROM '.$entityConfig->getMySQLTable();
        $params = array();

        if (isset($criteria['value']))
        {
            $bFirst = true;
            foreach($criteria['value'] as $sKey => $value)
            {
                // prepare
                if ($bFirst) { $bFirst = false; $sQuery .= ' WHERE '; } else { $sQuery .= ', '; }

                // compose
                $sQuery .= $sKey.' = :'.$sKey;

                // add
                $params[':'.$sKey] = $value;
            }
        }

        // load
        $stmt = $GLOBALS['database']->prepare($sQuery);
        $stmt->execute($params);

        // load
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        // register
        $nResultCount = count($aResults);
        for ($i = 0; $i < $nResultCount; $i++)
        {
            // register
            $aEntities[] = $this->createEntity($entityConfig, $aResults[$i]);
        }

        // send
        return $aEntities;
    }
    
    /**
     * Store entity
     * @param MimotoEntity $entity
     */
    public function store(MimotoEntityConfig $entityConfig, MimotoEntity $entity)
    {
        // read
        $aModifiedValues = $entity->getChanges();
        
        // save nothing if no changes
        if (count($aModifiedValues) == 0) { return $entity; }
        
        // determine
        $bIsExistingEntity = (!empty($entity->getId()) && !is_nan($entity->getId())) ? true : false;

        // load
        $aPropertyNames = $entityConfig->getPropertyNames();
        
        // init
        $aQueryElements = [];
        
        // load properties
        $nPropertyCount = count($aPropertyNames);
        for ($i = 0; $i < $nPropertyCount; $i++)
        {
            // register
            $sPropertyName = $aPropertyNames[$i];
            
            // skip if no changes
            if (!isset($aModifiedValues[$sPropertyName])) { continue; }
            
            // read
            $propertyConfig = $entityConfig->getPropertyConfig($sPropertyName);
            $propertyValue = $entityConfig->getPropertyValue($sPropertyName);

            // set value
            switch($propertyValue->type)
            {
                case MimotoEntityConfig::PROPERTY_VALUE_MYSQL_COLUMN:
                    
                    switch($propertyConfig->type)
                    {
                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:
                    
                            $aQueryElements[] = (object) array(
                                'key' => $propertyValue->mysqlColumnName,
                                'value' => MimotoDataUtils::convertRuntimeValueToStorableValue($entity->getValue($sPropertyName), $propertyConfig->settings->type->type)
                            );
                            break;
                    }
                    
                    break;

                case MimotoEntityConfig::PROPERTY_VALUE_MYSQLCONNECTION_TABLE:

                    $modifiedCollection = $aModifiedValues[$sPropertyName];


                    switch($propertyConfig->type)
                    {
                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                            if (count($modifiedCollection->added) > 0)
                            {
                                $nAddedCount = count($modifiedCollection->added);
                                for ($k = 0; $k < $nAddedCount; $k++)
                                {
                                    // register
                                    $newItem = $modifiedCollection->added[$k];

                                    // add
                                    $this->addItemToCollection($propertyValue->mysqlConnectionTable, $newItem);

                                    // toggle
                                    $newItem->setNewFlag(true);
                                }
                            }

                            if (count($modifiedCollection->updated) > 0)
                            {
                                $nUpdatedCount = count($modifiedCollection->updated);
                                for ($k = 0; $k < $nUpdatedCount; $k++)
                                {
                                    // register
                                    $existingItem = $modifiedCollection->updated[$k];

                                    // alter
                                    $this->alterExistingItemInCollection($propertyValue->mysqlConnectionTable, $existingItem);
                                }
                            }

                            if (count($modifiedCollection->removed) > 0)
                            {
                                $nRemovedCount = count($modifiedCollection->removed);
                                for ($k = 0; $k < $nRemovedCount; $k++)
                                {
                                    // register
                                    $existingItem = $modifiedCollection->removed[$k];

                                    // remove
                                    $this->removeItemFromCollection($propertyValue->mysqlConnectionTable, $existingItem);
                                }
                            }

                            break;
                    }


                    break;
            }
        }
        
        
        if (count($aQueryElements) > 0)
        {
            // compose
            $sQuery  = ($bIsExistingEntity) ? 'UPDATE' : 'INSERT';
            $sQuery .= ' '.$entityConfig->getMySQLTable().' SET ';

            $params = array();

            // compose
            $nQueryItemCount = count($aQueryElements);
            for ($i = 0; $i < $nQueryItemCount; $i++)
            {
                $sQuery .= $aQueryElements[$i]->key.' = :'.$aQueryElements[$i]->key;
                $params[':'.$aQueryElements[$i]->key] = $aQueryElements[$i]->value;
                if ($i < $nQueryItemCount - 1) { $sQuery .= ', '; }
            }

            // compose
            if ($bIsExistingEntity)
            {
                $sQuery .= " WHERE id = :id";
                $params[':id'] = $entity->getId();
            }
            else
            {
                $sQuery .= ", created = :created";
                $params[':created'] = date("YmdHis");
            }

            // load
            $stmt = $GLOBALS['database']->prepare($sQuery);
            $stmt->execute($params);
        }
        
        
        
        // --- events ---
        
        
        // broadcast
        if ($bIsExistingEntity)
        {   
            // register
            $sEvent = MimotoEvent::UPDATED;
        }
        else
        {
            // get entity
            $entity->setId($GLOBALS['database']->lastInsertId());

            // register
            $sEvent = MimotoEvent::CREATED;
        }
        
        
        // setup
        $event = new MimotoEvent($entity, $sEvent);

        // broadcast
        $this->_EventService->sendUpdate($event->getType(), $event);
        
        
        
        // --- finish up ---
        
        
        // update
        $entity->acceptChanges();

        // send
        return $entity;
    }

    /**
     * Delete entity
     * @param entity $entity
     */
    public function delete(MimotoEntityConfig $entityConfig, MimotoEntity $entity)
    {
        // load
        $stmt = $GLOBALS['database']->prepare('DELETE FROM '.$entityConfig->getMySQLTable().' WHERE id = :id');
        $params = array(
            ':id' => $entity->getId()
        );
        return $stmt->execute($params);
    }

    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Create entity from MySQL result
     * @param MySQL query result $mysqlResult
     * @param int $nIndex
     * @return entity
     */
    private function createEntity(MimotoEntityConfig $entityConfig, $result = null)
    {
        // read
        $nEntityId = (!empty($result)) ? $result['id'] : null;

        // make sure an entity is available only once
        if (empty($nEntityId))
        {
            // init
            $entity = new MimotoEntity($entityConfig->getId(), $entityConfig->getName(), false);
        }
        else if(!isset($this->_aEntities[$this->getEntityIdentifier($entityConfig->getName(), $nEntityId)]))
        {
            // init
            $entity = new MimotoEntity($entityConfig->getId(), $entityConfig->getName(), false);
            
            // register
            $entity->setId($nEntityId);
            $entity->setCreated($result['created']);

            // store
            $this->_aEntities[$this->getEntityIdentifier($entityConfig->getName(), $nEntityId)] = $entity;
        }
        else
        {
            // load
            $entity = $this->_aEntities[$this->getEntityIdentifier($entityConfig->getName(), $nEntityId)];
        }


        // load
        $aPropertyNames = $entityConfig->getPropertyNames();
        
        // load properties
        $nPropertyCount = count($aPropertyNames);
        for ($i = 0; $i < $nPropertyCount; $i++)
        {
            // register
            $sPropertyName = $aPropertyNames[$i];
            $propertyConfig = $entityConfig->getPropertyConfig($sPropertyName);
            $propertyValue = $entityConfig->getPropertyValue($sPropertyName);
            
            // setup property
            $entity->setupProperty($propertyConfig);
            
            if (!empty($nEntityId))
            {
                // set value
                switch($propertyValue->type)
                {
                    case MimotoEntityConfig::PROPERTY_VALUE_MYSQL_COLUMN:

                        // 1. register
                        $value = MimotoDataUtils::convertStoredValueToRuntimeValue($result[$propertyValue->mysqlColumnName], $propertyConfig->settings->type->type);

                        // 2. store
                        $entity->setValue($propertyConfig->name, $value);
                        break;

                    case MimotoEntityConfig::PROPERTY_VALUE_MYSQLCONNECTION_TABLE:
                        
                        // init
                        $aCollection = array();

                        // load
                        $stmt = $GLOBALS['database']->prepare(
                            'SELECT * FROM '.$propertyValue->mysqlConnectionTable.
                            ' WHERE parent_id = :parent_id'.
                            ' && parent_property_id = :parent_property_id'.
                            ' && parent_entity_type_id = :parent_entity_type_id'.
                            ' ORDER BY sortindex'
                        );
                        $params = array(
                            ':parent_id' => $entity->getId(),
                            ':parent_property_id' => $propertyConfig->id,
                            ':parent_entity_type_id' => $entity->getEntityTypeId()
                        );

                        $stmt->execute($params);

                        // load
                        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                        foreach ($aResults as $row)
                        {
                            // init
                            $connection = new MimotoEntityConnection();

                            // compose
                            $connection->setId($row['id']);
                            $connection->setParentEntityTypeId($row['parent_entity_type_id']);
                            $connection->setParentPropertyId($row['parent_property_id']);
                            $connection->setParentId($row['parent_id']);
                            $connection->setChildEntityTypeId($row['child_entity_type_id']);
                            $connection->setChildId($row['child_id']);
                            $connection->setSortIndex($row['sortindex']);

                            // store
                            $aCollection[] = $connection;
                        }

                        if ($propertyConfig->type == MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY)
                        {
                            if (isset($aCollection[0]))
                            {
                                // register collection data
                                $entity->setValue($propertyConfig->name, $aCollection[0]);
                            }
                        }
                        elseif ($propertyConfig->type == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION)
                        {
                            // register collection data
                            $entity->setValue($propertyConfig->name, $aCollection);
                        }

                        break;
                }
            }
        }

        // start tracking changes
        $entity->trackChanges();

        // send
        return $entity;
    }
    
    
    private function getEntityIdentifier($sEntityName, $nEntityId)
    {
        return $sEntityName.'.'.$nEntityId;
    }


    private function addItemToCollection($sDBTable, MimotoEntityConnection $newItem)
    {
        // load
        $stmt = $GLOBALS['database']->prepare(
            "INSERT INTO ".$sDBTable." SET ".
            "parent_entity_type_id = :parent_entity_type_id, ".
            "parent_property_id = :parent_property_id, ".
            "parent_id = :parent_id, ".
            "child_entity_type_id = :child_entity_type_id, ".
            "child_id = :child_id, ".
            "sortindex = :sortindex"
        );
        $params = array(
            ':parent_entity_type_id' => $newItem->getParentEntityTypeId(),
            ':parent_property_id' => $newItem->getParentPropertyId(),
            ':parent_id' => $newItem->getParentId(),
            ':child_entity_type_id' => $newItem->getChildEntityTypeId(),
            ':child_id' => $newItem->getChildId(),
            ':sortindex' => $newItem->getSortIndex()
        );

        $stmt->execute($params);

        // complete
        $newItem->setId($GLOBALS['database']->lastInsertId());
    }

    private function alterExistingItemInCollection($sDBTable, MimotoEntityConnection $existingItem)
    {
        // load
        $stmt = $GLOBALS['database']->prepare(
            'UPDATE '.$sDBTable.' SET '.
            'sortindex = :sortindex '.
            'WHERE id = :id'
        );
        $params = array(
            ':sortindex' => $existingItem->getSortIndex(),
            ':id' => $existingItem->getId()
        );
        $stmt->execute($params);
    }

    private function removeItemFromCollection($sDBTable, MimotoEntityConnection $existingItem)
    {
        // load
        $stmt = $GLOBALS['database']->prepare(
            'DELETE FROM '.$sDBTable.' WHERE id = :id'
        );
        $params = array(
            ':id' => $existingItem->getId()
        );
        $stmt->execute($params);
    }
}

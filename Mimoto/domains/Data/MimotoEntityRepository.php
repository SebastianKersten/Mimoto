<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Data\MimotoCollection;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;
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
     * @return ModelClass
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
        if (is_nan($nEntityId) || $nEntityId < 0) { throw new MimotoEntityException("( '-' ) - Sorry, the entity id '$nEntityId' you passed is not a valid. Should be an integer > 0"); }

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
     * @return Array containing zero or more entities
     */
    public function find(MimotoEntityConfig $entityConfig, $criteria)
    {
        
        // init
        $aEntities = new MimotoCollection();
        
        // setup
        $aEntities->setCriteria($criteria);

        // load
        $stmt = $GLOBALS['database']->prepare('SELECT * FROM '.$entityConfig->getMySQLTable());
        $stmt->execute();

        // load
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        // register
        for ($i = 0; $i < count($aResults); $i++)
        {
            // register
            $aEntities[] = $this->createEntity($entityConfig, $aResults[$i]);
        }
        
        // send
        return $aEntities;
    }
    
    /**
     * Store entity
     * @param entity $entity
     */
    public function store(MimotoEntityConfig $entityConfig, MimotoEntity $entity)
    {
        
        // read
        $aModifiedValues = $entity->getChanges();
        
        // save nothing if no changes
        if (count($aModifiedValues) == 0) { return; }
        
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
                                'value' => $entity->getValue($sPropertyName, false)
                            );
                            break;

                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                            
                            $aQueryElements[] = (object) array(
                                'key' => $propertyValue->mysqlColumnName,
                                'value' => $entity->getValue($sPropertyName, true)
                            );
                            break;
                    }
                    
                    break;

                case MimotoEntityConfig::PROPERTY_VALUE_MYSQLCONNECTION_TABLE:

                    $modifiedCollection = $aModifiedValues[$sPropertyName];

                    if (count($modifiedCollection->added) > 0)
                    {
                        for ($k = 0; $k < count($modifiedCollection->added); $k++)
                        {
                            // register
                            $newItem = $modifiedCollection->added[$k];
                            
                            // load
                            $stmt = $GLOBALS['database']->prepare(
                                "INSERT INTO ".$propertyValue->mysqlConnectionTable." SET ".
                                "parent_id = :parent_id, ".
                                "parent_property_id = :parent_property_id, ".
                                "child_entity_type_id = :child_entity_type_id, ".
                                "child_id = :child_id, ".
                                "sortindex = :sortindex"
                            );
                            $params = array(
                                ':parent_id' => $newItem->parentId,
                                ':parent_property_id' => $newItem->parentPropertyId,
                                ':child_entity_type_id' => $newItem->childEntityType->id,
                                ':child_id' => $newItem->childId,
                                ':sortindex' => $newItem->sortIndex
                            );

                            $stmt->execute($params);

                            // complete
                            $newItem->id = $GLOBALS['database']->lastInsertId();
                            $newItem->bIsNew = true;
                        }
                    }
                    
                    if (count($modifiedCollection->updated) > 0)
                    {
                        for ($k = 0; $k < count($modifiedCollection->updated); $k++)
                        {
                            // register
                            $existingItem = $modifiedCollection->updated[$k];

                            // load
                            $stmt = $GLOBALS['database']->prepare(
                                'UPDATE '.$propertyValue->mysqlConnectionTable.' SET '.
                                'sortindex = :sortindex '.
                                'WHERE id = :id'
                            );
                            $params = array(
                                ':sortindex' => $existingItem->sortIndex,
                                ':id' => $existingItem->id
                            );
                            $stmt->execute($params);
                        }
                    }
                    
                    if (count($modifiedCollection->removed) > 0)
                    {
                        for ($k = 0; $k < count($modifiedCollection->removed); $k++)
                        {
                            // register
                            $existingItem = $modifiedCollection->removed[$k];

                            // load
                            $stmt = $GLOBALS['database']->prepare(
                                'DELETE FROM '.$propertyValue->mysqlConnectionTable.' WHERE id = :id'
                            );
                            $params = array(
                                ':id' => $existingItem->id
                            );
                            $stmt->execute($params);
                        }
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
            for ($i = 0; $i < count($aQueryElements); $i++)
            {
                $sQuery .= $aQueryElements[$i]->key.' = :'.$aQueryElements[$i]->key;
                $params[':'.$aQueryElements[$i]->key] = $aQueryElements[$i]->value;
                if ($i < count($aQueryElements) - 1) { $sQuery .= ', '; }
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
            $entity = new MimotoEntity($entityConfig->getName(), false);
        }
        else if(!isset($this->_aEntities[$this->getEntityIdentifier($entityConfig->getName(), $nEntityId)]))
        {
            // init
            $entity = new MimotoEntity($entityConfig->getName(), false);
            
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

                        // load
                        $entity->setValue($propertyConfig->name, $result[$propertyValue->mysqlColumnName]);
                        break;

                    case MimotoEntityConfig::PROPERTY_VALUE_MYSQLCONNECTION_TABLE:
                        
                        // init
                        $aCollection = array();

                        // load
                        $stmt = $GLOBALS['database']->prepare(
                            'SELECT * FROM '.$propertyValue->mysqlConnectionTable.
                            ' WHERE parent_id = :parent_id'.
                            ' && parent_property_id = :parent_property_id'.
                            ' ORDER BY sortindex'
                        );
                        $params = array(
                            ':parent_id' => $entity->getId(),
                            ':parent_property_id' => $propertyConfig->id
                        );
                        $stmt->execute($params);

                        // load
                        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                        foreach ($aResults as $row)
                        {
                            // compose
                            $collectionItem = (object) array(
                                'id' => $row['id'],
                                'parentId' => $row['parent_id'],
                                'parentPropertyId' => $row['parent_property_id'],
                                'childId' => $row['child_id'],
                                'childEntityType' => (object) array(
                                    'id' => $row['child_entity_type_id'],
                                    'name' => $GLOBALS['Mimoto.Config']->getEntityNameById($row['child_entity_type_id'])
                                ),
                                'sortIndex' => $row['sortindex']
                            );
                            
                            // store
                            $aCollection[] = $collectionItem;
                        }
                        
                        // register collection data
                        $entity->setValue($propertyConfig->name, $aCollection);

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
    
}

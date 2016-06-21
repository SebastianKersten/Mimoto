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
     * @return ModelClass
     * @throws ModelClassException
     */
    public function get(MimotoEntityConfig $entityConfig, $nEntityId)
    {
        // validate
        if (is_nan($nEntityId) || $nEntityId < 0) { throw new MimotoEntityException("( '-' ) - Sorry, the entity id '$nEntityId' you passed is not a valid. Should be an integer > 0"); }
        
        
//        $pdo->prepare('
//            SELECT * FROM users
//            WHERE username = :username
//            AND email = :email
//            AND last_login > :last_login');
//
//        $params = array(':username' => 'test', ':email' => $mail, ':last_login' => time() - 3600);
//        
//        $pdo->execute($params);
        
        
//        $sql = 'SELECT name, color, calories FROM fruit ORDER BY name';
//    foreach ($conn->query($sql) as $row) {
//        print $row['name'] . "\t";
//        print $row['color'] . "\t";
//        print $row['calories'] . "\n";
//    }
        
        
        // load
        $sQuery = "SELECT * FROM ".$entityConfig->getMySQLTable()." WHERE id=".$nEntityId;
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // verify
        if ($nItemCount !== 1)
        {
            throw new MimotoEntityException("( '-' ) - Sorry, I can't find the the '".$entityConfig->getName()."' entity with id='$nEntityId'");
        }
        else
        {
            // setup
            $entity = $this->createEntity($entityConfig, $result, 0);
            
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
        $sQuery = "SELECT * FROM ".$entityConfig->getMySQLTable();
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            // register
            $aEntities[] = $this->createEntity($entityConfig, $result, $i);
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
        
        // compose
        $sQuery  = ($bIsExistingEntity) ? "UPDATE" : "INSERT";
        $sQuery .= ' '.$entityConfig->getMySQLTable()." SET ";
        
        
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
                    
                            $aQueryElements[] = $propertyValue->mysqlColumnName."='".$entity->getValue($sPropertyName, false)."'";
                            break;

                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                            
                            $aQueryElements[] = $propertyValue->mysqlColumnName."='".$entity->getValue($sPropertyName, true)."'";
                            break;
                    }
                    
                    break;

                case MimotoEntityConfig::PROPERTY_VALUE_MYSQLCONNECTION_TABLE:

                    echo '<b>Storing COLLECTION</b><br><br>';
                    output('$propertyConfig->name', $propertyConfig->name);
                    output('$propertyValue->mysqlConnectionTable', $propertyValue->mysqlConnectionTable);
                    
                    
                    
                    // init
//                    $aCollection = array();
//
//                    // load
//                    $sQuery = "SELECT child_id FROM ".$propertyValue->mysqlConnectionTable.
//                              " WHERE parent_id='".$entity->getId()."' ORDER BY sortindex";
//                    $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
//                    $nItemCount = mysql_num_rows($result);
//
//                    // register
//                    for ($j = 0; $j < $nItemCount; $j++)
//                    {
//                        $aCollection[] = mysql_result($result, $j, 'child_id');
//                    }

                    // register collection data
                    //$entity->setValue($property->name, $aCollection);

                    break;
            }
        }
        
        
        // compose
        for ($i = 0; $i < count($aQueryElements); $i++)
        {
            $sQuery .= $aQueryElements[$i];
            if ($i < count($aQueryElements) - 1) { $sQuery .= ','; }
        }
        
        
        // compose
        if ($bIsExistingEntity)
        {
            $sQuery .= " WHERE id='".$entity->getId()."'";
        }
        else
        {
            $sQuery .= ", created='".date("YmdHis")."'";
        }
        
        
        // execute
        mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        
        
        
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
            $entity = $this->get($entityConfig, mysql_insert_id());
            
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
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Create entity from MySQL result
     * @param MySQL query result $mysqlResult
     * @param int $nIndex
     * @return entity
     */
    private function createEntity(MimotoEntityConfig $entityConfig, $mysqlResult = null, $nIndex = null)
    {
        
        // read
        $nEntityId = (!empty($mysqlResult)) ? mysql_result($mysqlResult, $nIndex, 'id') : null;
        
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
            $entity->setCreated(mysql_result($mysqlResult, $nIndex, 'created'));

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
                        $entity->setValue($propertyConfig->name, mysql_result($mysqlResult, $nIndex, $propertyValue->mysqlColumnName));
                        break;

                    case MimotoEntityConfig::PROPERTY_VALUE_MYSQLCONNECTION_TABLE:
                        
                        // init
                        $aCollection = array();

                        // load
                        $sQuery = "SELECT * FROM ".$propertyValue->mysqlConnectionTable.
                                  " WHERE parent_id='".$entity->getId()."'".
                                  " && parent_property_id='".$propertyConfig->id."' ".
                                  " ORDER BY sortindex";
                        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
                        $nItemCount = mysql_num_rows($result);

                        
                        // register
                        for ($j = 0; $j < $nItemCount; $j++)
                        {
                            $collectionItem = (object) array(
                                'id' => mysql_result($result, $j, 'id'),
                                'parentId' => mysql_result($result, $j, 'parent_id'),
                                'parentPropertyId' => mysql_result($result, $j, 'parent_property_id'),
                                'childId' => mysql_result($result, $j, 'child_id'),
                                'childEntityType' => mysql_result($result, $j, 'child_entity_type'),
                                'sortIndex' => mysql_result($result, $j, 'sortindex')
                            );
                            
                            
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

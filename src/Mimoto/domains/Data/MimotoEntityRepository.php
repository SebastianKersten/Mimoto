<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;



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
        // init
        $entity = new $this->_modelClass();
        
        // send
        return $entity;
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
            $entity = $this->createEntityFromMySQLResult($entityConfig, $result, 0);
            
            // send
            return $entity;
        }
    }
    
    /**
     * Find a collection entities
     * @return Array containing zero or more entities
     */
    public function find(MimotoEntityConfig $entityConfig, $criteria = null)
    {
        
        // init
        $aEntities = array();
        
        // load
        $sQuery = "SELECT * FROM ".$entityConfig->getMySQLTable()." ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            // register
            $aEntities[] = $this->createEntityFromMySQLResult($entityConfig, $result, $i);
        }
        
        // send
        return $aEntities;
    }
    
    /**
     * Store entity
     * @param entity $entity
     */
    public function store($entity)
    {
        
        // determine
        $bIsExistingEntity = (!empty($entity->getId()) && !is_nan($entity->getId())) ? true : false;
        
        
        // compose
        $sQuery  = ($bIsExistingEntity) ? "UPDATE" : "INSERT";
        $sQuery .= ' '.$this->_sMySQLTable." SET ";
        
        // load properties
        $aQueryElements = [];
        foreach ($this->_aProperties as $sPropertyName => $property)
        {
            // compose
            $aQueryElements[] = $property->dbColumn.'="'.$entity->getValue($property->propertyName, false).'"';
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
            $sQuery .= ",created='".date("YmdHis")."'";
        }
        
        // execute
        mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        
        
        
        // --- events ---
        
        
        // broadcast
        if ($bIsExistingEntity)
        {   
            // register
            $sEvent = constant($this->_modelEventClass.'::UPDATED');
        }
        else
        {
            // get entity
            $entity = $this->get(mysql_insert_id());
            
            // register
            $sEvent = constant($this->_modelEventClass.'::CREATED');
        }
        
        
        // setup
        $event = new $this->_modelEventClass($entity, $sEvent);
        
        // broadcast
        $this->_EventService->sendUpdate($event->getType(), $event);
        
        
        
        // --- finish up ---
        
        
        // update
        $entity->markModifiedValuesAsPersistent();
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
    private function createEntityFromMySQLResult(MimotoEntityConfig $entityConfig, $mysqlResult, $nIndex)
    {
        
        // read
        $nEntityId = mysql_result($mysqlResult, $nIndex, 'id');
        
        // make sure an entity is available only one
        if (!isset($this->_aEntities[$this->getEntityIdentifier($entityConfig->getName(), $nEntityId)]))
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
            $property = $entityConfig->getProperty($sPropertyName);
            $propertyValue = $entityConfig->getPropertyValue($sPropertyName);
            
            // setup property
            switch($property->type)
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:
                    
                    $entity->setValueAsProperty($property->name);
                    break;
                
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
                    
                    $entity->setEntityAsProperty($property->name, $property->entityType);
                    break;
                
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:
                    
                    $entity->setEntityAsProperty($property->name, $property->allowedEntityType);
                    break;
            }
            
            // set value
            switch($propertyValue->type)
            {
                case MimotoEntityConfig::PROPERTY_VALUE_MYSQL_COLUMN:
                    
                    // load
                    $entity->setValue($property->name, mysql_result($mysqlResult, $nIndex, $propertyValue->mysqlColumnName));
                    
                    
                    // 1. collection
                    
                    
                    break;
                
                case MimotoEntityConfig::PROPERTY_VALUE_DEFAULT:
                    
                    $entity->setValue($property->name, $propertyValue->value);
                    break;
                
                case MimotoEntityConfig::PROPERTY_VALUE_DUMMY:
                    
                    $entity->setValue($property->name, $propertyValue->value);
                    break;
            }
            
//            switch($property->type)
//            {
//                case self::PROPERTY_TYPE_VALUE:
//                    
//                    
//                    
//                    // register primary entity data
//                    $entity->setValue($property->propertyName, $value);
//                    break;
//                
//                case self::PROPERTY_TYPE_ENTITY:
//                    
//                    // load
//                    $nSubentityId = mysql_result($mysqlResult, $nIndex, $property->dbColumn);
//                    
//                    // register primary entity data
//                    $entity->setValue($property->propertyName, $nSubentityId);
//                    
//                    // register entity delegate
//                    $entity->setValueAsEntityService($property->propertyName, $property->entityService);
//                    
//                    // #todo
//                    // 1. setValue -> new MimotoEntity
//                    // 2. getValue support node-chaining
//                    // 3. MimotoData
//                    
//                    break;
//                
//                case self::PROPERTY_TYPE_COLLECTION:
//                    
//                    // init
//                    $aCollection = array();
//
//                    // load
//                    $sQuery = "SELECT child_id FROM ".$property->dbTableConnections.
//                              " WHERE parent_id='".$entity->getId()."' ORDER BY sortindex";
//                    $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
//                    $nItemCount = mysql_num_rows($result);
//                    
//                    // register
//                    for ($i = 0; $i < $nItemCount; $i++)
//                    {
//                        $aCollection[] = mysql_result($result, $i, 'child_id');
//                    }
//                    
//                    // register collection data
//                    $entity->setValue($property->propertyName, $aCollection);
//                    
//                    
//                    // init
//                    //$collection = new MimotoCollection();
//                    
////                    MimotoGroup = MimotoEntity achtig object zonder entity Id
////                            
////                            
////                    MimotoData.getValue/setValue
////                    MimotoGroup = MimotoData
////                    MimotoEntity.getId / setId
////                    MimotoCollection = 
//                    
//                    break;
//                
//                default:
//                    
//                    echo 'Property type "'.$property->type.'"unknow in MimotoSingleMySQLTableRepository';
//                    
//                    echo "<pre>";
//                    print_r($this);
//                    echo "</pre>";
//                    
//                    die();
//            }
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

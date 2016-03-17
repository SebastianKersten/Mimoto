<?php

// classpath
namespace Mimoto\library\repositories;

// Mimoto classes
use Mimoto\library\repositories\MimotoRepository;
use Mimoto\library\services\MimotoService;


/**
 * MimotoSingleMySQLTableRepository
 *
 * @author Sebastian Kersten
 */
class MimotoSingleMySQLTableRepository extends MimotoRepository
{
    
    /**
     * The EventService
     * @var class
     */
    protected $_EventService;
    
    /**
     * The class that defines the model
     * @var class
     */
    protected $_modelClass;
    
    /**
     * The class that defines the model's exceptions
     * @var class
     */
    protected $_modelExceptionClass;
    
    /**
     * The class that defines the model's event
     * @var class
     */
    protected $_modelEventClass;
    
    /**
     * The MySQL table
     * @var string
     */
    protected $_sMySQLTable;
    
    /**
     * The 'model to MySQL table' map
     * @var array
     */
    protected $_aProperties;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constants --------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    // property types
    const PROPERTY_TYPE_VALUE = 'property.type.value';
    const PROPERTY_TYPE_ENTITY = 'property.type.entity';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Set the class that defines the model
     * 
     * @param class $modelClass
     */
    protected function setModelClass($modelClass) { $this->_modelClass = $modelClass; }
    
    /**
     * Set the class that defines the model's exceptions
     * 
     * @param class $modelExceptionClass
     */
    protected function setModelExceptionClass($modelExceptionClass) { $this->_modelExceptionClass = $modelExceptionClass; }
    
    /**
     * Set the class that defines the model's event
     * 
     * @param class $modelEventClass
     */
    protected function setModelEventClass($modelEventClass) { $this->_modelEventClass = $modelEventClass; }
    
    /**
     * Set the MySQL table
     * 
     * @param string $sMySQLTable
     */
    protected function setMySQLTable($sMySQLTable) { $this->_sMySQLTable = $sMySQLTable; }
    
    /**
     * Set the 'model to MySQL table' map
     * 
     * @param array $aModelToMySQLTableMap
     */
    protected function setModelToMySQLTableMap($aModelToMySQLTableMap) { $this->_aProperties = $aModelToMySQLTableMap; }
    
    
    
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
    // --- Protected methods - setup usage ----------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Set property
     * @param string $sPropertyName
     * @param string $sDBColumn
     * @param mixed $defaultValue
     */
    protected function setProperty($sPropertyName, $sDBColumn, $defaultValue)
    {
        // init
        $property = (object) array();
            
        // setup
        $property->type = self::PROPERTY_TYPE_VALUE;
        $property->propertyName = $sPropertyName;
        $property->dbColumn = $sDBColumn;
        $property->defaultValue = $defaultValue;
         
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set entity as property
     * @param string $sPropertyName
     * @param string $sDBColumn
     * @param mixed $defaultValue
     * @param string $sEntityAsPropertyName
     * @param MimotoService $entityService
     */
    protected function setEntityAsProperty($sPropertyName, $sDBColumn, $defaultValue, MimotoService $entityService = null)
    {
        // init
        $property = (object) array();
            
        // setup
        $property->type = self::PROPERTY_TYPE_ENTITY;
        $property->propertyName = $sPropertyName;
        $property->dbColumn = $sDBColumn;
        $property->defaultValue = $defaultValue;
        $property->entityService = $entityService;
         
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods - runtime usage -----------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Create new entity
     * @return ModelClass
     */
    public function create()
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
    public function get($nId)
    {
        // validate
        if (is_nan($nId) || $nId < 0)
        {
            throw new $this->_modelExceptionClass('Invalid id='.$nId);
        }
        
        // load
        $sQuery = "SELECT * FROM ".$this->_sMySQLTable." WHERE id=".$nId;
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // verify
        if ($nItemCount !== 1)
        {
            throw new $this->_modelExceptionClass('Cannot find entity with id='.$nId);
        }
        else
        {
            // setup
            $entity = $this->createEntityFromMySQLResult($result, 0);
            
            // send
            return $entity;
        }
    }
    
    /**
     * Find a collection entities
     * @return Array containing zero or more entities
     */
    public function find()
    {
        
        // init
        $aEntities = array();
        
        // load
        $sQuery = "SELECT * FROM ".$this->_sMySQLTable." ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            // register
            $aEntities[] = $this->createEntityFromMySQLResult($result, $i);
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
            $aQueryElements[] = $property->dbColumn.'="'.$entity->getValue($property->propertyName).'"';
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
    private function createEntityFromMySQLResult($mysqlResult, $nIndex)
    {
        // init
        $entity = new $this->_modelClass(false);
        
        // register
        $entity->setId(mysql_result($mysqlResult, $nIndex, 'id'));
        $entity->setCreated(mysql_result($mysqlResult, $nIndex, 'created'));
        
        
        // load properties
        foreach ($this->_aProperties as $sPropertyName => $property)
        {
            // load
            $value = mysql_result($mysqlResult, $nIndex, $property->dbColumn);
            
            
            switch($property->type)
            {
                case self::PROPERTY_TYPE_VALUE:
                    
                    // register primary entity data
                    $entity->setValue($property->propertyName, $value);
                    break;
                
                case self::PROPERTY_TYPE_ENTITY:
                    
                    // register primary entity data
                    $entity->setValue($property->propertyName, $value);
                    
                    // register entity delegate
                    $entity->setValueAsEntityService($property->propertyName, $property->entityService);
                    
                    break;
                
                default:
                    
                    echo 'Property type "'.$property->type.'"unknow in MimotoSingleMySQLTableRepository';
                    
                    echo "<pre>";
                    print_r($this);
                    echo "</pre>";
                    
                    die();
            }
        }
        
        // start tracking changes
        $entity->trackChanges();
        
        // send
        return $entity;
    }
    
}

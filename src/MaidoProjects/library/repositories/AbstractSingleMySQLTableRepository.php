<?php

// classpath
namespace library\repositories;


/**
 * ClientRepository
 *
 * @author Sebastian Kersten
 */
class AbstractSingleMySQLTableRepository
{
    
    /**
     * The EventService
     * @var class
     */
    var $_EventService;
    
    /**
     * The class that defines the model
     * @var class
     */
    var $_modelClass;
    
    /**
     * The class that defines the model's exceptions
     * @var class
     */
    var $_modelExceptionClass;
    
    /**
     * The class that defines the model's event
     * @var class
     */
    var $_modelEventClass;
    
    /**
     * The MySQL table
     * @var string
     */
    var $_sMySQLTable;
    
    /**
     * The 'model to MySQL table' map
     * @var array
     */
    var $_aModelToMySQLTableMap;
    
    
    
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
    protected function setModelToMySQLTableMap($aModelToMySQLTableMap) { $this->_aModelToMySQLTableMap = $aModelToMySQLTableMap; }
    
    
    
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
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
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
        for ($i = 0; $i < count($this->_aModelToMySQLTableMap); $i++)
        {
            // read
            $map = $this->_aModelToMySQLTableMap[$i];
            
            // skip primary onCreate
            if (!$bIsExistingEntity && isset($map->primary) && $map->primary) continue;
            
            // prepare
            $getter = 'get'.$map->property;
            
            // compose
            $sQuery .= $map->column.'="'.$entity->$getter().'"';
            if ($i < count($this->_aModelToMySQLTableMap) - 1) { $sQuery .= ','; }
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
        $entity = new $this->_modelClass();
        
        // load properties
        for ($i = 0; $i < count($this->_aModelToMySQLTableMap); $i++)
        {
            // read
            $map = $this->_aModelToMySQLTableMap[$i];
            
            // prepare
            $setter = 'set'.$map->property;
            
            // register
            $entity->$setter(mysql_result($mysqlResult, $nIndex, $map->column));
        }

        // send
        return $entity;
    }
    
}

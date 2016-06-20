<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;



/**
 * MimotoEntityConfigRepository
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityConfigRepository
{
    
    /**
     * The requested entities
     * @var array
     */
    private $_aEntityConfigs = [];
    private $_aEntities;
    
    
    const DBTABLE_ENTITIES = '_mimoto_entities';
    const DBTABLE_ENTITIES_PROPERTIES = '_mimoto_entities_properties';
    const DBTABLE_ENTITIES_PROPERTIES_OPTIONS = '_mimoto_entities_properties_options';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // prepare
        $this->loadAllEntityConfigData();
    }
    
        
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    public function getAllEntityConfigs()
    {
        return $this->_aEntityConfigs;
    }
    
    public function getEntityConfigByName($sEntityConfigName)
    {
        // load and send
        if (isset($this->_aEntityConfigs[$sEntityConfigName])) { return $this->_aEntityConfigs[$sEntityConfigName]; }
        
        // build and send
        return $this->_aEntityConfigs[$sEntityConfigName] = $this->composeEntityConfig($sEntityConfigName);
    }
    
    
    public function getAllEntityConfigData()
    {
        return $this->_aEntities;
    }
    
    
    /**
     * Create new entityConfig
     * @return MimotoEntityConfig
     */
    public function create()
    {
        // init and send
        return new MimotoEntityConfig();
    }
    
    /**
     * Get single entity config by id
     * @param int $nId
     * @return ModelClass
     * @throws ModelClassException
     */
    public function get($nId)
    {
        // validate
        if (is_nan($nId) || $nId < 0) { throw new MimotoEntityException("( '-' ) - Sorry, the entity config id '$nId' you passed is not a valid. Should be an integer > 0"); }
        
        for ($i = 0; $i < count($this->_aEntityConfigs); $i++)
        {
            $entityConfig = $this->_aEntityConfigs[$i];
            
           if ($entityConfig->getId() === $nId) { return $entityConfig; }
        }
    }
    
    /**
     * Find a collection entities
     * @return Array containing zero or more entities
     */
    public function find(MimotoEntityConfig $entityConfig, $criteria = null)
    {
        
    }
    
    /**
     * Store entity
     * @param entity $entity
     */
    public function store($entity)
    {
        
       
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    
    private function loadAllEntityConfigData()
    {
        
        // 1. load from cache if present
        // 2. store in cache onLoad
        
        
        // init
        $aAllProperties = [];
        $aAllOptions = [];
        
        
        // load
        $sQueryEntities = "SELECT * FROM ".self::DBTABLE_ENTITIES;
        $resultEntities = mysql_query($sQueryEntities) or die('Query failed: ' . mysql_error());
        $nEntityCount = mysql_num_rows($resultEntities);
        
        // store
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            $entity = (object) array(
                'id' => mysql_result($resultEntities, $i, 'id'),
                'name' => mysql_result($resultEntities, $i, 'name'),
                'extends_id' => mysql_result($resultEntities, $i, 'extends_id'),
                'created' => mysql_result($resultEntities, $i, 'created'),
                'properties' => []
            );
            
            $this->_aEntities[] = $entity;
        }
        
        // load
        $sQueryProperties = "SELECT * FROM ".self::DBTABLE_ENTITIES_PROPERTIES;
        $resultProperties = mysql_query($sQueryProperties) or die('Query failed: ' . mysql_error());
        $nPropertyCount = mysql_num_rows($resultProperties);
        
        // store
        for ($i = 0; $i < $nPropertyCount; $i++)
        {
            $property = (object) array(
                'id' => mysql_result($resultProperties, $i, 'id'),
                'name' => mysql_result($resultProperties, $i, 'name'),
                'type' => mysql_result($resultProperties, $i, 'type'),
                'parent_id' => mysql_result($resultProperties, $i, 'parent_id'),
                'sortindex' => mysql_result($resultProperties, $i, 'sortindex'),
                'created' => mysql_result($resultProperties, $i, 'created'),
                'options' => []
            );
            
            $nEntityConfigId = mysql_result($resultProperties, $i, 'entity_id');
            
            $aAllProperties[$nEntityConfigId][] = $property;
        }
        
        // load
        $sQueryOptions = "SELECT * FROM ".self::DBTABLE_ENTITIES_PROPERTIES_OPTIONS;
        $resultOptions = mysql_query($sQueryOptions) or die('Query failed: ' . mysql_error());
        $nOptionCount = mysql_num_rows($resultOptions);
        
        
        // store
        for ($i = 0; $i < $nOptionCount; $i++)
        {
            // init
            $option = (object) array(
                'id' => mysql_result($resultOptions, $i, 'id'),
                'name' => mysql_result($resultOptions, $i, 'name'),
                'value' => mysql_result($resultOptions, $i, 'value'),
                'created' => mysql_result($resultOptions, $i, 'created')
            );
            
            $nEntityConfigPropertyId = mysql_result($resultOptions, $i, 'property_id');
            
            // store
            $aAllOptions[$nEntityConfigPropertyId][$option->name] = $option;
        }
        
        // compose
        for ($i = 0; $i < count($this->_aEntities); $i++)
        {
            // read
            $entity = $this->_aEntities[$i];
            
            // store
            $entity->properties = $aAllProperties[$entity->id];
            
            // store
            for ($j = 0; $j < count($entity->properties); $j++)
            {
                // read
                $property = $entity->properties[$j];
                
                // store
                $property->options = $aAllOptions[$property->id];
            }
        }
    }
    
    /**
     * Create entity config from MySQL result
     * @param MySQL query result $mysqlResult
     * @param int $nIndex
     * @return entity
     */
    private function composeEntityConfig($sEntityConfigName)
    {
        
        // compose
        for ($i = 0; $i < count($this->_aEntities); $i++)
        {   
            // read
            $entity = $this->_aEntities[$i];
            
            // skip if not the requested one
            if ($entity->name != $sEntityConfigName) { continue; }
            
            
            // init
            $entityConfig = new MimotoEntityConfig();
            
            // setup
            $entityConfig->setId($entity->id);
            $entityConfig->setName($entity->name);
            $entityConfig->setMySQLTable($entity->name);
            
            // store
            for ($j = 0; $j < count($entity->properties); $j++)
            {
                // read
                $property = $entity->properties[$j];
                
                
                switch($property->type)
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                        $entityConfig->setValueAsProperty($property->name);

                        // connect entity to data source
                        $entityConfig->connectPropertyToMySQLColumn($property->name, $property->name);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // prepare
                        $property->options['entityType']->value = $this->getEntityNameById($property->options['entityType']->value);
                        
                        // setup
                        $entityConfig->setEntityAsProperty($property->name, $property->options);

                        // connect entity to data source
                        $entityConfig->connectPropertyToMySQLColumn($property->name, $property->name.'_id');
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // prepare
                        $property->options['allowedEntityType']->value = $this->getEntityNameById($property->options['allowedEntityType']->value);
                        
                        // setup
                        $entityConfig->setCollectionAsProperty($property->name, $property->options);
                        
                        // compose
                        //$sConnectionTable = $this->getEntityNameById($entity->id).'_'.$property->options['allowedEntityType']->value;
                        $sConnectionTable = $this->getEntityNameById($entity->id).'_connections';
                        
                        // connect entity to data source
                        $entityConfig->connectPropertyToMySQLConnectionTable($property->name, $sConnectionTable);
                        break;
                }
            }
            
            // send
            return $entityConfig;
        }
        
        // send error
        return false;
    }
    
    
    private function getEntityNameById($nId)
    {
        $nItemCount = count($this->_aEntities);
        for ($i = 0; $i < $nItemCount; $i++)
        {
            $entity = $this->_aEntities[$i];
            
            if ($entity->id == $nId) { return $entity->name; }
        }
    }
}

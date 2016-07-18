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
    
    
    const DBTABLE_ENTITY = '_mimoto_entity';
    const DBTABLE_ENTITY_PROPERTY = '_mimoto_entity_property';
    const DBTABLE_ENTITY_PROPERTY_SETTINGS = '_mimoto_entity_property_settings';
    
    
    
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
        $aAllSettings = [];


        // load all entities
        $sql = 'SELECT * FROM '.self::DBTABLE_ENTITY;
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $entity = (object) array(
                'id' => $row['id'],
                'name' => $row['name'],
                'extends_id' => $row['extends_id'],
                'created' => $row['created'],
                'properties' => []
            );

            // store
            $this->_aEntities[] = $entity;
        }

        // load all properties
        $sql = 'SELECT * FROM '.self::DBTABLE_ENTITY_PROPERTY;
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $property = (object) array(
                'id' => $row['id'],
                'name' => $row['name'],
                'type' => $row['type'],
                'parent_id' => $row['parent_id'],
                'sortindex' => $row['sortindex'],
                'created' => $row['created'],
                'settings' => []
            );

            // load
            $nEntityConfigId = $row['entity_id'];

            // store
            $aAllProperties[$nEntityConfigId][] = $property;
        }

        // load all settings
        $sql = 'SELECT * FROM '.self::DBTABLE_ENTITY_PROPERTY_SETTINGS;
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $setting = (object) array(
                'id' => $row['id'],
                'name' => $row['name'],
                'value' => $row['value'],
                'created' => $row['created']
            );

            // load
            $nEntityConfigPropertyId = $row['property_id'];
            
            // store
            $aAllSettings[$nEntityConfigPropertyId][$setting->name] = $setting;
        }
        
        
        
        // --- compose ---
        
        
        for ($i = 0; $i < count($this->_aEntities); $i++)
        {
            // read
            $entity = $this->_aEntities[$i];
            
            // validate
            if (!isset($aAllProperties[$entity->id])) { error("Oops, the entity config named '$entity->name' doesn't seem to have any properties"); }
            
            // store
            $entity->properties = $aAllProperties[$entity->id];
            
            // store
            for ($j = 0; $j < count($entity->properties); $j++)
            {
                // read
                $property = $entity->properties[$j];
                
                // validate
                if (!isset($aAllSettings[$property->id])) { error("Oops, the property '$property->name' of entity config with '$entity->name' doesn't seem to have any settings"); }
                
                // store
                $property->settings = $aAllSettings[$property->id];
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

                        $entityConfig->setValueAsProperty($property->name, $property->id);

                        // connect entity to data source
                        $entityConfig->connectPropertyToMySQLColumn($property->name, $property->name);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // prepare
                        $property->settings['entityType']->value = (object) array(
                            'id' => $property->settings['entityType']->value,
                            'name' => $this->getEntityNameById($property->settings['entityType']->value)
                        );
                        
                        // setup
                        $entityConfig->setEntityAsProperty($property->name, $property->id, $property->settings);

                        // connect entity to data source
                        $entityConfig->connectPropertyToMySQLColumn($property->name, $property->name.'_id');
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // prepare
                        $property->settings['allowedEntityTypes']->value = json_decode($property->settings['allowedEntityTypes']->value);
                        for ($k = 0; $k < count($property->settings['allowedEntityTypes']->value); $k++)
                        {
                            $property->settings['allowedEntityTypes']->value[$k] = (object) array(
                                'id' => $property->settings['allowedEntityTypes']->value[$k],
                                'name' => $this->getEntityNameById($property->settings['allowedEntityTypes']->value[$k])
                            );
                        }
                        
                        // setup
                        $entityConfig->setCollectionAsProperty($property->name, $property->id, $property->settings);
                        
                        // compose
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
    
    
    public function getEntityNameById($nId)
    {
        $nItemCount = count($this->_aEntities);
        for ($i = 0; $i < $nItemCount; $i++)
        {
            $entity = $this->_aEntities[$i];
            
            if ($entity->id == $nId) { return $entity->name; }
        }
    }
    
    public function getEntityIdByName($sName)
    {
        $nItemCount = count($this->_aEntities);
        for ($i = 0; $i < $nItemCount; $i++)
        {
            $entity = $this->_aEntities[$i];
            
            if ($entity->name == $sName) { return $entity->id; }
        }
    }
}

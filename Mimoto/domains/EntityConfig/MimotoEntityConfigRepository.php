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
    const DBTABLE_ENTITY_CONNECTIONS = '_mimoto_entity_connections';
    const DBTABLE_ENTITYPROPERTY = '_mimoto_entityproperty';
    const DBTABLE_ENTITYPROPERTY_CONNECTIONS = '_mimoto_entityproperty_connections';
    const DBTABLE_ENTITYPROPERTYSETTING = '_mimoto_entitypropertysetting';

    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // prepare
        $this->_aEntities = $this->initCoreConfigurations();
        $this->loadProjectConfigurations();
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
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    
    private function loadProjectConfigurations()
    {
        
        // 1. load from cache if present
        // 2. store in cache onLoad
        
        
        // init
        $aAllEntity = [];
        $aAllEntity_Connections = [];
        $aAllEntityProperties = [];
        $aAllEntityProperty_Connections = [];
        $aAllEntityPropertySettings = [];


        // load all entities
        $sql = 'SELECT * FROM '.self::DBTABLE_ENTITY;
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $entity = (object) array(
                'id' => $row['id'],
                'name' => $row['name'],
                'created' => $row['created'],
                'properties' => []
            );

            // store
            $aAllEntity[] = $entity;
        }

        // load all connections
        $sql = 'SELECT * FROM '.self::DBTABLE_ENTITY_CONNECTIONS.' ORDER BY parent_id ASC, sortindex ASC';
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $connection = (object) array(
                'id' => $row['id'],                                     // the id of the connection
                'parent_id' => $row['parent_id'],                       // the id of the parent entity
                'parent_property_id' => $row['parent_property_id'],     // the id of the parent entity's property
                'child_entity_type_id' => $row['child_entity_type_id'], // the id of the child's entity config
                'child_id' => $row['child_id'],                // the id of the child entity connected to the parent
                'sortindex' => $row['sortindex']                        // the sortindex
            );

            // load
            $nEntityId = $row['parent_id'];

            // store
            $aAllEntity_Connections[$nEntityId][] = $connection;
        }

        // load all properties
        $sql = 'SELECT * FROM '.self::DBTABLE_ENTITYPROPERTY;
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $property = (object) array(
                'id' => $row['id'],
                'name' => $row['name'],
                'type' => $row['type'],
                'created' => $row['created'],
                'settings' => []
            );

            // store
            $aAllEntityProperties[$row['id']] = $property;
        }

        // load all connections
        $sql = 'SELECT * FROM '.self::DBTABLE_ENTITYPROPERTY_CONNECTIONS.' ORDER BY parent_id ASC, sortindex ASC';
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $connection = (object) array(
                'id' => $row['id'],                                     // the id of the connection
                'parent_id' => $row['parent_id'],                       // the id of the parent entity
                'parent_property_id' => $row['parent_property_id'],     // the id of the parent entity's property
                'child_entity_type_id' => $row['child_entity_type_id'], // the id of the child's entity config
                'child_id' => $row['child_id'],                // the id of the child entity connected to the parent
                'sortindex' => $row['sortindex']                        // the sortindex
            );

            // load
            $nPropertyId = $row['parent_id'];

            // store
            $aAllEntityProperty_Connections[$nPropertyId][] = $connection;
        }

        // load all settings
        $sql = 'SELECT * FROM '.self::DBTABLE_ENTITYPROPERTYSETTING;
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $setting = (object) array(
                'id' => $row['id'],
                'key' => $row['key'],
                'type' => $row['type'],
                'value' => $row['value'],
                'created' => $row['created']
            );

            // load
            $nEntityPropertySettingId = $row['id'];

            // store
            $aAllEntityPropertySettings[$nEntityPropertySettingId] = $setting;
        }


        // --- compose ---


        for ($i = 0; $i < count($aAllEntity); $i++)
        {
            // read
            $entity = $aAllEntity[$i];
            
            // validate
            if (!isset($aAllEntity_Connections[$entity->id]))
            {
                // remove
                array_splice($aAllEntity, $i, 1);
                continue;
            }

            // register
            $aEntity_Connections = $aAllEntity_Connections[$entity->id];

            // store
            for ($k = 0; $k < count($aEntity_Connections); $k++)
            {
                // register
                $connection = $aEntity_Connections[$k];

                // validate
                if (!isset($aAllEntityProperties[$connection->child_id])) { error("Oops, the entity config named '$entity->name' seems to miss a property"); };

                // register
                $entity->properties[] = $aAllEntityProperties[$connection->child_id];
            }

            // store
            for ($j = 0; $j < count($entity->properties); $j++)
            {
                // read
                $property = $entity->properties[$j];
                
                // validate
                if (!isset($aAllEntityPropertySettings[$property->id]) || !isset($aAllEntityProperty_Connections[$property->id])) {
                    // remove
                    array_splice($aAllEntity, $i, 1);
                    continue 2;
                }


                // register
                $aEntityProperty_Connections = $aAllEntityProperty_Connections[$property->id];

                // store
                for ($k = 0; $k < count($aEntityProperty_Connections); $k++)
                {
                    // register
                    $connection = $aEntityProperty_Connections[$k];

                    // setting
                    $setting = $aAllEntityPropertySettings[$connection->child_id];

                    // store
                    $property->settings[$setting->key] = $setting;
                }
            }

            // store
            $this->_aEntities[] = $entity;
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



    private function initCoreConfigurations()
    {

        // setup
        $aEntities = [
            (object) array(
                'id' => 'eid1',
                'name' => '_mimoto_entity',
                'created' => '1976-10-19 23:15:00',
                'properties' => [
                    (object) array(
                        'id' => 'pid1',
                        'name' => 'name',
                        'type' => 'value',
                        'created' => '1976-10-19 23:15:00',
                        'settings' => [
                             (object) array(
                                'id' => 'sid1',
                                 'key' => 'type',
                                 'type' => 'value',
                                 'value' => 'textline',
                                 'created' => '1976-10-19 23:15:00'
                             )
                        ]
                    ),
                    (object) array(
                        'id' => 'pid2',
                        'name' => 'properties',
                        'type' => 'collection',
                        'created' => '1976-10-19 23:15:00',
                        'settings' => [
                            'allowedEntityTypes' => (object) array(
                                'id' => 'sid2',
                                'key' => 'allowedEntityTypes',
                                'type' => 'array',
                                'value' => '["eid2"]',
                                'created' => '1976-10-19 23:15:00'
                            ),
                            'allowDuplicates' => (object) array(
                                'id' => 'sid3',
                                'key' => 'allowDuplicates',
                                'type' => 'boolean',
                                'value' => 'false',
                                'created' => '1976-10-19 23:15:00'
                            )
                        ]
                    )
                ]
            ),
            (object) array(
                'id' => 'eid2',
                'name' => '_mimoto_entityproperty',
                'created' => '1976-10-19 23:15:00',
                'properties' => [
                    (object) array(
                        'id' => 'pid3',
                        'name' => 'name',
                        'type' => 'value',
                        'created' => '1976-10-19 23:15:00',
                        'settings' => [
                            'type' => (object) array(
                                'id' => 'sid4',
                                'key' => 'type',
                                'type' => 'value',
                                'value' => 'textline',
                                'created' => '1976-10-19 23:15:00'
                            )
                        ]
                    ),
                    (object) array(
                        'id' => 'pid4',
                        'name' => 'type',
                        'type' => 'value',
                        'created' => '1976-10-19 23:15:00',
                        'settings' => [
                            'type' => (object) array(
                                'id' => 'sid5',
                                'key' => 'type',
                                'type' => 'value',
                                'value' => 'textline',
                                'created' => '1976-10-19 23:15:00'
                            )
                        ]
                    ),
                    (object) array(
                        'id' => 'pid5',
                        'name' => 'settings',
                        'type' => 'collection',
                        'created' => '1976-10-19 23:15:00',
                        'settings' => [
                            'allowedEntityTypes' => (object) array(
                                'id' => 'sid6',
                                'key' => 'allowedEntityTypes',
                                'type' => 'array',
                                'value' => '["eid3"]',
                                'created' => '1976-10-19 23:15:00'
                            ),
                            'allowDuplicates' => (object) array(
                                'id' => 'sid7',
                                'key' => 'allowDuplicates',
                                'type' => 'boolean',
                                'value' => 'false',
                                'created' => '1976-10-19 23:15:00'
                            )
                        ]
                    )
                ]
            ),
            (object) array(
                'id' => 'eid3',
                'name' => '_mimoto_entitypropertysetting',
                'created' => '1976-10-19 23:15:00',
                'properties' => [
                    (object) array(
                        'id' => 'pid6',
                        'name' => 'key',
                        'type' => 'value',
                        'created' => '1976-10-19 23:15:00',
                        'settings' => [
                            'type' => (object) array(
                                'id' => 'sid8',
                                'key' => 'type',
                                'type' => 'value',
                                'value' => 'textline',
                                'created' => '1976-10-19 23:15:00'
                            )
                        ]
                    ),
                    (object) array(
                        'id' => 'pid7',
                        'name' => 'type',
                        'type' => 'value',
                        'created' => '1976-10-19 23:15:00',
                        'settings' => [
                            'type' => (object) array(
                                'id' => 'sid9',
                                'key' => 'type',
                                'type' => 'value',
                                'value' => 'textline',
                                'created' => '1976-10-19 23:15:00'
                            )
                        ]
                    ),
                    (object) array(
                        'id' => 'pid8',
                        'name' => 'value',
                        'type' => 'value',
                        'created' => '1976-10-19 23:15:00',
                        'settings' => [
                            'type' => (object) array(
                                'id' => 'sid10',
                                'key' => 'type',
                                'type' => 'value',
                                'value' => 'textline',
                                'created' => '1976-10-19 23:15:00'
                            )
                        ]
                    )
                ]
            )
        ];

        // send
        return $aEntities;
    }
}

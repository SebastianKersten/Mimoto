<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Core\CoreConfig;
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

    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // prepare
        $this->_aEntities = CoreConfig::getCoreEntityConfigs();
        $this->loadEntityConfigurations();
        $this->extendEntityConfigurations();
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

    public function getPropertyNameById($nId)
    {
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            $entity = $this->_aEntities[$i];

            $nPropertyCount = count($entity->properties);
            for ($j = 0; $j < $nPropertyCount; $j++)
            {
                $property = $entity->properties[$j];

                if ($property->id == $nId) { return $property->name; }
            }
        }
    }

    public function entityIsTypeOf($sTypeOfEntity, $sTypeToCompare)
    {
        // search
        for ($i = 0; $i < count($this->_aEntities); $i++)
        {
            // register
            $entity = $this->_aEntities[$i];

            if ($entity->name == $sTypeOfEntity)
            {
                if (!isset($entity->typeOf) || empty($entity->typeOf))
                {
                    return ($sTypeOfEntity == $sTypeToCompare);
                }
                else
                {
                    return in_array($sTypeToCompare, $entity->typeOfAsNames);
                }
            }
        }
    }

    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Load entity configurations
     */
    private function loadEntityConfigurations()
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
        $sql = 'SELECT * FROM '.CoreConfig::MIMOTO_ENTITY;
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $entity = (object) array(
                'id' => $row['id'],
                'created' => $row['created'],
                'name' => $row['name'],
                'extends' => null,
                'typeOf' => [],
                'properties' => []
            );

            // store
            $aAllEntity[] = $entity;
        }

        // load all connections
        $sql = 'SELECT * FROM '.CoreConfig::MIMOTO_CONNECTIONS_CORE .' WHERE parent_entity_type_id="'.CoreConfig::MIMOTO_ENTITY.'" ORDER BY parent_id ASC, sortindex ASC';
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $connection = (object) array(
                'id' => $row['id'],                                         // the id of the connection
                'parent_entity_type_id' => $row['parent_entity_type_id'],   // the id of the parent's entity config
                'parent_property_id' => $row['parent_property_id'],         // the id of the parent entity's property
                'parent_id' => $row['parent_id'],                           // the id of the parent entity
                'child_entity_type_id' => $row['child_entity_type_id'],     // the id of the child's entity config
                'child_id' => $row['child_id'],                             // the id of the child entity connected to the parent
                'sortindex' => $row['sortindex']                            // the sortindex
            );

            // load
            $nEntityId = $row['parent_id'];

            // store
            $aAllEntity_Connections[$nEntityId][] = $connection;
        }

        // load all properties
        $sql = 'SELECT * FROM '.CoreConfig::MIMOTO_ENTITYPROPERTY;
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
        $sql = 'SELECT * FROM '.CoreConfig::MIMOTO_CONNECTIONS_CORE.' WHERE parent_entity_type_id="'.CoreConfig::MIMOTO_ENTITYPROPERTY.'" ORDER BY parent_id ASC, sortindex ASC';
        foreach ($GLOBALS['database']->query($sql) as $row)
        {
            // compose
            $connection = (object) array(
                'id' => $row['id'],                                         // the id of the connection
                'parent_entity_type_id' => $row['parent_entity_type_id'],   // the id of the parent's entity config
                'parent_property_id' => $row['parent_property_id'],         // the id of the parent entity's property
                'parent_id' => $row['parent_id'],                           // the id of the parent entity
                'child_entity_type_id' => $row['child_entity_type_id'],     // the id of the child's entity config
                'child_id' => $row['child_id'],                             // the id of the child entity connected to the parent
                'sortindex' => $row['sortindex']                            // the sortindex
            );

            // load
            $nPropertyId = $row['parent_id'];

            // store
            $aAllEntityProperty_Connections[$nPropertyId][] = $connection;
        }

        // load all settings
        $sql = 'SELECT * FROM '.CoreConfig::MIMOTO_ENTITYPROPERTYSETTING;
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
                // skip
                continue;
            }

            // register
            $aEntity_Connections = $aAllEntity_Connections[$entity->id];

            // store
            for ($k = 0; $k < count($aEntity_Connections); $k++)
            {
                // register
                $connection = $aEntity_Connections[$k];

                switch($connection->parent_property_id)
                {
                    case '_mimoto_entity__extends':

                        $entity->extends = $connection->child_id;
                        break;

                    case '_mimoto_entity__properties':

                        // validate
                        if (!isset($aAllEntityProperties[$connection->child_id])) { error("Oops, the entity config named '$entity->name' seems to miss a property"); };

                        // register
                        $entity->properties[] = $aAllEntityProperties[$connection->child_id];

                        break;
                }
            }

            // store
            for ($j = 0; $j < count($entity->properties); $j++)
            {
                // read
                $property = $entity->properties[$j];
                
                // validate
                if (!isset($aAllEntityPropertySettings[$property->id]) || !isset($aAllEntityProperty_Connections[$property->id]))
                {
                    // skip
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
     * Extend entity configurations
     */
    private function extendEntityConfigurations()
    {
        // search
        for ($i = 0; $i < count($this->_aEntities); $i++)
        {
            // register
            $entity = $this->_aEntities[$i];

            // check
            if (!empty($entity->extends))
            {
                // build
                $aExtensions = array_merge([$entity->id], $this->buildExtensionStack($entity->extends, []));

                $entity->typeOf = $aExtensions;

                $entity->typeOfAsNames = [];
                for ($k = 0; $k < count($aExtensions); $k++)
                {
                    $entity->typeOfAsNames[$k] = $this->getEntityNameById($aExtensions[$k]);
                }

                for ($j = count($aExtensions) - 1; $j > 0; $j--)
                {
                    // find
                    $baseEntity = $this->findEntityById($aExtensions[$j]);

                    // combine
                    array_splice($entity->properties, count($entity->properties) - 1, 0, $baseEntity->properties);
                }
            }
        }
    }

    /**
     * Build extension path
     * @param $baseId The entity that is being extended
     * @param $aExtensions An array containing the stack of extensions
     * @return array
     */
    private function buildExtensionStack($baseId, $aExtensions)
    {
        for ($i = 0; $i < count($this->_aEntities); $i++)
        {
            // register
            $entity = $this->_aEntities[$i];

            if ($entity->id == $baseId)
            {
                if (!empty($entity->extends))
                {
                    /// compose
                    $aExtensions = array_merge($aExtensions, $this->buildExtensionStack($entity->extends, $aExtensions));
                }

                break;
            }
        }

        /// compose
        array_unshift($aExtensions, $baseId);

        // send
        return $aExtensions;
    }

    private function findEntityById($xEntityId)
    {
        // compose
        for ($i = 0; $i < count($this->_aEntities); $i++) {
            // read
            $entity = $this->_aEntities[$i];

            // skip if not the requested one
            if ($entity->id == $xEntityId) return $entity;
        }

        // oh oh
        die ("MimotoEntityConfigRepository says: Can't find the entity with id=".$xEntityId);
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

            // compose
            if (substr($this->getEntityNameById($entity->id), 0, 16) == '_MimotoAimless__')
            {
                $sConnectionTable = CoreConfig::MIMOTO_CONNECTIONS_CORE;
            }
            else
            {
                $sConnectionTable = CoreConfig::MIMOTO_CONNECTIONS_PROJECT;
            }


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
                        $property->settings['allowedEntityType']->value = (object) array(
                            'id' => $property->settings['allowedEntityType']->value,
                            'name' => $this->getEntityNameById($property->settings['allowedEntityType']->value)
                        );
                        
                        // setup
                        $entityConfig->setEntityAsProperty($property->name, $property->id, $property->settings);

                        // connect entity to data source
                        $entityConfig->connectPropertyToMySQLConnectionTable($property->name, $sConnectionTable);
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

}

<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;
use Mimoto\Mimoto;
use Mimoto\Log\MimotoLogService;


/**
 * MimotoEntityConfigRepository
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityConfigRepository
{

    // services
    private $_MimotoLogService;

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
        // store
        //$this->_MimotoLogService = new MimotoLogService($GLOBALS['Mimoto.Data']); // #todo temp

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

        $nEntityConfigCount = count($this->_aEntityConfigs);
        for ($i = 0; $i < $nEntityConfigCount; $i++)
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
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
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

    public function getEntityNameByPropertyId($nId)
    {
        // search
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $this->_aEntities[$i];

            $nEntityPropertyCount = count($entity->properties);
            for ($j = 0; $j < $nEntityPropertyCount; $j++)
            {
                // register
                $property = $entity->properties[$j];

                // check
                if ($property->id == $nId)
                {
                    return $entity->name;
                }

            }
        }

        $GLOBALS['Mimoto.Log']->error('Incomplete entity config', "No entity found which contains a property with <b>id=".$nId."</b>", true);
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
        $aAllEntity = $this->loadRawEntityData();
        $aAllEntity_Connections = $this->loadRawConnectionData(CoreConfig::MIMOTO_ENTITY);
        $aAllEntityProperties = $this->loadRawEntityPropertyData();
        $aAllEntityProperty_Connections = $this->loadRawConnectionData(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $aAllEntityPropertySettings = $this->loadRawEntityPropertySettingData();
        $aAllEntityPropertySetting_Connections = $this->loadRawConnectionData(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);



        // --- compose ---


        while(count($aAllEntity) > 0)
        {
            // read and cleanup
            $entity = array_shift($aAllEntity);

            // validate
            if (!isset($aAllEntity_Connections[$entity->id]))
            {
                // notify
                //$this->_MimotoLogService->silent('Data construction error - properties', "The entity with name '".$entity->name."' has no properties", 'MimotoEntityConfigRepository');

                // skip
                continue;
            }


            // register
            $aEntity_Connections = $aAllEntity_Connections[$entity->id];

            // cleanup
            unset($aAllEntity_Connections[$entity->id]);


            // store
            while(count($aEntity_Connections) > 0)
            {
                // register and cleanup
                $connection = array_shift($aEntity_Connections);

                switch($connection->parent_property_id)
                {
                    case CoreConfig::MIMOTO_ENTITY.'--extends':

                        $entity->extends = $connection->child_id;
                        break;

                    case CoreConfig::MIMOTO_ENTITY.'--properties':

                        // validate
                        if (!isset($aAllEntityProperties[$connection->child_id])) { error("Oops, the entity config named '$entity->name' seems to miss a property"); };

                        // register
                        $entity->properties[] = $aAllEntityProperties[$connection->child_id];
                        break;
                }
            }

            // store
            $nPropertyCount = count($entity->properties);
            for ($nPropertyIndex = 0; $nPropertyIndex < $nPropertyCount; $nPropertyIndex++)
            {
                // read
                $property = $entity->properties[$nPropertyIndex];
                
                // validate
                if (!isset($aAllEntityPropertySettings[$property->id]) || !isset($aAllEntityProperty_Connections[$property->id]))
                {
                    // notify
                    //$this->_MimotoLogService->silent('Data construction error - propertysettings', "The property with name '".$property->name."' has no settings", 'MimotoEntityConfigRepository');

                    // skip
                    continue 2;
                }


                // register
                $aEntityProperty_Connections = $aAllEntityProperty_Connections[$property->id];

                // cleanup
                unset($aAllEntityProperty_Connections[$property->id]);


                // store
                while(count($aEntityProperty_Connections) > 0)
                {
                    // register and cleanup
                    $connection = array_shift($aEntityProperty_Connections);

                    switch($connection->parent_property_id)
                    {
                        case CoreConfig::MIMOTO_ENTITYPROPERTY.'--settings':

                            // setting
                            $setting = $aAllEntityPropertySettings[$connection->child_id];

                            // cleanup
                            unset($aAllEntityPropertySettings[$connection->child_id]);


                            // filter
                            if ($setting->key == MimotoEntityConfig::OPTION_ENTITY_ALLOWEDENTITYTYPE || $setting->key == MimotoEntityConfig::OPTION_COLLECTION_ALLOWEDENTITYTYPES)
                            {

                                // validate
                                if (!isset($aAllEntityPropertySetting_Connections[$setting->id])) {
                                    // notify
                                    //$this->_MimotoLogService->silent('', '');

                                    // skip
                                    continue 3;
                                }

                                // register
                                $aEntityPropertySetting_Connections = $aAllEntityPropertySetting_Connections[$setting->id];

                                // cleanup
                                unset($aAllEntityPropertySetting_Connections[$setting->id]);


                                switch($setting->key)
                                {
                                    case MimotoEntityConfig::OPTION_ENTITY_ALLOWEDENTITYTYPE:

                                        // store
                                        while(count($aEntityPropertySetting_Connections) > 0)
                                        {
                                            // register and cleanup
                                            $connection = array_shift($aEntityPropertySetting_Connections);

                                            // validate
                                            if ($connection->parent_property_id !== CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityType') continue;

                                            // store
                                            $setting->value = $connection->child_id;
                                        }

                                        break;

                                    case MimotoEntityConfig::OPTION_COLLECTION_ALLOWEDENTITYTYPES:

                                        // init
                                        $setting->value = [];

                                        // store
                                        while(count($aEntityPropertySetting_Connections) > 0)
                                        {
                                            // register and cleanup
                                            $connection = array_shift($aEntityPropertySetting_Connections);

                                            // validate
                                            if ($connection->parent_property_id !== CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityTypes') continue;

                                            // store
                                            $setting->value[] = $connection->child_id;
                                        }
                                        break;
                                }
                            }



                            // store
                            $property->settings[$setting->key] = $setting;

                            break;
                    }
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
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
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

                $nExtensionCount = count($aExtensions);
                for ($k = 0; $k < $nExtensionCount; $k++)
                {
                    $entity->typeOfAsNames[$k] = $this->getEntityNameById($aExtensions[$k]);
                }

                for ($j = $nExtensionCount - 1; $j > 0; $j--)
                {
                    // find
                    $baseEntity = $this->findEntityById($aExtensions[$j]);

                    // combine
                    $nPropertyCount = count($entity->properties);
                    array_splice($entity->properties, $nPropertyCount - 1, 0, $baseEntity->properties);
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
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
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
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++) {
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
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
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
            if (substr($this->getEntityNameById($entity->id), 0, 16) == CoreConfig::CORE_PREFIX)
            {
                $sConnectionTable = CoreConfig::MIMOTO_CONNECTIONS_CORE;
            }
            else
            {
                $sConnectionTable = CoreConfig::MIMOTO_CONNECTIONS_PROJECT;
            }


            // store
            $nPropertyCount = count($entity->properties);
            for ($j = 0; $j < $nPropertyCount; $j++)
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

                        // init
                        $settings = array();

                        // copy
                        $settings[MimotoEntityConfig::OPTION_ENTITY_ALLOWEDENTITYTYPE] = clone $property->settings[MimotoEntityConfig::OPTION_ENTITY_ALLOWEDENTITYTYPE];

                        // prepare
                        $settings[MimotoEntityConfig::OPTION_ENTITY_ALLOWEDENTITYTYPE]->value = (object) array(
                            'id' => $property->settings[MimotoEntityConfig::OPTION_ENTITY_ALLOWEDENTITYTYPE]->value,
                            'name' => $this->getEntityNameById($property->settings[MimotoEntityConfig::OPTION_ENTITY_ALLOWEDENTITYTYPE]->value)
                        );

                        // setup
                        $entityConfig->setEntityAsProperty($property->name, $property->id, $settings);

                        // connect entity to data source
                        $entityConfig->connectPropertyToMySQLConnectionTable($property->name, $sConnectionTable);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // init
                        $settings = array();

                        // copy
                        $settings[MimotoEntityConfig::OPTION_COLLECTION_ALLOWEDENTITYTYPES] = clone $property->settings[MimotoEntityConfig::OPTION_COLLECTION_ALLOWEDENTITYTYPES];
                        $settings[MimotoEntityConfig::OPTION_COLLECTION_ALLOWEDENTITYTYPES]->value = [];

                        // prepare
                        $aAllowedEntityTypes = $property->settings[MimotoEntityConfig::OPTION_COLLECTION_ALLOWEDENTITYTYPES]->value;
                        $nAllowedEntityTypeCount = count($aAllowedEntityTypes);
                        for ($k = 0; $k < $nAllowedEntityTypeCount; $k++)
                        {
                            // register
                            $xAllowedEntityType = $aAllowedEntityTypes[$k];

                            // prepare
                            $settings[MimotoEntityConfig::OPTION_COLLECTION_ALLOWEDENTITYTYPES]->value[$k] = (object) array(
                                'id' => $xAllowedEntityType,
                                'name' => $this->getEntityNameById($xAllowedEntityType)
                            );
                        }

                        // prepare
                        $settings[MimotoEntityConfig::OPTION_COLLECTION_ALLOWDUPLICATES] = (isset($property->settings[MimotoEntityConfig::OPTION_COLLECTION_ALLOWDUPLICATES]) && $property->settings[MimotoEntityConfig::OPTION_COLLECTION_ALLOWDUPLICATES]->value === 'true') ? true : false;

                        // setup
                        $entityConfig->setCollectionAsProperty($property->name, $property->id, $settings);
                        
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





    // ----------------------------------------------------------------------------
    // --- Private methods - Raw data ---------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Load raw Entity data
     * @return array Entities
     */
    private function loadRawEntityData()
    {
        // init
        $aEntities = [];

        // load all entities
        $stmt = $GLOBALS['database']->prepare('SELECT * FROM '.CoreConfig::MIMOTO_ENTITY);
        $params = array();
        $stmt->execute($params);

        foreach ($stmt as $row)
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
            $aEntities[] = $entity;
        }

        // send
        return $aEntities;
    }

    /**
     * Load raw EntityProperty data
     * @return array EntityProperties
     */
    private function loadRawEntityPropertyData()
    {
        // init
        $aEntityProperties = [];

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

            // register
            $nEntityPropertyId = $row['id'];

            // store
            $aEntityProperties[$nEntityPropertyId] = $property;
        }

        // send
        return $aEntityProperties;
    }

    /**
     * Load raw EntityPropertySetting data
     * @return array EntityPropertySettings
     */
    private function loadRawEntityPropertySettingData()
    {
        // init
        $aEntityPropertySettings = [];

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

            // register
            $nEntityPropertySettingId = $row['id'];

            // store
            $aEntityPropertySettings[$nEntityPropertySettingId] = $setting;
        }

        // send
        return $aEntityPropertySettings;
    }

    /**
     * Load raw connection data
     * @param string Parent entity type id
     * @return array Entity connections
     */
    private function loadRawConnectionData($sParentEntityTypeId)
    {
        // init
        $aConnections = [];

        // load all connections
        $stmt = $GLOBALS['database']->prepare(
            "SELECT * FROM ".CoreConfig::MIMOTO_CONNECTIONS_CORE." WHERE ".
            "parent_entity_type_id = :parent_entity_type_id ".
            "ORDER BY parent_id ASC, sortindex ASC"
        );
        $params = array(
            ':parent_entity_type_id' => $sParentEntityTypeId
        );
        $stmt->execute($params);

        foreach ($stmt as $row)
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
            $aConnections[$nEntityId][] = $connection;
        }

        // send
        return $aConnections;
    }

}

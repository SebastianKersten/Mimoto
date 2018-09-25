<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityException;
use Mimoto\Log\LogService;


/**
 * EntityConfigRepository
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityConfigRepository
{

    /**
     * The requested entities
     * @var array
     */
    private $_aEntityConfigs = [];
    private $_aEntities;
    private $_nUserExtensionEntityIndex = false;



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // toggle between cache or database
        if (Mimoto::service('cache')->isEnabled() && Mimoto::service('cache')->getValue('mimoto.core.formconfigs'))
        {
            // load
            $this->_aEntities = Mimoto::service('cache')->getValue('mimoto.core.entityconfigs');
        }
        else
        {
            // load
            $this->_aEntities = CoreConfig::getCoreEntityConfigs();
            $this->loadEntityConfigurations();
            $this->extendEntityConfigurations();

            // cache
            if (Mimoto::service('cache')->isEnabled())
            {
                Mimoto::service('cache')->setValue('mimoto.core.entityconfigs', $this->_aEntities);
            }
        }

        // register user extension index
        $nEntityCount = count($this->_aEntities);
        for ($nEntityIndex = 0; $nEntityIndex < $nEntityCount; $nEntityIndex++)
        {
            $entity = $this->_aEntities[$nEntityIndex];

            if (isset($entity->isUserExtension) && $entity->isUserExtension)
            {
                $this->_nUserExtensionEntityIndex = $nEntityIndex;
                break;
            }
        }


        //Mimoto::error($this->_aEntities);
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
     * @return EntityConfig
     */
    public function create()
    {
        // init and send
        return new EntityConfig();
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

    /**
     * Get entity name by id
     * @param $nId The requested entity's id
     * @return string|null
     */
    public function getEntityNameById($nId)
    {
        // 1. init
        $sName = null;

        // 2. search
        $nItemCount = count($this->_aEntities);
        for ($i = 0; $i < $nItemCount; $i++)
        {
            // 2a. register
            $entity = $this->_aEntities[$i];

            // 2a. compare and register
            if ($entity->id == $nId) { $sName = $entity->name; break; }
        }

        // 3. send
        return $sName;
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

    public function getPropertyIdByName($sName, $nParentEntityTypeId = null)
    {
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            $entity = $this->_aEntities[$i];

            // verify and skip
            if (!empty($nParentEntityTypeId) && $entity->id != $nParentEntityTypeId) continue;

            $nPropertyCount = count($entity->properties);
            for ($j = 0; $j < $nPropertyCount; $j++)
            {
                $property = $entity->properties[$j];

                if ($property->name == $sName) { return $property->id; }
            }
        }
    }

    public function getPropertyTypeById($nId)
    {
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            $entity = $this->_aEntities[$i];

            $nPropertyCount = count($entity->properties);
            for ($j = 0; $j < $nPropertyCount; $j++)
            {
                $property = $entity->properties[$j];

                if ($property->id == $nId) { return $property->type; }
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

            if ($entity->id == $sTypeOfEntity)
            {
                if (!isset($entity->typeOf) || empty($entity->typeOf))
                {
                    return ($sTypeOfEntity == $sTypeToCompare);
                }
                else
                {
                    return in_array($sTypeToCompare, $entity->typeOf);
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

        //error($this->_aEntities);

        Mimoto::service('log')->error('Incomplete entity config', "No entity found which contains a property with <b>id=".$nId."</b>", true);
    }

    /**
     * Get entity name by form id
     * @param $sFormId The name of the form
     * @return mixed
     */
    public function getEntityNameByFormId($sFormId)
    {
        // search
        $nEntityCount = count($this->_aEntities);
        for ($nEntityIndex = 0; $nEntityIndex < $nEntityCount; $nEntityIndex++)
        {
            // register
            $entity = $this->_aEntities[$nEntityIndex];

            // validate
            if (empty($entity->forms)) continue;

            // find
            $nFormCount = count($entity->forms);
            for ($nFormIndex = 0; $nFormIndex < $nFormCount; $nFormIndex++)
            {
                // register
                if ($entity->forms[$nFormIndex] == $sFormId)
                {
                    return $entity->name;
                }
            }
        }

        // report
        Mimoto::service('log')->error('Form not supported', "No entity found that contains a form with <b>id=".$sFormId."</b>", true);
    }


    public function getEntityConfigsTypeOf($sEntityTypeName)
    {
        // init
        $aEntityConfigs= [];

        // search
        $nEntityCount = count($this->_aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $this->_aEntities[$i];

            if (isset($entity->typeOfAsNames))
            {
                if (in_array($sEntityTypeName, $entity->typeOfAsNames))
                {
                    $aEntityConfigs[] = clone $entity;
                }
            }
        }

        // send
        return $aEntityConfigs;
    }

    public function getUserExtensionType()
    {
        if (!empty($this->_nUserExtensionEntityIndex))
        {
            return $this->_aEntities[$this->_nUserExtensionEntityIndex]->name;
        }


        return null;
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
        $aAllEntity_Connections = EntityConfigUtils::loadRawConnectionData(CoreConfig::MIMOTO_ENTITY);
        $aAllEntityProperties = $this->loadRawEntityPropertyData();
        $aAllEntityProperty_Connections = EntityConfigUtils::loadRawConnectionData(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $aAllEntityPropertySettings = $this->loadRawEntityPropertySettingData();
        $aAllEntityPropertySetting_Connections = EntityConfigUtils::loadRawConnectionData(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING);



        // --- compose ---


        while(count($aAllEntity) > 0)
        {
            // read and cleanup
            $entity = array_shift($aAllEntity);

            // validate
            if (!isset($aAllEntity_Connections[$entity->id]))
            {
                // notify
                //$this->_LogService->silent('Data construction error - properties', "The entity with name '".$entity->name."' has no properties", 'EntityConfigRepository');

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
                        if (!isset($aAllEntityProperties[$connection->child_id])) { Mimoto::error("Oops, the entity config named '$entity->name' seems to miss a property"); };

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

                $property = $this->setDefaultPropertySettings($property);

                // validate
                if (isset($aAllEntityProperty_Connections[$property->id]))
                {
                    // notify
                    //$this->_LogService->silent('Data construction error - propertysettings', "The property with name '".$property->name."' has no settings", 'EntityConfigRepository');
                    //error($property);

                    // #todo - Deze check eruit! Een config hoeft geen settings te bevatten

                    // skip
                    //continue 2;



                    // register
                    $aEntityProperty_Connections = $aAllEntityProperty_Connections[$property->id];

                    // cleanup
                    unset($aAllEntityProperty_Connections[$property->id]);


                    // store
                    while (count($aEntityProperty_Connections) > 0)
                    {
                        // register and cleanup
                        $connection = array_shift($aEntityProperty_Connections);

                        switch ($connection->parent_property_id)
                        {
                            case CoreConfig::MIMOTO_ENTITYPROPERTY . '--settings':

                                // setting
                                $setting = $aAllEntityPropertySettings[$connection->child_id];

                                // cleanup
                                unset($aAllEntityPropertySettings[$connection->child_id]);


                                // filter
                                if ($setting->key == EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE || $setting->key == EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES)
                                {

                                    // validate
                                    if (!isset($aAllEntityPropertySetting_Connections[$setting->id]))
                                    {
                                        // notify
                                        // 1. $this->_LogService->silent('', '');

                                        // skip
                                        //continue 3;
                                        break;
                                    }

                                    // register
                                    $aEntityPropertySetting_Connections = $aAllEntityPropertySetting_Connections[$setting->id];

                                    // cleanup
                                    unset($aAllEntityPropertySetting_Connections[$setting->id]);


                                    switch ($setting->key)
                                    {
                                        case EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE:

                                            // store
                                            while (count($aEntityPropertySetting_Connections) > 0)
                                            {
                                                // register and cleanup
                                                $connection = array_shift($aEntityPropertySetting_Connections);

                                                // validate
                                                if ($connection->parent_property_id !== CoreConfig::MIMOTO_ENTITYPROPERTYSETTING . '--allowedEntityType') continue;

                                                // store
                                                $setting->value = $connection->child_id;
                                            }

                                            break;

                                        case EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES:

                                            // init
                                            $setting->value = [];

                                            // store
                                            while (count($aEntityPropertySetting_Connections) > 0)
                                            {
                                                // register and cleanup
                                                $connection = array_shift($aEntityPropertySetting_Connections);

                                                // validate
                                                if ($connection->parent_property_id !== CoreConfig::MIMOTO_ENTITYPROPERTYSETTING . '--allowedEntityTypes') continue;

                                                // store
                                                $setting->value[] = $connection->child_id;
                                            }
                                            break;
                                    }
                                }


                                // store
                                $property->settings[$setting->key] = $setting;

                                //Mimoto::output($setting->key, $property->settings);

                                break;
                        }
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
                $aExtensions = $this->buildExtensionStack($entity->extends);
                $aTypeOfs = array_merge([$entity->id], $aExtensions);

                $entity->typeOf = $aTypeOfs;

                $entity->typeOfAsNames = [];

                $nTypeOfCount = count($aTypeOfs);
                for ($k = 0; $k < $nTypeOfCount; $k++)
                {
                    $entity->typeOfAsNames[$k] = $this->getEntityNameById($aTypeOfs[$k]);
                }

                // add base properties
                $nExtensionCount =  count($aExtensions);
                for ($nExtensionIndex = 0; $nExtensionIndex < $nExtensionCount; $nExtensionIndex++)
                {
                    // register
                    $extensionId = $aExtensions[$nExtensionIndex];

                    // find
                    $baseEntity = $this->findEntityById($extensionId);

                    $nPropertyCount = count($baseEntity->properties);
                    for ($nPropertyIndex = 0; $nPropertyIndex < $nPropertyCount; $nPropertyIndex++)
                    {
                        // clone
                        $property = clone $baseEntity->properties[$nPropertyIndex];

                        if (!isset($property->owner))
                        {
                            // make note
                            $property->owner = $extensionId;

                            // convert core id's (what about custom data id's?)
                            $property->id = $entity->id.substr($property->id, strlen($extensionId));

                            // store
                            $entity->properties[] = $property;
                        }
                    }
                }

            }
            else
            {
                $entity->typeOf = [$entity->id];
                $entity->typeOfAsNames = [$this->getEntityNameById($entity->id)];
            }
        }
    }

    /**
     * Build extension path
     * @param $baseId The entity that is being extended
     * @param $aExtensions An array containing the stack of extensions
     * @return array
     */
    private function buildExtensionStack($baseId, $aExtensions = [])
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

        // compose
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
        die ("EntityConfigRepository says: Can't find the entity with id=".$xEntityId);
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
            $entityConfig = new EntityConfig();
            
            // setup
            $entityConfig->setId($entity->id);
            $entityConfig->setName($entity->name);
            $entityConfig->setMySQLTable($entity->name);

            if (isset($entity->isUserExtension) && $entity->isUserExtension) $entityConfig->markAsUserExtension();

            $sConnectionTable = CoreConfig::MIMOTO_CONNECTION;


            // store
            $nPropertyCount = count($entity->properties);
            for ($j = 0; $j < $nPropertyCount; $j++)
            {
                // read
                $property = $entity->properties[$j];

                switch($property->type)
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                        // init
                        $settings = array();

                        // copy
                        $settings[EntityConfig::SETTING_VALUE_TYPE] = clone $property->settings[EntityConfig::SETTING_VALUE_TYPE];

                        // copy
                        if (isset($property->settings[EntityConfig::SETTING_VALUE_DEFAULTVALUE]))
                        {
                            $settings[EntityConfig::SETTING_VALUE_DEFAULTVALUE] = clone $property->settings[EntityConfig::SETTING_VALUE_DEFAULTVALUE];
                        }

                        // setup
                        $entityConfig->setValueAsProperty($property->name, $property->id, $settings);

                        // connect entity to data source
                        $entityConfig->connectPropertyToMySQLColumn($property->name, $property->name);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // init
                        $settings = array();

                        // copy
                        $settings[EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE] = clone $property->settings[EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE];

                        // prepare
                        $settings[EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE]->value = (object) array(
                            'id' => $property->settings[EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE]->value,
                            'name' => $this->getEntityNameById($property->settings[EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE]->value)
                        );

                        // copy
                        if (isset($property->settings[EntityConfig::SETTING_ENTITY_DEFAULTVALUE]))
                        {
                            $settings[EntityConfig::SETTING_ENTITY_DEFAULTVALUE] = clone $property->settings[EntityConfig::SETTING_ENTITY_DEFAULTVALUE];
                        }


                        $sSubtype = (isset($property->subtype)) ? $property->subtype : null;


                        // setup
                        $entityConfig->setEntityAsProperty($property->name, $property->id, $settings, $sSubtype);

                        // connect entity to data source
                        $entityConfig->connectPropertyToMySQLConnectionTable($property->name, $sConnectionTable);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // init
                        $settings = array();

                        // copy
                        $settings[EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES] = clone $property->settings[EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES];
                        $settings[EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES]->value = [];

                        // prepare
                        $aAllowedEntityTypes = $property->settings[EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES]->value;
                        $nAllowedEntityTypeCount = count($aAllowedEntityTypes);
                        for ($k = 0; $k < $nAllowedEntityTypeCount; $k++)
                        {
                            // register
                            $xAllowedEntityType = $aAllowedEntityTypes[$k];

                            // prepare
                            $settings[EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES]->value[$k] = (object) array(
                                'id' => $xAllowedEntityType,
                                'name' => $this->getEntityNameById($xAllowedEntityType)
                            );
                        }

                        // prepare
                        $settings[EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES] = (isset($property->settings[EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES]) && $property->settings[EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES]->value === 'true') ? true : false;$settings[EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES] = (isset($property->settings[EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES]) && ($property->settings[EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES]->value == 'true' || $property->settings[EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES]->value == '1' || $property->settings[EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES]->value)) ? true : false;

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
        $stmt = Mimoto::service('database')->prepare('SELECT * FROM `'.CoreConfig::MIMOTO_ENTITY.'`');
        $params = array();
        $stmt->execute($params);

        foreach ($stmt as $row)
        {
            // compose
            $entity = (object) array(
                'id' => $row['mimoto_id'],
                'created' => $row['mimoto_created'],
                'modified' => $row['mimoto_modified'],
                'name' => $row['name'],
                'extends' => null,
                'isUserExtension' => $row['isUserExtension'],
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
        $sql = 'SELECT * FROM `'.CoreConfig::MIMOTO_ENTITYPROPERTY.'`';
        foreach (Mimoto::service('database')->query($sql) as $row)
        {
            // compose
            $property = (object) array(
                'id' => $row['mimoto_id'],
                'created' => $row['mimoto_created'],
                'modified' => $row['mimoto_modified'],
                'name' => $row['name'],
                'type' => $row['type'],
                'subtype' => $row['subtype'],
                'settings' => []
            );

            // register
            $nEntityPropertyId = $row['mimoto_id'];

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
        $sql = 'SELECT * FROM `'.CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'`';
        foreach (Mimoto::service('database')->query($sql) as $row)
        {
            // compose
            $setting = (object) array(
                'id' => $row['mimoto_id'],
                'created' => $row['mimoto_created'],
                'modified' => $row['mimoto_modified'],
                'key' => $row['key'],
                'type' => $row['type'],
                'value' => $row['value']
            );

            // register
            $nEntityPropertySettingId = $row['mimoto_id'];

            // store
            $aEntityPropertySettings[$nEntityPropertySettingId] = $setting;
        }

        // send
        return $aEntityPropertySettings;
    }

    /**
     * Set default property settings that can be overruled by user config
     * @param $property
     * @return mixed
     */
    private function setDefaultPropertySettings($property)
    {
        // toggle
        switch($property->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                $property->settings = array(
                    EntityConfig::SETTING_VALUE_TYPE => (object) array(
                        'key' => EntityConfig::SETTING_VALUE_TYPE,
                        'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                        'value' => CoreConfig::DATA_VALUE_TEXTLINE
                    )
                );

                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                $property->settings = array(
                    EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE => (object) array(
                        'key' => EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE,
                        'type' => MimotoEntityPropertyValueTypes::VALUETYPE_CONNECTION,
                        'value' => null
                    )
                );

                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                $property->settings = array(
                    EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES => (object) array(
                        'key' => EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES,
                        'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                        'value' => []
                    ),
                    EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES => (object) array(
                        'key' => EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES,
                        'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                        'value' => false
                    ),
                );

                break;

        }

        // send
        return $property;
    }

}

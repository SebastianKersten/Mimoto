<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Mimoto;


/**
 * EntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityConfig
{
    
    /**
     * The id of the entity config
     * @var int 
     */
    private $_nId = '';
    
    /**
     * The name of the entity
     * @var string 
     */
    private $_sName = '';

    /**
     * Flag for user extension
     * @var boolean
     */
    private $_bIsUserExtension = false;

    /**
     * The properties of the entity
     * @var array 
     */
    private $_aProperties = [];
    
    /**
     * The property values of the entity
     * @var array 
     */
    private $_aPropertyValues = [];

    /**
     * The MySQL table name
     * @var string
     */
    private $_sMySQLTableName;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constants --------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    // property value types
    const PROPERTY_VALUE_MYSQL_COLUMN           = 'property_value_mysql_column';
    const PROPERTY_VALUE_MYSQLCONNECTION_TABLE  = 'property_value_mysql_connection_table';

    // property settings keys
    const SETTING_VALUE_TYPE                    = 'type';
    const SETTING_VALUE_FORMATTINGOPTIONS       = 'formattingOptions';
    const SETTING_VALUE_DEFAULTVALUE            = 'defaultValue';
    const SETTING_ENTITY_ALLOWEDENTITYTYPE      = 'allowedEntityType';
    const SETTING_ENTITY_DEFAULTVALUE           = 'defaultValue';
    const SETTING_COLLECTION_ALLOWEDENTITYTYPES = 'allowedEntityTypes';
    const SETTING_COLLECTION_ALLOWDUPLICATES    = 'allowDuplicates';



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get entity config id
     * @return int The id of the entity config
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set entity config id
     * @param int $nId
     */
    public function setId($nId) { $this->_nId = $nId; }
    
    
    /**
     * Get the name of the entity
     * @return string The name of the entity
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the name of the entity
     * @param string $sName
     */
    public function setName($sName) { $this->_sName = $sName; }


    /**
     * Mark as user extension
     */
    public function markAsUserExtension()
    {
        $this->_bIsUserExtension = true;
    }

    /**
     * Mark as user extension
     */
    public function isUserExtension()
    {
        return $this->_bIsUserExtension;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get entity's property names
     * @return array
     */
    public function getPropertyNames()
    {
        // init
        $aPropertyNames = [];
        
        // collect
        foreach ($this->_aProperties as $sPropertyName => $value) { $aPropertyNames[] = $sPropertyName; }
        
        // send
        return $aPropertyNames;
    }
    
    /**
     * Get the config of a property
     * @param string $sPropertyName The property's name
     * @return object config
     */
    public function getPropertyConfig($sPropertyName)
    {
        // validate
        if (!$this->hasProperty($sPropertyName)) { throw new \Exception("( '-' ) - Hmm, I can't seem to find the property '$sPropertyName'"); }
        
        // send
        return $this->_aProperties[$sPropertyName];
    }
    
    /**
     * Get the config of a property value
     * @param string $sPropertyName The property's name
     */
    public function getPropertyValue($sPropertyName)
    {
        // validate
        if (!$this->hasPropertyValue($sPropertyName)) { throw new \Exception("( '-' ) - It looks like no value has been connected to property '$sPropertyName'"); }
        
        // send
        return $this->_aPropertyValues[$sPropertyName];
    }

    
    
    // --- structure ---
    
    
    /**
     * Set value as property
     * @param string $sPropertyName The property's name
     */
    public function setValueAsProperty($sPropertyName, $nPropertyId, $settings, $xParentEntityTypeId)
    {
        // compose
        $property = (object) array(
            'name' => $sPropertyName,
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE,
            'id' => $nPropertyId,
            'parentEntityTypeId' => $xParentEntityTypeId,
            'settings' => (object) array(
                EntityConfig::SETTING_VALUE_TYPE => $settings[EntityConfig::SETTING_VALUE_TYPE]
            )
        );

        // optional settings
        if (isset($settings[EntityConfig::SETTING_VALUE_DEFAULTVALUE]))
        {
            $property->settings->{EntityConfig::SETTING_VALUE_DEFAULTVALUE} = $settings[EntityConfig::SETTING_VALUE_DEFAULTVALUE];
        }
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set entity as property
     * @param string $sPropertyName The property's name
     * @param array $settings Array containing the setting 'entityType'
     */
    public function setEntityAsProperty($sPropertyName, $nPropertyId, $settings, $sSubtype = null, $xParentEntityTypeId)
    {
        // compose
        $property = (object) array(
            'name' => $sPropertyName,
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY,
            'subtype' => $sSubtype,
            'id' => $nPropertyId,
            'parentEntityTypeId' => $xParentEntityTypeId,
            'settings' => (object) array(
                EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE => $settings[EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE]->value
            )
        );

        // optional settings
        if (isset($settings[EntityConfig::SETTING_ENTITY_DEFAULTVALUE]))
        {
            $property->settings->{EntityConfig::SETTING_ENTITY_DEFAULTVALUE} = $settings[EntityConfig::SETTING_ENTITY_DEFAULTVALUE];
        }

        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set collection as property
     * @param string $sPropertyName The property's name
     * @param array $settings Array containig the settings 'allowedEntityType' and 'allowDuplicates'
     */
    public function setCollectionAsProperty($sPropertyName, $nPropertyId, $settings, $xParentEntityTypeId)
    {
        // compose
        $property = (object) array(
            'name' => $sPropertyName,
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION,
            'id' => $nPropertyId,
            'parentEntityTypeId' => $xParentEntityTypeId,
            'settings' => (object) array(
                EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES => $settings[EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES]->value,
                EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES => $settings[EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES]
            )
        );

        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    
    // --- data source ---
    
    
    /**
     * Set MySQL table
     * @param string $sMySQLTableName
     */
    public function setMySQLTable($sMySQLTableName)
    {
        // store
        $this->_sMySQLTableName = $sMySQLTableName;
    }
    
    /**
     * Get MySQL table
     * @return string The MySQL table
     */
    public function getMySQLTable()
    {
        // store
        return $this->_sMySQLTableName;
    }
    
    /**
     * Connect property to MySQL column
     * @param string $sPropertyName The property's name
     * @param string $sMySQLColumnName The MySQL column name
     */
    public function connectPropertyToMySQLColumn($sPropertyName, $sMySQLColumnName)
    {
        // compose
        $propertyValue = (object) array(
            'type' => self::PROPERTY_VALUE_MYSQL_COLUMN,
            'name' => $sPropertyName,
            'mysqlColumnName' => $sMySQLColumnName
        );
        
        // store
        $this->_aPropertyValues[$sPropertyName] = $propertyValue;
    }
    
    /**
     * Connect property to a MySQL connection table
     * @param string $sPropertyName The property's name
     * @param string $sMySQLConnectionTable The MySQL connection table name
     */
    public function connectPropertyToMySQLConnectionTable($sPropertyName, $sMySQLConnectionTable)
    {
        // compose
        $propertyValue = (object) array(
            'type' => self::PROPERTY_VALUE_MYSQLCONNECTION_TABLE,
            'name' => $sPropertyName,
            'mysqlConnectionTable' => $sMySQLConnectionTable
        );
        
        // store
        $this->_aPropertyValues[$sPropertyName] = $propertyValue;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Check if the entity has a property
     * @param string $sPropertyName The property's name
     */
    private function hasProperty($sPropertyName)
    {
        // validate and send
        return isset($this->_aProperties[$sPropertyName]) ? true : false;
    }
    
    /**
     * Check if the entity has a property value
     * @param string $sPropertyName The property's name
     */
    private function hasPropertyValue($sPropertyName)
    {
        // validate and send
        return isset($this->_aPropertyValues[$sPropertyName]) ? true : false;
    }
}

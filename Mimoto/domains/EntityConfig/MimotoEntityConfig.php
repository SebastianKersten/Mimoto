<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityConfigException;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * MimotoEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityConfig
{
    
    /**
     * The id of the entity config
     * @var int 
     */
    var $_nId = '';
    
    /**
     * The name of the entity
     * @var string 
     */
    var $_sName = '';
    
    /**
     * The properties of the entity
     * @var array 
     */
    var $_aProperties = [];
    
    /**
     * The property values of the entity
     * @var array 
     */
    var $_aPropertyValues = [];

    /**
     * The MySQL table name
     * @var string
     */
    var $_sMySQLTableName;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constants --------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    // property value types
    const PROPERTY_VALUE_MYSQL_COLUMN = 'property_value_mysql_column';
    const PROPERTY_VALUE_MYSQLCONNECTION_TABLE = 'property_value_mysql_connection_table';
    
    
    
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
     * @throws MimotoEntityConfigException
     */
    public function getPropertyConfig($sPropertyName)
    {
        // validate
        if (!$this->hasProperty($sPropertyName)) { throw new MimotoEntityConfigException("( '-' ) - Hmm, I can't seem to find the property '$sPropertyName'"); }
        
        // send
        return $this->_aProperties[$sPropertyName];
    }
    
    /**
     * Get the config of a property value
     * @param string $sPropertyName The property's name
     * @throws MimotoEntityConfigException
     */
    public function getPropertyValue($sPropertyName)
    {
        // validate
        if (!$this->hasPropertyValue($sPropertyName)) { throw new MimotoEntityConfigException("( '-' ) - It looks like no value has been connected to property '$sPropertyName'"); }
        
        // send
        return $this->_aPropertyValues[$sPropertyName];
    }
    
    
    // --- structure ---
    
    
    /**
     * Set value as property
     * @param string $sPropertyName The property's name
     */
    public function setValueAsProperty($sPropertyName, $nPropertyId)
    {
        // compose
        $property = (object) array(
            'name' => $sPropertyName,
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE,
            'id' => $nPropertyId,
        );
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set entity as property
     * @param string $sPropertyName The property's name
     * @param array $options Array containing the option 'entityType'
     */
    public function setEntityAsProperty($sPropertyName, $nPropertyId, $options)
    {        
         // compose
        $property = (object) array(
            'name' => $sPropertyName,
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY,
            'id' => $nPropertyId,
            'settings' => (object) array(
                'entityType' => $options['entityType']->value
            )
        );
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set collection as property
     * @param string $sPropertyName The property's name
     * @param array $settings Array containig the settings 'allowedEntityType' and 'allowDuplicates'
     */
    public function setCollectionAsProperty($sPropertyName, $nPropertyId, $settings)
    {
        // compose
        $property = (object) array(
            'name' => $sPropertyName,
            'type' => MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION,
            'id' => $nPropertyId,
            'settings' => (object) array(
                'allowedEntityTypes' => $settings['allowedEntityTypes']->value,
                'allowDuplicates' => ($settings['allowDuplicates']->value === 'true') ? true : false
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
    
    /**
     * Connect property to dummy value
     * @param string $sPropertyName The property's name
     * @param mixed $value The dummy value
     */
    public function connectPropertyToDummyValue($sPropertyName, $value)
    {
        // compose
        $propertyValue = (object) array(
            'type' => self::PROPERTY_VALUE_DUMMY,
            'name' => $sPropertyName,
            'value' => $value
        );
        
        // store
        $this->_aPropertyValues[$sPropertyName] = $propertyValue;
    }
    
    /**
     * Connect property to default value
     * @param string $sPropertyName The property's name
     * @param mixed $value The default value
     */
    public function connectPropertyToDefaultValue($sPropertyName, $value)
    {
        // compose
        $propertyValue = (object) array(
            'type' => self::PROPERTY_VALUE_DEFAULT,
            'name' => $sPropertyName,
            'value' => $value
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

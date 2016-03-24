<?php

// classpath
namespace Mimoto\Config;

// Mimoto classes
use Mimoto\Config\MimotoEntityConfigException;


/**
 * MimotoEntityConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityConfig
{
    
    /**
     * The name of the entity
     * @var array 
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
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constants --------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    // property types
    const PROPERTY_TYPE_VALUE = 'property_type_value';
    const PROPERTY_TYPE_ENTITY = 'property_type_entity';
    const PROPERTY_TYPE_COLLECTION = 'property_type_collection';
    
    // property value types
    const PROPERTY_VALUE_MYSQL_COLUMN = 'property_value_mysql_column';
    const PROPERTY_VALUE_DEFAULT = 'property_value_default';
    const PROPERTY_VALUE_DUMMY = 'property_value_dummy';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get MySQL table
     * @return string The MySQL table
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set entity name
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
     * @param type $sPropertyName The property's name
     */
    public function getProperty($sPropertyName)
    {
        // validate
        if (!$this->hasProperty($sPropertyName)) { throw new MimotoEntityConfigException("( '-' ) - Hmm, I can't seem to find the property '$sPropertyName'"); }
        
        // send
        return $this->_aProperties[$sPropertyName];
    }
    
    /**
     * Get the config of a property value
     * @param type $sPropertyName The property's name
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
    public function setValueAsProperty($sPropertyName)
    {
        // compose
        $property = (object) array(
            'type' => self::PROPERTY_TYPE_VALUE,
            'name' => $sPropertyName
        );
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set entity as property
     * @param string $sPropertyName The property's name
     * @param string $sEntityType The entity's type
     */
    public function setEntityAsProperty($sPropertyName, $sEntityType)
    {
         // compose
        $property = (object) array(
            'type' => self::PROPERTY_TYPE_ENTITY,
            'name' => $sPropertyName,
            'entityType' => $sEntityType
        );
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set collection as property
     * @param string $sPropertyName The property's name
     * @param string $sAllowedEntityType The allowed entity type
     */
    public function setCollectionAsProperty($sPropertyName, $sAllowedEntityType)
    {
         // compose
        $property = (object) array(
            'type' => self::PROPERTY_TYPE_COLLECTION,
            'name' => $sPropertyName,
            'allowedEntityType' => $sAllowedEntityType
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
     * @param type $sPropertyName The property's name
     */
    private function hasProperty($sPropertyName)
    {
        // validate and send
        return isset($this->_aProperties[$sPropertyName]) ? true : false;
    }
    
    /**
     * Check if the entity has a property value
     * @param type $sPropertyName The property's name
     */
    private function hasPropertyValue($sPropertyName)
    {
        // validate and send
        return isset($this->_aPropertyValues[$sPropertyName]) ? true : false;
    }
}

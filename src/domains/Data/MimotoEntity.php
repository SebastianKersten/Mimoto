<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Aimless\MimotoAimlessUtils;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Data\MimotoEntityProperty_Value;
use Mimoto\Data\MimotoEntityProperty_Entity;
use Mimoto\Data\MimotoEntityProperty_Collection;


/**
 * MimotoEntity
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntity
{

    /**
     * The entity's id
     * @var int
     */
    private $_nId;

    /**
     * The moment of creation
     * @var \DateTime
     */
    private $_datetimeCreated;

    /**
     * The entity's config, containing the entityTypeId and entityTypeName
     * @var string
     */
    private $_config;


    /**
     * The properties connected to this data node
     * 
     * @var array
     */
    private $_aProperties;
    
    /**
     * Track change mode
     * 
     * @var boolean
     */
    private $_bTrackChanges;
    
    
    // selector 
    const SELECTOR_KEY_SEPARATOR = '.';
    const SELECTOR_EXPRESSION_START = '{';
    const SELECTOR_EXPRESSION_END = '}';
    const SELECTOR_EXPRESSION_SEPERATOR = '=';
    const SELECTOR_ARRAY_START = '[';
    const SELECTOR_ARRAY_END = ']';



    // ----------------------------------------------------------------------------
    // --- Properties--------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get the entity's id
     *
     * @return int
     */
    public function getId() { return $this->_nId; }

    /**
     * Set the entity's id
     *
     * @param int $nId The entity's id
     */
    public function setId($nId) { $this->_nId = $nId; }


    /**
     * Get the entity's type's id
     *
     * @return mixed
     */
    public function getEntityTypeId() { return $this->_config->entityTypeId; }

    /**
     * Get the entity's type's name
     *
     * @return string
     */
    public function getEntityTypeName() { return $this->_config->entityTypeName; }


    /**
     * Get the moment of creation
     *
     * @return \DateTime
     */
    public function getCreated() { return $this->_datetimeCreated; }

    /**
     * Set the moment of creation
     *
     * @param \DateTime $datetimeCreated The moment of creation
     */
    public function setCreated($datetimeCreated) { $this->_datetimeCreated = $datetimeCreated; }



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     * @param string $sEntityType
     * @param boolean $bTrackChanges (default changes are tracked)
     */
    public function __construct($xEntityTypeId, $sEntityTypeName, $bTrackChanges = true)
    {
        // init
        $this->_config = (object) array();

        // register
        $this->_config->entityTypeId = $xEntityTypeId;
        $this->_config->entityTypeName = $sEntityTypeName;
        $this->_bTrackChanges = $bTrackChanges;

        // init
        $this->_aProperties = [];
    }

    
    
    // ----------------------------------------------------------------------------
    // --- Public methods - setup -------------------------------------------------
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
        foreach ($this->_aProperties as $sPropertyName => $property) { $aPropertyNames[] = $property->getName(); }
        
        // send
        return $aPropertyNames;
    }
    
    /**
     * Setup property by config
     * 
     * @param object $propertyConfig
     */
    public function setupProperty($propertyConfig)
    {
        // init
        $property = null;

        // create
        switch($propertyConfig->type)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                $property = new MimotoEntityProperty_Value($propertyConfig, $this->getId(), $this->getEntityTypeId());
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                $property = new MimotoEntityProperty_Entity($propertyConfig, $this->getId(), $this->getEntityTypeId());
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                $property = new MimotoEntityProperty_Collection($propertyConfig, $this->getId(), $this->getEntityTypeId());
                break;

            default:

                Mimoto::service('log')->error("Adding property of unknonw type", "The entity called ".$this->_config->name." was asked to add a property which has an unknown type", true);
                break;
        }

        // store
        $this->_aProperties[$propertyConfig->name] = $property;
    }

    /**
     * Get property type
     * @param $sPropertySelector
     * @return mixed
     */
    public function getPropertyType($sPropertySelector)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);

        // forwand and send
        return $property->getType($sSubpropertySelector);
    }

    /**
     * Check if this entity is of a certain base type entity
     * @param $sEntityType
     * @return boolean
     */
    public function typeOf($sEntityTypeName)
    {
        return Mimoto::service('config')->entityIsTypeOf($this->_config->entityTypeName, $sEntityTypeName);
    }


    
    // ----------------------------------------------------------------------------
    // --- Public methods - data --------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the value of a property
     * @param string $sPropertySelector
     * @param boolean $bGetConnectionInformation The storable value, in case of an entity or collection. Default is false
     * @return mixed xValue
     */
    public function getValue($sPropertySelector, $bGetConnectionInfo = false, $bGetPersistentValue = false)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);

        // forward and send
        return $property->getValue($bGetConnectionInfo, $sSubpropertySelector, $bGetPersistentValue);
    }
    
    /**
     * Set the value of a property
     * @param string $sPropertySelector
     * @param mixed xValue
     */
    public function setValue($sPropertySelector, $xValue)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);

        // forward
        $property->setValue($xValue, $sSubpropertySelector);
    }

    /**
     * Add a value to a property
     * @param string $sPropertySelector
     * @param mixed $xValue
     */
    public function addValue($sPropertySelector, $xValue, $sEntityType = null)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);

        // forward
        $property->addValue($xValue, $sSubpropertySelector, $sEntityType);
    }

    /**
     * Remove a value from a property
     * @param string $sPropertySelector
     * @param mixed $xValue
     * @param string|null $sEntityType
     */
    public function removeValue($sPropertySelector, $xValue, $sEntityType = null)
    {
        // load
        $property = $this->getProperty($sPropertySelector);
        $sSubpropertySelector = $this->getSubpropertySelector($sPropertySelector, $property);

        // forward
        $property->removeValue($xValue, $sSubpropertySelector);
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - change management -------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get Changes
     * @return array Collection containing of all changed properties as key/value pairs
     */
    public function getChanges()
    {
        // init
        $aModifiedValues = [];

        foreach ($this->_aProperties as $sPropertyName => $property)
        {
            // register
            $property = $this->_aProperties[$sPropertyName];

            // check
            $changeResult = $property->getChanges();

            // register
            if ($changeResult->hasChanges) $aModifiedValues[$sPropertyName] = $changeResult->changes;
        }

        // send
        return $aModifiedValues;
    }


    /**
     * Start tracking changes
     */
    public function trackChanges()
    {
        // toggle
        $this->_bTrackChanges = true;

        // toggle all properties
        foreach ($this->_aProperties as $property)
        {
            // toggle
            $property->trackChanges();
        }
    }

    /**
     * Check if the value was changed
     *
     * @return boolean True if value was changed
     */
    public function hasChanges()
    {
        // check and send
        return (count($this->getChanges()) > 0) ? true : false;
    }

    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        foreach ($this->_aProperties as $property)
        {
            // forward
            $property->acceptChanges();
        }
    }

    /**
     * Check if the data object has a property
     *
     * @return boolean True if value was changed
     */
    public function hasProperty($sProperty)
    {
        return isset($this->_aProperties[$sProperty]);
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - Aimless -----------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get Aimless value of a property or subproperty
     * @param string $sPropertyName
     * @return string
     */
    public function getAimlessValue($sPropertyName)
    {
        // find
        $nSeperatorPos = strpos($sPropertyName, '.');

        // separate
        $sMainPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, 0, $nSeperatorPos) : $sPropertyName;
        $sSubPropertyName = ($nSeperatorPos !== false) ? substr($sPropertyName, $nSeperatorPos + 1) : '';

        // compose
        $sAimlessValue = MimotoAimlessUtils::formatAimlessValue($this->getEntityTypeName(), $this->getId(), $sPropertyName);

        // verify
        if (!empty($sSubPropertyName) && $this->valueRelatesToEntity($sMainPropertyName))
        {
            // load
            $entity = $this->getValue($sMainPropertyName);

            // compose
            if (MimotoDataUtils::isEntity($entity))
            {
                $sAimlessValue .= MimotoAimlessUtils::formatAimlessSubvalue($sMainPropertyName, $entity->getId(), $sSubPropertyName);
            }
            else
            {
                $sAimlessValue .= MimotoAimlessUtils::formatAimlessSubvalueWithoutId($sMainPropertyName, $sSubPropertyName);
            }
        }

        // send
        return $sAimlessValue;
    }

    /**
     * Get Aimless id of an entity
     * @return string
     */
    public function getAimlessId()
    {
        return $this->getEntityTypeName().'.'.$this->getId();
    }


    public function serialize()
    {
        
    }


    
    // ----------------------------------------------------------------------------
    // --- Private methods - utils ------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get property
     * @param type $sPropertySelector
     * @return single property or collection of properties
     * @throws MimotoEntityException
     */
    private function getProperty($sPropertySelector)
    {
        // validate
        if (!MimotoDataUtils::validatePropertySelector($sPropertySelector)) Mimoto::service('log')->error("Incorrect property name", "The property selector '$sPropertySelector' seems to be malformed", true);

        // init
        $aMatchingProperties = [];

        // check all properties
        foreach ($this->_aProperties as $sPropertyName => $property)
        {
            // search
            if ($sPropertyName === $sPropertySelector || (strlen($sPropertySelector) > strlen($sPropertyName) && $sPropertyName.'.' === substr($sPropertySelector, 0, strlen($sPropertyName) + 1)))
            {
                // register
                $aMatchingProperties[] = $property;
                break;
            }
        }

        // verify
        if (count($aMatchingProperties) === 0) Mimoto::service('log')->error("No such property", "The property <b>$sPropertySelector</b> you are looking for doesn't seem to be here", true);

        // send
        return $aMatchingProperties[0];
    }

    /**
     * Get subproperty selector
     * @param string $sPropertySelector
     * @param object $property
     * @return string
     */
    private function getSubpropertySelector($sPropertySelector, $property)
    {
        // strip
        $sSubpropertySelector = substr($sPropertySelector, strlen($property->getName()));

        // strip more
        if (substr($sSubpropertySelector, 0, 1) === '.') { $sSubpropertySelector = substr($sSubpropertySelector, 1); }

        // send
        return $sSubpropertySelector;
    }
    
    public function valueRelatesToEntity($sPropertyName)
    {
        // verify and send
        return (isset($this->_aProperties[$sPropertyName]) && $this->_aProperties[$sPropertyName]->getType() == MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
    }
    
}

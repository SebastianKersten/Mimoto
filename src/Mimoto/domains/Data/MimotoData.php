<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\library\data\MimotoValueProperty;
use Mimoto\library\data\MimotoEntityProperty;
use Mimoto\library\data\MimotoCollectionProperty;
use Mimoto\library\data\MimotoDataUtils;
use Mimoto\library\data\MimotoDataPropertyInterface;


/**
 * MimotoData
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoData implements MimotoDataPropertyInterface
{
    
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
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor-------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * 
     * @param boolean $bTrackChanges (default changes are tracked)
     */
    public function __construct($bTrackChanges = true)
    {
        // register
        $this->_bTrackChanges = $bTrackChanges;
        
        // init
        $this->_aProperties = [];
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Set value as property
     * 
     * @param string $sPropertySelector The selector containing the property name and optional subselector
     */
    public function setValueAsProperty($sPropertySelector)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        
        if ($sSubselector !== false)
        {
            // init or load existing
            $property = (!isset($this->_aProperties[$sPropertyName])) ? new Mimotodata($this->_bTrackChanges) : $this->_aProperties[$sPropertyName];
            
            // forward
            $property->setValueAsProperty($sSubselector);
        }
        else
        {
            // init
            $property = new MimotoValueProperty($this->_bTrackChanges);
        }
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set entity as property
     * 
     * @param string $sPropertySelector The selector containing the property name and optional subselector
     * @param string $sEntityType The type of the entity
     */
    public function setEntityAsProperty($sPropertySelector, $sEntityType)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        
        if ($sSubselector !== false)
        {
            // init or load existing
            $property = (!isset($this->_aProperties[$sPropertyName])) ? new Mimotodata($this->_bTrackChanges) : $this->_aProperties[$sPropertyName];
            
            // forward
            $property->setEntityAsProperty($sSubselector, $sEntityType);
        }
        else
        {
            // init
            $property = new MimotoEntityProperty($sEntityType, $this->_bTrackChanges);
        }
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    /**
     * Set collection as property
     * 
     * @param string $sPropertySelector The selector containing the property name and optional subselector
     * @param string $sAllowedEntityType The entity type allowed in the collection
     */
    public function setCollectionAsProperty($sPropertySelector, $sAllowedEntityType)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        
        if ($sSubselector !== false)
        {
            // init or load existing
            $property = (!isset($this->_aProperties[$sPropertyName])) ? new Mimotodata($this->_bTrackChanges) : $this->_aProperties[$sPropertyName];
            
            // forward
            $property->setCollectionAsProperty($sSubselector, $sAllowedEntityType);
        }
        else
        {
            // init
            $property = new MimotoCollectionProperty($sAllowedEntityType, $this->_bTrackChanges);
        }
        
        // store
        $this->_aProperties[$sPropertyName] = $property;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    
    
    
    /**
     * Check if the entity has a property
     * 
     * @param string $sPropertyName The property name to be checked
     */
    public function hasProperty($sPropertyName)
    {
        // 1. ook met forward support
                
        return isset($this->_aProperties[$sPropertyName]);
    }
    
    /**
     * Get value of property
     * @param string $sPropertySelector
     * @return mixed
     * @throws \Exception
     */
    public function getValue($sPropertySelector)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        if (!$this->hasProperty($sPropertyName)) { throw new \Exception("MimotoData.getValue('".$sPropertyName."') - Property '".$sPropertyName."' does not exist", 0, null); } 
        
        // load
        $property = $this->_aProperties[$sPropertyName];
        
        // forward
        if ($property instanceof MimotoData) { return $property->getValue($sSubselector); }
        if ($property instanceof MimotoValueProperty) { return $property->getValue(); }
        if ($property instanceof MimotoEntityProperty) { return $property->getValue($sSubselector); }
        if ($property instanceof MimotoCollectionProperty) { return $property->getValue($sSubselector); }
        
    }
    
    public function setValue($sPropertySelector, $value)
    {
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        // load
        $property = $this->_aProperties[$sPropertyName];
        
        // forward
        if ($property instanceof MimotoData) { $property->setValue($sSubselector, $value); return; }
        if ($property instanceof MimotoValueProperty) { $property->setValue($value); return; }
        if ($property instanceof MimotoEntityProperty) { $property->setValue($sSubselector, $value); return; }
        if ($property instanceof MimotoCollectionProperty) { $property->setValue($sSubselector, $value); return; }
        
        
        
        
        // collection query:
        // "subprojects.{phase='archived'}.name"
        
        // selector parser (een collection heeft z'n eigen manier)
        
        
        
        // config
    // check type -> validate in form op basis van config zoals opgeslagen in database (by config)
    
    
    // store
        
    
    
    //stop er json in, verdeel over de verschillende nodes
    }
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Start tracking changes
     */
    public function trackChanges()
    {
        // toggle
        $this->_bTrackChanges = true;
        
        // update
        foreach ($this->_aProperties as $sPropertyName => $property) { $property->trackChanges(); }
    }
    
    /**
     * Check if the value was changed
     * 
     * @return boolean True if value was changed
     */
    public function hasChanges()
    {
        // init
        $bHasChanges = false;
        
        foreach ($this->_aProperties as $sPropertyName => $property)
        {
            if ($property->hasChanges())
            {
                $bHasChanges = true;
                break;
            }
        }
        
        // send
        return $bHasChanges;
    }
    
    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        // update
        foreach ($this->_aProperties as $sPropertyName => $property) { $property->acceptChanges(); }
    }
    
}

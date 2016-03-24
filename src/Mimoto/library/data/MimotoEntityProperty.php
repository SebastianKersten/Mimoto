<?php

// classpath
namespace Mimoto\library\data;

// Mimoto classes
use Mimoto\library\data\MimotoDataUtils;


/**
 * MimotoValue
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityProperty
{
    
    /**
     * The persistent values
     * @var array
     */
    private $_persistentId;
    
    /**
     * The current values
     * @var array
     */
    private $_currentValue;
    
    /**
     * Track change mode
     * @var boolean
     */
    private $_bTrackChanges;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties--------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    public function getValue($sPropertySelector, $bGetEntityInsteadOfRealValue = true)
    {
        return '<b style="color:red;">Dit moet een entity of id zijn</b><br>';
    }
    
    public function setValue($value)
    {
        if (MimotoDataUtils::isValidEntityId($value))
        {
            
        }
        
        if (MimotoDataUtils::isEntity($value))
        {
            
        }
    }
    
    
    
    
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
    }
    
    /**
     * Check if the value was changed
     * 
     * @return boolean True if value was changed
     */
    public function hasChanges()
    {
        return false;
        
        // check and send
        return (!isset($this->_persistentValue) || $this->_persistentValue !== $this->_currentValue);
    }
    
    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        // update
        $this->_persistentValue = $this->_currentValue;
    }
    
}

<?php

// classpath
namespace Mimoto\library\data;

// Mimoto classes
use Mimoto\library\data\MimotoDataPropertyInterface;

/**
 * MimotoValueProperty
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoValueProperty implements MimotoDataPropertyInterface
{
    
    /**
     * The persistent value
     * @var mixed
     */
    private $_persistentValue;
    
    /**
     * The current value
     * @var mixed
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
    
    
    /**
     * Get the value
     * 
     * @return string
     */
    public function getValue() { return $this->_currentValue; }
    
    /**
     * Set the value
     * 
     * @param mixed $value The value
     */
    public function setValue($value)
    {
        // store if change tracking is disabled
        if (!$this->_bTrackChanges) { $this->_persistentValue = $value; }
        
        // store
        $this->_currentValue = $value;
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

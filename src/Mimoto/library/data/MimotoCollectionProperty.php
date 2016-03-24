<?php

// classpath
namespace Mimoto\library\data;


/**
 * MimotoCollection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoCollectionProperty
{
    
    public function addValue()
    {
        // mls_connection="project.subprojects"
        // Example: Address book: _aAllowedEntities = ['client', 'agency'] (check on add)
    }
    
    public function removeValue()
    {
        
    }
    
    
    /**
     * Get the value
     * 
     * @return string
     */
    public function getValue($sPropertySelector)
    {
        
        // 1. lazy load values op first-request
        // 2. loop door alle items if no specific selector given
    }
    
    /**
     * Set the value
     * 
     * @param mixed $value The value
     */
    public function setValue($value)
    {
        //if (!$this->_bTrackChanges) { $this->_persistentValue = $value; }
        
        // store
        //$this->_currentValue = $value;
        
        
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
        // 1. check if arrays are similar (different items, or different order
        
        // let op met array opbouwen -> meer controle over volgorde etc
        // (voorkom referenties bij check isModified!!!!)
        
        return false;
        
        // check and send
        //return (!isset($this->_persistentValue) || $this->_persistentValue !== $this->_currentValue);
    }
    
    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        
        // 1. rebuild currentArray into persistentArray
        
        // update
        //$this->_persistentValue = $this->_currentValue;
    }
    
}

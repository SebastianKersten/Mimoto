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
     * The entity's type
     * @var string
     */
    private $_sEntityType;
    
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
        return ($bGetEntityInsteadOfRealValue) ? $this->getEntity($this->_currentValue) : $this->_currentValue;
    }
    
    public function setValue($sPropertySelector, $value)
    {
        echo 'Entity value = '.$value."<br>";
        
        
        // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        // load
        //$property = $this->_aProperties[$sPropertyName];
        
        
        // 1. if isset subselector, then forward to entity
        // 2. is not entity, load entity
        // 3. store entity separatelijk (soort van cache)
        // 4. subitems.hasChanges -> store
        
        //echo $sPropertySelector
                
        
        if (empty($sSubselector))
        {
            if (MimotoDataUtils::isValidEntityId($value))
            {
                $nEntityId = $value;
                
                echo "---> Dit is een entity ID<br>";
                
                
            }

            if (MimotoDataUtils::isEntity($value))
            {
                echo "---> Dit is een entity<br>";
                
                $nEntityId = $value;
                
                // 1. wat als deze nog niet opgeslagen is?
            }
            
            // store if change tracking is disabled
            if (!$this->_bTrackChanges) { $this->_persistentValue = $nEntityId; }

            // store
            $this->_currentValue = $nEntityId;
        }
        else
        {
            // forward
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
    public function __construct($sEntityType, $bTrackChanges = true)
    {
        // register
        $this->_sEntityType = $sEntityType;
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
    
    
    private function getEntity($nEntityId)
    {
      //  $this->_entityService->
        // hoe deze te breiken?
        // singleton?
        return false;
    }
    
}

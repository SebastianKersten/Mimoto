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
    private $_currentId;
    
    /**
     * Track change mode
     * @var boolean
     */
    private $_bTrackChanges;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties--------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    public function getValue($sPropertySelector, $bGetStorableValue = false)
    {
         // prepare
        $sPropertyName = MimotoDataUtils::getPropertyFromPropertySelector($sPropertySelector);
        $sSubselector = MimotoDataUtils::getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName);
        
        
        
        return (!$bGetStorableValue) ? $this->getEntity($this->_currentId) : $this->_currentId;
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
            
            if (MimotoDataUtils::isValidEntityId($value) || MimotoDataUtils::isEntity($value))
            {
            
                if (MimotoDataUtils::isValidEntityId($value))
                {
                    $nEntityId = $value;

                    echo "---> Dit is een entity ID<br>";


                }
                else
                if (MimotoDataUtils::isEntity($value))
                {
                    echo "---> Dit is een entity<br>";

                    $nEntityId = $value->getId();

                    // 1. wat als deze nog niet opgeslagen is?
                }


                // 1. if ID not valid -> skip

                // store if change tracking is disabled
                if (!$this->_bTrackChanges) { $this->_persistentId = $nEntityId; }

                // store
                $this->_currentId = $nEntityId;
            }
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
        // check and send
        return (!isset($this->_persistentId) || $this->_persistentId !== $this->_currentId);
    }
    
    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        // update
        $this->_persistentId = $this->_currentId;
    }
    
    
    private function getEntity($nEntityId)
    {
        // load
        $entity = $GLOBALS['Mimoto.EntityService']->getEntityById($this->_sEntityType, $nEntityId);
        
        // 1. store ID in currenValue if no ID set?
        
        // send
        return $entity;
    }
    
}

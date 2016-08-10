<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Data\MimotoData;
use Mimoto\Data\MimotoEntityUtils;
use Mimoto\Aimless\MimotoAimlessUtils;


/**
 * MimotoEntityValue
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntity extends MimotoData
{
    
    /**
     * The entity's id
     * @var int 
     */
    private $_nId;
    
    /**
     * The entity's type
     * @var string 
     */
    private $_sEntityType;

    /**
     * The entity's group
     * @var string
     */
    private $_sEntityGroup;

    /**
     * The moment of creation
     * @var datetime
     */
    private $_datetimeCreated;
    
    
    
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
     * Get the entity's type
     * 
     * @return string
     */
    public function getEntityType() { return $this->_sEntityType; }


    /**
     * Get the entity's group
     *
     * @return string
     */
    public function getEntityGroup() { return $this->_sEntityGroup; }

    /**
     * Set the entity's group
     *
     * @param string $sEntityGroup The entity's group
     */
    public function setEntityGroup($sEntityGroup) { $this->_sEntityGroup = $sEntityGroup; }

    
    /**
     * Get the moment of creation
     * 
     * @return datetime
     */
    public function getCreated() { return $this->_datetimeCreated; }
    
    /**
     * Set the moment of creation
     * 
     * @param datetime $datetimeCreated The moment of creation
     */
    public function setCreated($datetimeCreated) { $this->_datetimeCreated = $datetimeCreated; }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param string $sEntityType
     */
    public function __construct($sEntityType, $bTrackChanges = true)
    {
        
        parent::__construct($bTrackChanges);
        
        // register
        $this->_sEntityType = $sEntityType;
        
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get Aimless value of a property or subproperty
     * @param type $sPropertyName
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
        $sAimlessValue = MimotoAimlessUtils::formatAimlessValue($this->getEntityType(), $this->getId(), $sPropertyName);
        
        // verify
        if (!empty($sSubPropertyName) && $this->valueRelatesToEntity($sMainPropertyName))
        {
            // load
            $entity = $this->getValue($sMainPropertyName);
            
            // compose
            if (MimotoEntityUtils::isEntity($entity))
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
        return $this->getEntityType().'.'.$this->getId();
    }
}

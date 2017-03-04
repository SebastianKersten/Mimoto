<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoEntityProperty;
use Mimoto\Data\MimotoEntityPropertyInterface;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * MimotoEntityProperty_Entity
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityProperty_Entity extends MimotoEntityProperty implements MimotoEntityPropertyInterface
{

    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct($propertyConfig, $xParentId, $xParentEntityTypeId)
    {
        // 1. forward
        parent::__construct($propertyConfig, $xParentId, $xParentEntityTypeId);

        // 2. init
        $this->_data = (object) array(
            'persistentEntity' => null,
            'currentEntity' => null
        );
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - config ------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get type
     * @return string
     */
    public function getType($sSubpropertySelector = null)
    {
        // 1. forward request
        if (!empty($sSubpropertySelector))
        {
            // load
            $entity = $this->loadEntity();

            // forward and send
            return (!empty($entity)) ? $entity->getPropertyType($sSubpropertySelector) : null;
        }
        else
        {
            // send
            return $this->_config->type;
        }
    }

    /**
     * Get subtype
     * @return string
     */
    public function getSubtype($sSubpropertySelector = null)
    {
        // 1. forward request
        if (!empty($sSubpropertySelector))
        {
            // load
            $entity = $this->loadEntity();

            // forward and send
            return (!empty($entity)) ? $entity->getPropertySubtype($sSubpropertySelector) : null;
        }
        else
        {
            // send
            return $this->_config->subtype;
        }
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - data --------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Set the value of the property
     * @param boolean $bGetStorableValue
     * @param null $sSubpropertySelector
     * @return MimotoEntity|mixed|null
     */
    public function getValue($bGetConnectionInfo = false, $sSubpropertySelector = null, $bGetPersistentValue = false)
    {
        // 1. validate
        if (empty($this->_data->currentEntity)) return null;

        // 2. forward
        if (!empty($sSubpropertySelector)) { return $this->forwardGetValue($sSubpropertySelector, $bGetConnectionInfo); }

        // 3. send connection info
        if ($bGetConnectionInfo) { return $this->_data->currentEntity; }

        // 4. send entity
        return $this->loadEntity();
    }

    /**
     * Set the value of the property
     * @param string $sPropertySelector
     * @param mixed value
     */
    public function setValue($xValue, $sSubpropertySelector = null)
    {
        // 1. forward request
        if (!empty($sSubpropertySelector)) { $this->forwardSetValue($sSubpropertySelector, $xValue); return; }

        // init
        $aAllowedEntityTypes = [];

        // fill
        if (!empty($this->_config->settings->allowedEntityType->id) && !empty($this->_config->settings->allowedEntityType->name))
        {
            $aAllowedEntityTypes[] = $this->_config->settings->allowedEntityType;
        }

        // 2. create connection
        $connection = MimotoDataUtils::createConnection($xValue, $this->getParentEntityTypeId(), $this->_config->id, $this->getParentId(), $aAllowedEntityTypes, $this->_config->settings->allowedEntityType->id, $this->_config->name);

        // 3. store as persistent if change tracking is disabled
        if (!$this->_bTrackChanges) $this->_data->persistentEntity = (!empty($connection)) ? clone $connection : null;

        // 4. store
        $this->_data->currentEntity = $connection;
    }

    /**
     * Add value (only possible for subproperties)
     * @param $value
     */
    public function addValue($value, $sSubpropertySelector = null, $sEntityType = null)
    {
        // validate
        if (empty($sSubpropertySelector))
        {
            Mimoto::service('log')->silent("Adding value to a non-collection", "Unable to add a value to an entity property <b>" . $this->_config->name."</b>");
        }
        else
        {
            // load
            $entity = $this->loadEntity();

            // validate
            if (!empty($entity))
            {
                $entity->addValue($value, $sSubpropertySelector, $sEntityType);
            }
            else
            {
                Mimoto::service('log')->silent("Attempting to add a value to the property of an empty entity", "Unable to add a value to an empty entity's property <b>".$this->_config->name."</b> that might have a collection property called <b>".$sSubpropertySelector."</b>");
            }
        }
    }

    /**
     * Remove value (only possible for subproperties)
     * @param $value
     */
    public function removeValue($value, $sSubpropertySelector = null, $sEntityType = null)
    {
        // validate
        if (empty($sSubpropertySelector))
        {
            Mimoto::service('log')->silent("Removing value from a non-collection", "Unable to remove a value from an entity property <b>" . $this->_config->name."</b>");
        }
        else
        {
            // load
            $entity = $this->loadEntity();

            // validate
            if (!empty($entity))
            {
                $entity->removeValue($value, $sSubpropertySelector, $sEntityType);
            }
            else
            {
                Mimoto::service('log')->silent("Attempting to remove a value from the property of an empty entity", "Unable to remove a value from an empty entity's property <b>".$this->_config->name."</b> that might have a collection property called <b>".$sSubpropertySelector."</b>");
            }
        }
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - change management -------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get Changes
     * @return object Collection containing of all changed properties as key/value pairs
     */
    public function getChanges()
    {
        // init
        $result = (object) array(
            'hasChanges' => false,
            'changes' => null
        );

        // init
        $aAddedItems = [];
        $aUpdatedItems = [];
        $aRemovedItems = [];

        if (isset($this->_data->currentEntity) && !isset($this->_data->persistentEntity))
        {
            $aAddedItems[] = $this->_data->currentEntity;
        }
        elseif (!isset($this->_data->currentEntity) && isset($this->_data->persistentEntity))
        {
            $aRemovedItems[] = $this->_data->persistentEntity;
        }
        elseif (isset($this->_data->currentEntity) && isset($this->_data->persistentEntity))
        {
            // check if similar
            if (MimotoDataUtils::connectionsAreSimilar($this->_data->currentEntity, $this->_data->persistentEntity))
            {
                $this->_data->currentEntity->setId($this->_data->persistentEntity->getId());
            }
            else
            {
                $aAddedItems[] = $this->_data->currentEntity;
                $aRemovedItems[] = $this->_data->persistentEntity;
            }
        }

        if (count($aAddedItems) > 0 || count($aUpdatedItems) > 0 || count($aRemovedItems) > 0)
        {
            $result->hasChanges = true;
            $result->changes = (object) array(
                'added' => $aAddedItems,
                'updated' => $aUpdatedItems,
                'removed' => $aRemovedItems,
            );
        }

        // send
        return $result;
    }

    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        if (!empty($this->_data->currentEntity))
        {
            $this->_data->persistentEntity = clone $this->_data->currentEntity;
        }
        else
        {
            unset($this->_data->persistentEntity);
        }
    }

    
    
    // ----------------------------------------------------------------------------
    // --- Private methods - data utils -------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Forward getValue request
     * @param $sPropertySelector
     * @param $bGetConnectionInfo
     * @return mixed|null
     */
    private function forwardGetValue($sPropertySelector, $bGetConnectionInfo)
    {
        // load
        $entity = $this->loadEntity();

        // forward
        return (!empty($entity)) ? $entity->getValue($sPropertySelector, $bGetConnectionInfo) : null;
    }

    /**
     * Forward setValue request
     * @param $sPropertySelector
     * @param $value
     */
    private function forwardSetValue($sPropertySelector, $value)
    {
        // load
        $entity = $this->loadEntity();

        // forward
        if (!empty($entity)) $entity->setValue($sPropertySelector, $value);
    }

    /**
     * Load entity
     * @param object $property
     * @return MimotoEntity
     */
    private function loadEntity()
    {
        // check if available
        if (!empty($this->_data->currentEntity) && empty($this->_data->currentEntity->getEntity()))
        {
            if (MimotoDataUtils::isValidEntityId($this->_data->currentEntity->getChildId()))
            {
                // load
                $this->_data->currentEntity->setEntity(Mimoto::service('data')->get($this->_data->currentEntity->getChildEntityTypeName(), $this->_data->currentEntity->getChildId()));
            }
        }
        
        // send
        return (!empty($this->_data->currentEntity) && !empty($this->_data->currentEntity->getEntity())) ? $this->_data->currentEntity->getEntity() : null;
    }

}

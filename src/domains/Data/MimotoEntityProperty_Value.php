<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Data\MimotoEntityProperty;
use Mimoto\Data\MimotoEntityPropertyInterface;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * MimotoEntityProperty_Value
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityProperty_Value extends MimotoEntityProperty implements MimotoEntityPropertyInterface
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
            'persistentValue' => null,
            'currentValue' => null
        );
    }


    
    // ----------------------------------------------------------------------------
    // --- Public methods - data --------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get value
     * @param boolean $bGetConnectionInfo [unused for this type of property]
     * @param string $sSubpropertySelector [unused for this type of property]
     * @return mixed
     */
    public function getValue($bGetConnectionInfo = false, $sSubpropertySelector = null)
    {
        // 1. send
        return $this->_data->currentValue;
    }

    /**
     * Set value
     * @param $value
     */
    public function setValue($value, $sSubpropertySelector = null)
    {
        // 1. validate
        if (!$this->validateValueType($value)) $GLOBALS['Mimoto.Log']->warn('Incorrect value', 'The property <b>'.$this->_config->name.'</b> only allows values of type '.$this->_config->settings->type->type);;

        // 2. store if change tracking is disabled
        if (!$this->_bTrackChanges) { $this->_data->persistentValue = $value; }

        // 3. store
        $this->_data->currentValue = $value;
    }

    /**
     * Add value (not possible for this type of property)
     * @param $value
     */
    public function addValue($value, $sSubpropertySelector = null, $sEntityType = null)
    {
        // 1. error - not supported for this property type
        $GLOBALS['Mimoto.Log']->warn('Adding value to a non-collection', 'Unable to add a value to a value property <b>'.$this->_config->name.'</b>');
    }

    /**
     * Remove value (not possible for this type of property)
     * @param $value
     */
    public function removeValue($value, $sSubpropertySelector = null, $sEntityType = null)
    {
        // 1. error - not supported for this property type
        $GLOBALS['Mimoto.Log']->warn('Removing value from a non-collection', 'Unable to remove a value from a value property <b>'.$this->_config->name.'</b>');
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
        // 1. init
        $result = (object) array(
            'hasChanges' => false,
            'changes' => null
        );

        // 2. collect
        if (!isset($this->_data->persistentValue) || $this->_data->persistentValue !== $this->_data->currentValue)
        {
            $result->hasChanges = true;
            $result->changes = $this->_data->currentValue;
        }

        // 3. send
        return $result;
    }

    /**
     * Accept the changes made to the value
     */
    public function acceptChanges()
    {
        // 1. update
        $this->_data->persistentValue = $this->_data->currentValue;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods - validation --------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Validate value type
     * @param $value
     */
    private function validateValueType($value)
    {
        // 1. init
        $bValidated = true;

        // 2. validate
        switch($this->_config->settings->type->type)
        {
            case MimotoEntityPropertyValueTypes::VALUETYPE_TEXT:
            case MimotoEntityPropertyValueTypes::VALUETYPE_INTEGER:
            case MimotoEntityPropertyValueTypes::VALUETYPE_FLOAT:

                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN:

                $bValidated = is_bool($value);
                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY:

                $bValidated = is_array($value);
                break;

            default:

                $bValidated = false;

        }

        // 3. send
        return $bValidated;
    }
    
}

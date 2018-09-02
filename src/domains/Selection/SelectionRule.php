<?php

// classpath
namespace Mimoto\Selection;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * SelectionRule
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SelectionRule
{

    // properties
    private $_xType = null;
    private $_xId = null;
    private $_xProperty = null;
    private $_aValues = [];
    private $_aChildTypes = [];
    private $_aChildValues = [];
    private $_aVarNames = [];



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Set the entity type
     * @param $xType mixed Reference to the entity type (name or id)
     */
    public function setType($xType)
    {
        // store
        $this->_xType = $xType;
    }

    /**
     * Set the entity type as variable
     * @param $sVarName string The name of the variable
     */
    public function setTypeAsVar($sVarName)
    {
        // store
        $this->_aVarNames[$sVarName] = (object) array('key' => 'type');
    }

    /**
     * Get the entity type
     * @return mixed Reference to the entity type  (name or id)
     */
    public function getType()
    {
        // send
        return $this->_xType;
    }


    /**
     * Set the instance id
     * @param $xId mixed The id of the instance
     */
    public function setId($xId)
    {
        // store
        $this->_xId = $xId;
    }

    /**
     * Set the instance id as variable
     * @param $sVarName string The name of the variable
     */
    public function setIdAsVar($sVarName)
    {
        // store
        $this->_aVarNames[$sVarName] = (object) array('key' => 'id');
    }

    /**
     * Get the instance id
     * @return mixed The id of the instance
     */
    public function getId()
    {
        // send
        return $this->_xId;
    }


    /**
     * Set the property containing the entities
     * @param $xParent mixed Reference to the parent property (name or id)
     */
    public function setProperty($xProperty)
    {
        // store
        $this->_xProperty = $xProperty;
    }

    /**
     * Set the property containing the entities as variable
     * @param $sVarName string The name of the variable
     */
    public function setPropertyAsVar($sVarName)
    {
        // store
        $this->_aVarNames[$sVarName] = (object) array('key' => 'property');
    }

    /**
     * Get the property containing the entities
     * @return mixed Reference to the parent property (name or id)
     */
    public function getProperty()
    {
        // send
        return $this->_xProperty;
    }


    /**
     * Set a property value (multiple values possible)
     * @param $xProperty mixed Reference to the property (either name or id)
     * @param $value mixed The actual to compare
     */
    public function setValue($xProperty, $value)
    {
        // store
        $this->_aValues[$xProperty] = $value;
    }

    /**
     * Set a rule value (multiple values possible) as variable
     * @param $xProperty mixed Reference to the property
     * @param $sVarName string The name of the variable
     */
    public function setValueAsVar($xProperty, $sVarName)
    {
        // store
        $this->_aVarNames[$sVarName] = (object) array('key' => 'value', 'property' => $xProperty);
    }

    /**
     * Get registered property values
     * @return array Containing the property references (either name or id)
     */
    public function getRegisteredValues()
    {
        // init
        $aRegisteredValues = [];

        // collect
        foreach ($this->_aValues as $sKey => $value) { $aRegisteredValues[] = $sKey; }

        // send
        return $aRegisteredValues;
    }

    /**
     * Get a property value
     * @param $xProperty mixed Reference to the property (either name or id)
     * @return mixed The value to compare
     */
    public function getValue($xProperty)
    {
        // store
        return $this->_aValues[$xProperty];
    }


    /**
     * Get the child types that are part of the result (multiple types possible)
     * @param $xTypes string|array The preferred child types (either name or id)
     */
    public function setChildTypes($xTypes)
    {
        // verify
        if (is_string($xTypes))
        {
            // store
            $this->_aChildTypes = [$xTypes];
        }

        if (is_array($xTypes))
        {
            // store
            $this->_aChildTypes = $xTypes;
        }
    }

    /**
     * Set the child types that are part of the result (multiple types possible) as variable
     * @param $sVarName string The name of the variable
     */
    public function setChildTypesAsVar($sVarName)
    {
        // store
        $this->_aVarNames[$sVarName] = (object) array('key' => 'childType');
    }

    /**
     * Get the child types that are part of the result
     * @return array the list of allowed child types
     */
    public function getChildTypes()
    {
        // store
        return $this->_aChildTypes;
    }


    /**
     * Set a child's property value(multiple values possible)
     * @param $xProperty mixed Reference to the property (either name or id)
     * @param $value mixed The actual to compare
     */
    public function setChildValue($xProperty, $value)
    {
        // store
        $this->_aChildValues[$xProperty] = $value;
    }

    /**
     * Set a child's value (multiple values possible) as variable
     * @param $xProperty mixed Reference to the property
     * @param $sVarName string The name of the variable
     */
    public function setChildValueAsVar($xProperty, $sVarName)
    {
        // store
        $this->_aVarNames[$sVarName] = (object) array('key' => 'childValue', 'property' => $xProperty);
    }

    /**
     * Get registered child's property values
     * @return array Containing the property references (either name or id)
     */
    public function getRegisteredChildValues()
    {
        // init
        $aRegisteredChildValues = [];

        // collect
        foreach ($this->_aChildValues as $sKey => $value) { $aRegisteredChildValues[] = $sKey; }

        // send
        return $aRegisteredChildValues;
    }

    /**
     * Get a child's property value
     * @param $xProperty mixed Reference to the property (either name or id)
     * @return mixed The value to compare
     */
    public function getChildValue($xProperty)
    {
        // store
        return $this->_aChildValues[$xProperty];
    }

    /**
     * Check if the selection rule is configured to return a single result
     * @return boolean The state of returning a single result
     */
    public function willReturnSingleResult()
    {
        // 1. init
        $bWillReturnSingleResult = true;

        // 2. verify
        if (empty($this->getType())) return false;

        // 3. verify id or idVar
        if (empty($this->getId()))
        {
            // a. investigate
            $bIdAsVarFound = false;
            foreach ($this->_aVarNames as $value)
            {
                if ($value->key == 'id') { $bIdAsVarFound = true; break; }
            }

            // b. toggle
            $bWillReturnSingleResult = $bIdAsVarFound;
        }

        // 3. verify property or propertyVar
        $bPropertyIsSet = true;
        if (empty($this->getProperty()))
        {
            // a. investigate
            $bPropertyAsVarFound = false;
            foreach ($this->_aVarNames as $value)
            {
                if ($value->key == 'property') { $bPropertyAsVarFound = true; break; }
            }

            // b. toggle
            $bPropertyIsSet = $bPropertyAsVarFound;
        }

        // 4. check property type
        if ($bWillReturnSingleResult && $bPropertyIsSet)
        {
            // a. verify
            switch(Mimoto::service('entityConfig')->getPropertyTypeById($this->getProperty()))
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                    $bWillReturnSingleResult = true;
                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                    $bWillReturnSingleResult = false;
                    break;

                default:

                    $bWillReturnSingleResult = false;
                    break;
            }
        }

        // 5. respond
        return $bWillReturnSingleResult;
    }



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Apply a variable
     */
    public function applyVar($sVarName, $value)
    {
        // validate
        if (!isset($this->_aVarNames[$sVarName]) || empty($this->_aVarNames[$sVarName])) return;

        // register
        $variable = $this->_aVarNames[$sVarName];

        // store value
        switch($variable->key)
        {
            case 'type':        $this->setType($value); break;
            case 'id':          $this->setId($value); break;
            case 'property':    $this->setProperty($value); break;
            case 'value':       $this->setValue($variable->property, $value); break;
            case 'childType':   $this->setChildTypes($value); break;
            case 'childValue':  $this->setChildValue($variable->property, $value); break;
        }
    }

}

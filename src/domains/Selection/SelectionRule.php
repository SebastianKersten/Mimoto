<?php

// classpath
namespace Mimoto\Selection;


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
}

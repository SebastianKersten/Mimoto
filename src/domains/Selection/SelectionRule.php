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
        $aRegisteredPropertyValues = [];

        // collect
        foreach ($this->_aValues as $sKey => $value) { $aRegisteredPropertyValues[] = $sKey; }

        // send
        return $aRegisteredPropertyValues;
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

}

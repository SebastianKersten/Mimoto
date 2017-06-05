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
    private $_xEntityType = null;
    private $_xInstanceId = null;
    private $_xParentProperty = null;
    private $_aPropertyValues = [];



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Set the entity type
     * @param $xType mixed Reference to the entity type
     */
    public function setEntityType($xEntityType)
    {
        // store
        $this->_xEntityType = $xEntityType;
    }

    /**
     * Get the entity type
     * @return mixed Reference to the entity type
     */
    public function getEntityType()
    {
        // send
        return $this->_xEntityType;
    }


    /**
     * Set the instance id
     * @param $xId mixed The id of the instance
     */
    public function setInstanceId($xInstanceId)
    {
        // store
        $this->_xInstanceId = $xInstanceId;
    }

    /**
     * Get the instance id
     * @return mixed The id of the instance
     */
    public function getInstanceId()
    {
        // send
        return $this->_xInstanceId;
    }


    /**
     * Set the parent property
     * @param $xParent mixed Reference to the parent property
     */
    public function setParentProperty($xParentProperty)
    {
        // store
        $this->_xParentProperty = $xParentProperty;
    }

    /**
     * get the parent property
     * @return mixed Reference to the parent property
     */
    public function getParentProperty()
    {
        // send
        return $this->_xParentProperty;
    }


    /**
     * Set a property value (multiple values possible)
     * @param $xProperty mixed Reference to the property
     * @param $value mixed The actual to compare
     */
    public function setPropertyValue($xProperty, $value)
    {
        // store
        $this->_aPropertyValues[$xProperty] = $value;
    }

    /**
     * Get registered property values
     * @return array Containing the property references (either name or id)
     */
    public function getRegisteredPropertyValues()
    {
        // init
        $aRegisteredPropertyValues = [];

        // collect
        foreach ($this->_aPropertyValues as $sKey => $value) { $aRegisteredPropertyValues[] = $sKey; }

        // send
        return $aRegisteredPropertyValues;
    }

    /**
     * Get a property value
     * @param $xProperty mixed Reference to the property
     * @return mixed The value to compare
     */
    public function getPropertyValue($xProperty)
    {
        // store
        return $this->_aPropertyValues[$xProperty];
    }

}

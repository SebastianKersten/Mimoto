<?php

// classpath
namespace Mimoto\Data;


/**
 * MimotoDataConnection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoDataConnection
{

    /**
     * The id of the connection
     *
     * @var mixed
     */
    private $_xId;

    /**
     * The id of the parent of the connected item
     *
     * @var mixed
     */
    private $_xParentId;

    /**
     * The id of the parent's EntityProperty to which the item is connected
     *
     * @var mixed
     */
    private $_xParentPropertyId;

    /**
     * The id of the child's Entity type
     *
     * @var mixed
     */
    private $_xChildEntityTypeId;

    /**
     * The name of the child's Entity type
     *
     * @var string
     */
    private $_sChildEntityTypeName;

    /**
     * The id of the the connected item
     *
     * @var mixed
     */
    private $_xChildId;

    /**
     * The sortindex of the connected item
     *
     * @var int
     */
    private $_nSortIndex;

    /**
     * Flag to indicatie if the connection is new and not yet persisted
     *
     * @var boolean
     */
    private $_bIsNew;



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get the id of the connection
     *
     * @return mixed
     */
    public function getId() { return $this->_xId; }

    /**
     * Set the id of the connection
     *
     * @param mixed
     */
    public function setId($xId) { $this->_xId = $xId; }


    /**
     * Get the id of the parent of the connected item
     *
     * @return mixed
     */
    public function getParentId() { return $this->_xParentId; }

    /**
     * Set the id of the parent of the connected item
     *
     * @param mixed
     */
    public function setParentId($xParentId) { $this->_xParentId = $xParentId; }


    /**
     * Get the id of the parent's EntityProperty to which the item is connected
     *
     * @return mixed
     */
    public function getParentPropertyId() { return $this->_xParentPropertyId; }

    /**
     * Set the id of the parent's EntityProperty to which the item is connected
     *
     * @param mixed
     */
    public function setParentPropertyId($xParentPropertyId) { $this->_xParentPropertyId = $xParentPropertyId; }


    /**
     * Get the id of the child's Entity type
     *
     * @return mixed
     */
    public function getChildEntityTypeId() { return $this->_xChildEntityTypeId; }

    /**
     * Get the name of the child's Entity type
     *
     * @return string
     */
    public function getChildEntityTypeName() { return $this->_sChildEntityTypeName; }

    /**
     * Set the id of the child's Entity type
     *
     * @param mixed
     */
    public function setChildEntityTypeId($xChildEntityTypeId)
    {
        $this->_xChildEntityTypeId = $xChildEntityTypeId;
        $this->_sChildEntityTypeName = $GLOBALS['Mimoto.Config']->getEntityNameById($xChildEntityTypeId);
    }


    /**
     * Get the id of the the connected item
     *
     * @return mixed
     */
    public function getChildId() { return $this->_xChildId; }

    /**
     * Set the id of the the connected item
     *
     * @param mixed
     */
    public function setChildId($xChildId) { $this->_xChildId = $xChildId; }


    /**
     * Get the sortindex of the connected item
     *
     * @return int
     */
    public function getSortIndex() { return $this->_nSortIndex; }

    /**
     * Set the sortindex of the connected item
     *
     * @param int
     */
    public function setSortIndex($nSortIndex) { $this->_nSortIndex = $nSortIndex; }


    /**
     * Check if the connection is new
     *
     * @return boolean
     */
    public function isNew() { return $this->_bIsNew; }

    /**
     * Set the new flag of the connection
     *
     * @return int
     */
    public function setIsNewFlag($bIsNew) { $this->_bIsNew = $bIsNew; }

}

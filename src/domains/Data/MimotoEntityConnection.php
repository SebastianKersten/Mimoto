<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Mimoto;


/**
 * MimotoEntityConnection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityConnection
{

    /**
     * The id of the connection
     *
     * @var mixed
     */
    private $_xId;

    /**
     * The moment of creation
     *
     * @var \DateTime
     */
    private $_datetimeCreated;

    /**
     * The moment of last modification
     *
     * @var \DateTime
     */
    private $_datetimeModified;

    /**
     * The id of the parent's Entity type
     *
     * @var mixed
     */
    private $_xParentEntityTypeId;

    /**
     * The name of the parent's Entity type
     *
     * @var string
     */
    private $_sParentEntityTypeName;

    /**
     * The id of the parent's EntityProperty to which the item is connected
     *
     * @var mixed
     */
    private $_xParentPropertyId;

    /**
     * The name of the parent's EntityProperty to which the item is connected
     *
     * @var mixed
     */
    private $_sParentPropertyName;

    /**
     * The id of the parent of the connected item
     *
     * @var mixed
     */
    private $_xParentId;

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
    private $_bNew;

    /**
     * The connected entity
     *
     * @var Mimotoentity
     */
    private $_entity;



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
     * Get the moment of creation
     *
     * @return \DateTime
     */
    public function getCreated() { return $this->_datetimeCreated; }

    /**
     * Set the moment of creation
     *
     * @param \DateTime $datetimeCreated The moment of creation
     */
    public function setCreated($datetimeCreated) { $this->_datetimeCreated = $datetimeCreated; }

    /**
     * Get the moment of last modification
     *
     * @return \DateTime
     */
    public function getModified() { return $this->_datetimeModified; }

    /**
     * Set the moment of last modification
     *
     * @param \DateTime $datetimeModified The moment of last modification
     */
    public function setModified($datetimeModified) { $this->_datetimeModified = $datetimeModified; }


    /**
     * Get the id of the parent's Entity type
     *
     * @return mixed
     */
    public function getParentEntityTypeId() { return $this->_xParentEntityTypeId; }

    /**
     * Get the name of the child's Entity type
     *
     * @return string
     */
    public function getParentEntityTypeName() { return $this->_sParentEntityTypeName; }

    /**
     * Set the id of the parent's Entity type
     *
     * @param mixed
     */
    public function setParentEntityTypeId($xParentEntityTypeId)
    {
        $this->_xParentEntityTypeId = $xParentEntityTypeId;
        $this->_sParentEntityTypeName = Mimoto::service('entityConfig')->getEntityNameById($xParentEntityTypeId);
    }


    /**
     * Get the id of the parent's EntityProperty to which the item is connected
     *
     * @return mixed
     */
    public function getParentPropertyId() { return $this->_xParentPropertyId; }

    /**
     * Get the id of the parent's EntityProperty to which the item is connected
     *
     * @return mixed
     */
    public function getParentPropertyName() { return $this->_sParentPropertyName; }


    /**
     * Set the id of the parent's EntityProperty to which the item is connected
     *
     * @param mixed
     */
    public function setParentPropertyId($xParentPropertyId)
    {
        $this->_xParentPropertyId = $xParentPropertyId;
        $this->_sParentPropertyName = Mimoto::service('entityConfig')->getPropertyNameById($xParentPropertyId);
    }


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
        $this->_sChildEntityTypeName = Mimoto::service('entityConfig')->getEntityNameById($xChildEntityTypeId);
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
    public function setSortIndex($nSortIndex) { $this->_nSortIndex = intval($nSortIndex); }


    /**
     * Check if the connection is new
     *
     * @return boolean
     */
    public function isNew() { return $this->_bNew; }

    /**
     * Set the new flag of the connection
     *
     * @return int
     */
    public function setNewFlag($bNew) { $this->_bNew = $bNew; }


    /**
     * Get the connected entity
     *
     * @return MimotoEntity
     */
    public function getEntity()
    {
        // verify
        if (empty($this->_entity))
        {
            // load
            $this->_entity = Mimoto::service('data')->get($this->getChildEntityTypeName(), $this->getChildId());
        }

        return $this->_entity;
    }

    /**
     * Set the connected entity
     *
     * @param MimotoEntity
     */
    public function setEntity($entity) { $this->_entity = $entity; }



    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Convert data to JSON-ready object
     *
     * @param boolean $bConvertToString Default = false
     *
     * @returns object or string
     */
    public function toJSON($bConvertToString = false)
    {
        // init
        $connection = (object) array(
            'id' => $this->_xId,
            'parentId' => $this->_xParentId,
            'parentPropertyId' => $this->_xParentPropertyId,
            'childEntityTypeId' => $this->_xChildEntityTypeId,
            'childEntityTypeName' => $this->_sChildEntityTypeName,
            'childId' => $this->_xChildId,
            'sortIndex' => $this->_nSortIndex
        );

        // send
        return ($bConvertToString) ? json_encode($connection) : $connection;
    }
}

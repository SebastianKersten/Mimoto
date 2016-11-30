<?php

// classpath
namespace Mimoto\Data;


/**
 * MimotoEntityProperty
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityProperty
{

    /**
     * Contains information about the property's configuration
     * @var $_config
     */
    protected $_config;

    /**
     * Contains the persistent and current data
     * @var $_data
     */
    protected $_data;

    /**
     * Change management helper
     * @var $_config
     */
    protected $_bTrackChanges;

    /**
     * Parent id
     * @var $_xParentId
     */
    private $_xParentId;

    /**
     * Parent entity type id
     * @var $_xParentEntityTypeId
     */
    private $_xParentEntityTypeId;



    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get name
     * @return string
     */
    public function getName() { return $this->_config->name; }

    /**
     * Get parent id
     * @return mixed
     */
    public function getParentId() { return $this->_xParentId; }

    /**
     * Get parent entity type id
     * @return mixed
     */
    public function getParentEntityTypeId() { return $this->_xParentEntityTypeId; }



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct($propertyConfig, $xParentId, $xParentEntityTypeId)
    {
        // store
        $this->_xParentId = $xParentId;
        $this->_xParentEntityTypeId = $xParentEntityTypeId;

        // register
        $this->_config = $propertyConfig;
    }


    
    // ----------------------------------------------------------------------------
    // --- Public methods - usage -------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Start tracking changes
     */
    public function trackChanges()
    {
        // toggle
        $this->_bTrackChanges = true;
    }
    
}

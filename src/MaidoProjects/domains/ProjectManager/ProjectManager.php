<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Mimoto classes
use Mimoto\Entity\MimotoEntity;


/**
 * The "ProjectManager"-model contains the information of a project manager
 *
 * @author Sebastian Kersten
 */
class ProjectManager extends MimotoEntity
{
    
    /**
     * The project manager's name
     * @var string
     */
    var $_sName;
    
    /**
     * The URL of the project manager's avatar
     * @var string
     */
    var $_sAvatarURL;
    
    /**
     * The moment of creation
     * @var datetime
     */
    var $_datetimeCreated;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the project manager's name
     * 
     * @return string
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the project manager's name
     * 
     * @param string $sName The project manager's name
     */
    public function setName($sName) { $this->_sName = $sName; }
    
    
    /**
     * Get the URL of the project manager's avatar
     * 
     * @return string
     */
    public function getAvatarURL() { return $this->_sAvatarURL; }
    
    /**
     * Set the URL of the project manager's avatar
     * 
     * @param string $sAvatarURL The URL of the project manager's avatar
     */
    public function setAvatarURL($sAvatarURL) { $this->_sAvatarURL = $sAvatarURL; }
    
    
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
     */
    public function __construct()
    {
        // setup
        parent::__construct('projectmanager');
    }
    
}

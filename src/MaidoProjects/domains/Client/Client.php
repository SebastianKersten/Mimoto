<?php

// classpath
namespace MaidoProjects\Client;


/**
 * The "Client"-model contains the information of a client
 *
 * @author Sebastian Kersten
 */
class Client
{
    
    /**
     * The client's id
     * @var int 
     */
    var $_nId;
    
    /**
     * The client's name
     * @var string
     */
    var $_sName;
    
    /**
     * The URL of the client's logo
     * @var string
     */
    var $_sLogoURL;
    
    /**
     * The moment of creation
     * @var datetime
     */
    var $_datetimeCreated;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the client's id
     * 
     * @return int
     */
    public function getId() { return $this->_nId; }
    
    /**
     * Set the client's id
     * 
     * @param int $nId The client's id
     */
    public function setId($nId) { $this->_nId = $nId; }
    
    
    /**
     * Get the client's name
     * 
     * @return string
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the client's name
     * 
     * @param string $sName The client's name
     */
    public function setName($sName) { $this->_sName = $sName; }
    
    
    /**
     * Get the URL of the client's logo
     * 
     * @return string
     */
    public function getLogoURL() { return $this->_sLogoURL; }
    
    /**
     * Set the URL of the client's logo
     * 
     * @param string $sLogoURL The URL of the client's logo
     */
    public function setLogoURL($sLogoURL) { $this->_sLogoURL = $sLogoURL; }
    
    
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
    
}
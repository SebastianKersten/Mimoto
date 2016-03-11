<?php

// classpath
namespace MaidoProjects\Client;

// Mimoto classes
use Mimoto\library\entities\MimotoEntity;


/**
 * The "Client"-model contains the information of a client
 *
 * @author Sebastian Kersten
 */
class Client extends MimotoEntity
{
    
    /**
     * Get the client's name
     * 
     * @return string
     */
    public function getName() { return parent::getValue('name'); }
    
    /**
     * Set the client's name
     * 
     * @param string $sName The client's name
     */
    public function setName($sName) { parent::setValue('name', $sName); }
    
    
    /**
     * Get the URL of the client's logo
     * 
     * @return string
     */
    public function getLogoURL() { return parent::getValue('logo_url'); }
    
    /**
     * Set the URL of the client's logo
     * 
     * @param string $sLogoURL The URL of the client's logo
     */
    public function setLogoURL($sLogoURL) { parent::setValue('logo_url', $sLogoURL); }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($bTrackChanges = true)
    {
        // setup
        parent::__construct('client', $bTrackChanges);
        
        // default
        parent::setValue('name', '');
        parent::setValue('logo_url', '');
    }
    
}
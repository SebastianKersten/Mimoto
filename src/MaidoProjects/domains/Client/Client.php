<?php

// classpath
namespace MaidoProjects\Client;

// Mimoto classes
use Mimoto\library\entities\MimotoEntity;


/**
 * The "Client"-model contains the information of a client
 *
 * @author Sebastian Kersten (@supertaboo)
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
    }
    
}
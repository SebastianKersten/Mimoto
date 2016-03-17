<?php

// classpath
namespace MaidoProjects\Agency;

// Mimoto classes
use Mimoto\library\entities\MimotoEntity;


/**
 * The "Agency"-model contains the information of an agency
 *
 * @author Sebastian Kersten
 */
class Agency extends MimotoEntity
{
    
    /**
     * Get the agency's name
     * 
     * @return string
     */
    public function getName() { return parent::getValue('name'); }
    
    /**
     * Set the agency's name
     * 
     * @param string $sName The agency's name
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
        parent::__construct('agency', $bTrackChanges);
    }
    
}
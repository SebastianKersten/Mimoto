<?php

// classpath
namespace MaidoProjects\SubprojectState;

// Mimoto classes
use Mimoto\library\entities\MimotoEntity;


/**
 * The "SubprojectState"-model contains the information of a subproject state
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SubprojectState extends MimotoEntity
{
    
    /**
     * Get the subproject state's name
     * 
     * @return string
     */
    public function getName() { return parent::getValue('name'); }
    
    /**
     * Set the subproject state's name
     * 
     * @param string $sName The subproject state's name
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
        parent::__construct('subprojectstate', $bTrackChanges);
        
        // default
        parent::setValue('name', '');
    }
    
}
<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Mimoto classes
use Mimoto\library\entities\MimotoEntity;


/**
 * The "ProjectManager"-model contains the information of a project manager
 *
 * @author Sebastian Kersten
 */
class ProjectManager extends MimotoEntity
{
    
    /**
     * Get the project manager's name
     * 
     * @return string
     */
    public function getName() { return parent::getValue('name'); }
    
    /**
     * Set the project manager's name
     * 
     * @param string $sName The project manager's name
     */
    public function setName($sName) { parent::setValue('name', $sName); }
    
    
    /**
     * Get the URL of the project manager's avatar
     * 
     * @return string
     */
    public function getAvatarURL() { return parent::getValue('avatar_url'); }
    
    /**
     * Set the URL of the project manager's avatar
     * 
     * @param string $sAvatarURL The URL of the project manager's avatar
     */
    public function setAvatarURL($sAvatarURL) { parent::setValue('avatar_url', $sAvatarURL); }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($bTrackChanges = true)
    {
        // setup
        parent::__construct('projectmanager', $bTrackChanges);
        
        // default
        parent::setValue('name', '');
        parent::setValue('avatar_url', '');
    }
    
}

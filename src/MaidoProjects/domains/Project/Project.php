<?php

// classpath
namespace MaidoProjects\Project;

// Momkai classes
use MaidoProjects\Client\Client;
use MaidoProjects\Agency\Agency;
use MaidoProjects\ProjectManager\ProjectManager;

// Mimoto classes
use Mimoto\library\entities\MimotoEntity;


/**
 * The "Project"-model contains the information of a project
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Project extends MimotoEntity
{
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the project's name
     * 
     * @return string
     */
    public function getName() { return parent::getValue('name'); }
    
    /**
     * Set the project's name
     * 
     * @param string $sName The project's name
     */
    public function setName($sName) { parent::setValue('name', $sName); }
    
    
    /**
     * Get the project's description
     * 
     * @return string
     */
    public function getDescription() { return parent::getValue('description'); }
    
    /**
     * Set the project's description
     * 
     * @param string $sDescription The project's description
     */
    public function setDescription($sDescription) { parent::setValue('description', $sDescription); }
    
    
    /**
     * Get the project's client
     * 
     * @return Client
     */
    public function getClient() { return parent::getValue('client'); }
    
    /**
     * Set the project's client
     * 
     * @param mixed $client The project's client
     */
    public function setClient($client) { parent::setValue('client', $client); }
    
    
    /**
     * Get the project's agency
     * 
     * @return Agency
     */
    public function getAgency() { return parent::getValue('agency'); }
    
    /**
     * Set the project's agency
     * 
     * @param mixed $agency The project's agency
     */
    public function setAgency($agency) { parent::setValue('agency', $agency); }
    
    
    /**
     * Get the project's project manager
     * 
     * @return ProjectManager
     */
    public function getProjectManager() { return parent::getValue('projectmanager'); }
    
    /**
     * Set the project's project manager
     * 
     * @param mixed $projectManager The project's project manager
     */
    public function setProjectManager($projectManager) { parent::setValue('projectmanager', $projectManager); }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($bTrackChanges = true)
    {
        // setup
        parent::__construct('project', $bTrackChanges);
    }
    
}

<?php

// classpath
namespace MaidoProjects\Project;

// Mimoto classes
use Mimoto\library\entities\MimotoEntity;


/**
 * The "Project"-model contains the information of a project
 *
 * @author Sebastian Kersten
 */
class Project extends MimotoEntity
{
    
    /**
     * The project's client's name
     * @var string
     */
    var $_sClientName;
    
    /**
     * The project's agency's name
     * @var string
     */
    var $_sAgencyName;
    
    /**
     * The project's project managers's name
     * @var string
     */
    var $_sProjectManagerName;
    
    /**
     * The project's subprojects
     * @var array
     */
    var $_aSubprojects;
    
    
    
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
     * Get the project's client id
     * 
     * @return int
     */
    public function getClientId() { return parent::getValue('client_id'); }
    
    /**
     * Set the project's client id
     * 
     * @param int $nClientId The project's client id
     */
    public function setClientId($nClientId) { parent::setValue('client_id', $nClientId); }
    
    
    /**
     * Get the project's client's name
     * 
     * @return string
     */
    public function getClientName() { return $this->_sClientName; }
    
    /**
     * Set the project's client's name
     * 
     * @param string $sClientName The project's client's name
     */
    public function setClientName($sClientName) { $this->_sClientName = $sClientName; }
    
    
    /**
     * Get the project's agency id
     * 
     * @return int
     */
    public function getAgencyId() { return parent::getValue('agency_id'); }
    
    /**
     * Set the project's agency id
     * 
     * @param int $nAgencyId The project's agency id
     */
    public function setAgencyId($nAgencyId) { parent::setValue('agency_id', $nAgencyId); }
    
    
    /**
     * Get the project's agency's name
     * 
     * @return string
     */
    public function getAgencyName() { return $this->_sAgencyName; }
    
    /**
     * Set the project's agency's name
     * 
     * @param string $sAgencyName The project's agency's name
     */
    public function setAgencyName($sAgencyName) { $this->_sAgencyName = $sAgencyName; }
    
    
    /**
     * Get the project's project manager id
     * 
     * @return int
     */
    public function getProjectManagerId() { return parent::getValue('projectmanager_id'); }
    
    /**
     * Set the project's project manager id
     * 
     * @param int $nProjectManagerId The project's project manager id
     */
    public function setProjectManagerId($nProjectManagerId) { parent::setValue('projectmanager_id', $nProjectManagerId); }
    
    
    /**
     * Get the project's project manager's name
     * 
     * @return string
     */
    public function getProjectManagerName() { return $this->_sProjectManagerName; }
    
    /**
     * Set the project's project manager's name
     * 
     * @param string $sProjectManagerName The project's project manager's name
     */
    public function setProjectManagerName($sProjectManagerName) { $this->_sProjectManagerName = $sProjectManagerName; }
    
    
    
    // #todo - delegate
    
    
    /**
     * Get the project's subprojects
     * 
     * @return Array
     */
    public function getSubprojects() { return $this->_aSubprojects; }
    
     /**
     * Set the project's subprojects
     * 
     * @param array $aSubprojects The project's subprojects
     */
    public function setSubprojects($aSubprojects) { $this->_aSubprojects = $aSubprojects; }
    
    
    
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
        
        // default
        parent::setValue('name', '');
        parent::setValue('description', '');
        parent::setValue('client_id', 0);// if entity, dan new Entity() met juiste values
        parent::setValue('agency_id', 0);
        parent::setValue('projectmanager_id', 0);
        
        
        // ipv setClientId('') setClient 
        // bij wijziging replace Client1 for Client2
        
//        subproperty mapping: 
//            client.4
//            client.7
//        id en created ook wegschrijven in values array, want dat te 
//        benaderen met simple property selectors als client.id
    }
    
}

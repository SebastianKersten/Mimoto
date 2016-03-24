<?php

// classpath
namespace MaidoProjects\Subproject;

// Mimoto classes
use Mimoto\library\entities\MimotoEntity;


/**
 * The "Subproject"-model contains the information of a subproject
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Subproject extends MimotoEntity
{
    
    /**
     * The subproject's name
     * @var string
     */
    var $_sName;
    
    /**
     * The subproject's contact name
     * @var string
     */
    var $_sContactName;
    
    /**
     * The subproject's phase
     * @var string
     */
    var $_sPhase;
    
    /**
     * The subproject's state id
     * @var int
     */
    var $_nStateId;
    
    /**
     * The subproject's state name
     * @var string
     */
    var $_sStateName;
    
    /**
     * The subproject's probability
     * @var int 
     */
    var $_nProbability;
    
    /**
     * The subproject's budget
     * @var int
     */
    var $_nBudget;
    
    /**
     * The subproject's payment type
     * @var string
     */
    var $_sPaymentType;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get the subproject's name
     * 
     * @return string
     */
    public function getName() { return $this->_sName; }
    
    /**
     * Set the subproject's name
     * 
     * @param string $sName The subproject's name
     */
    public function setName($sName) { $this->_sName = $sName; }
    
    
    /**
     * Get the subproject's contact name
     * 
     * @return string
     */
    public function getContactName() { return $this->_sContactName; }
    
    /**
     * Set the subproject's contact name
     * 
     * @param string $sContactName The subproject's contact name
     */
    public function setContactName($sContactName) { $this->_sContactName = $sContactName; }
    
    
    /**
     * Get the subproject's budget
     * 
     * @return int
     */
    public function getBudget() { return $this->_nBudget; }
    
    /**
     * Set the subproject's budget
     * 
     * @param int $nBudget The subproject's budget
     */
    public function setBudget($nBudget) { $this->_nBudget = $nBudget; }
    
    
    /**
     * Get the subproject's phase
     * 
     * @return string
     */
    public function getPhase() { return $this->_sPhase; }
    
    /**
     * Set the subproject's phase
     * 
     * @param string $sPhase The subproject's phase
     */
    public function setPhase($sPhase) { $this->_sPhase = $sPhase; }
    
    
    /**
     * Get the subproject's state ID
     * 
     * @return int
     */
    public function getStateId() { return $this->_nStateId; }
    
    /**
     * Set the subproject's state ID
     * 
     * @param int $nStateId The subproject's state ID
     */
    public function setStateId($nStateId) { $this->_nStateId = $nStateId; }
    
    
    /**
     * Get the subproject's state name
     * 
     * @return string
     */
    public function getStateName() { return $this->_sStateName; }
    
    /**
     * Set the subproject's state sname
     * 
     * @param string $sStateName The subproject's state name
     */
    public function setStateName($sStateName) { $this->_sStateName = $sStateName; }
    
    
    /**
     * Get the subproject's probability
     * 
     * @return int
     */
    public function getProbability() { return $this->_nProbability; }
    
    /**
     * Set the subproject's probability
     * 
     * @param int $nProbability The subproject's probability
     */
    public function setProbability($nProbability) { $this->_nProbability = $nProbability; }
    
    
    /**
     * Get the subproject's payment type
     * 
     * @return string
     */
    public function getPaymentType() { return $this->_sPaymentType; }
    
    /**
     * Set the subproject's payment type
     * 
     * @param string $sPaymentType The subproject's payment type
     */
    public function setPaymentType($sPaymentType) { $this->_sPaymentType = $sPaymentType; }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // setup
        parent::__construct('subproject');
    }
    
}

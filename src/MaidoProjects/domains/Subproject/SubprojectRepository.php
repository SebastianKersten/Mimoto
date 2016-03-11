<?php

// classpath
namespace MaidoProjects\Subproject;

// Momkai classes
use Mimoto\library\repositories\MimotoSingleMySQLTableRepository;


/**
 * SubprojectRepository
 *
 * @author Sebastian Kersten
 */
class SubprojectRepository extends MimotoSingleMySQLTableRepository
{      
    
    /**
     * Constructor
     */
    public function __construct($EventService)
    {
        
        // init parent
        parent::__construct($EventService);
        
        // setup
        $this->setModelClass('MaidoProjects\Subproject\Subproject');
        $this->setModelExceptionClass('MaidoProjects\Subproject\SubprojectException');
        $this->setModelEventClass('MaidoProjects\Subproject\SubprojectEvent');
        $this->setMySQLTable('subprojects');
        
        // connect
        $this->setModelToMySQLTableMap(
            [
                (object) array('property' => 'name', 'dbcolumn' => 'name'),
                (object) array('property' => 'contact_name', 'dbcolumn' => 'contact_name'),
                (object) array('property' => 'phase', 'dbcolumn' => 'phase'),
                (object) array('property' => 'state_id', 'dbcolumn' => 'state_id'),
                (object) array('property' => 'probability', 'dbcolumn' => 'probability'),
                (object) array('property' => 'budget', 'dbcolumn' => 'budget'),
                (object) array('property' => 'payment_type', 'dbcolumn' => 'payment_type'),
            ]
        );
    }
    
}
//use MaidoProjects\Subproject\SubprojectRepositoryCriteria;
//use MaidoProjects\Subproject\SubprojectPhases;
//
//    
//    // private
//    const MYSQL_TABLE_SUBPROJECTS = 'subprojects';
//    const MYSQL_TABLE_SUBPROJECTSTATES = 'subproject_states';
//    
//    
//    
//    public function find(SubprojectRepositoryCriteria $criteria = null)
//    {
//        
//        // init
//        $aSubprojects = array
//        (
//            SubprojectPhases::REQUEST => array(),
//            SubprojectPhases::CURRENTPROJECT => array(),
//            SubprojectPhases::ARCHIVED => array()
//        );
//        
//        // load
//        switch($criteria->getCriterium())
//        {
//            case SubprojectRepositoryCriteria::ALL:
//                
//                $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_SUBPROJECTS." ORDER BY name ASC";
//                break;
//                
//            case SubprojectRepositoryCriteria::BY_PROJECT_ID:
//                
//                $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_SUBPROJECTS." WHERE project_id='".$criteria->getProjectId()."' ORDER BY name ASC";
//                break;
//            
//            default:
//                
//                throw new SubprojectException('Cannot find subprojects with these CRITERIA');
//        }
//        
//        // load
//        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
//        $nItemCount = mysql_num_rows($result);
//        
//        
//        // register
//        for ($i = 0; $i < $nItemCount; $i++)
//        {
//            // create
//            $subproject = $this->createSubprojectFromMySQLResult($result, $i);
//            
//            // register
//            $aSubprojects[$subproject->getPhase()][] = $subproject;
//        }
//        
//        // send
//        return $aSubprojects;
//    }
//    
//    
//    
//    // ----------------------------------------------------------------------------
//    // --- Private methods --------------------------------------------------------
//    // ----------------------------------------------------------------------------
//    
//    
//    /**
//     * Create Subproject from MySQL result
//     * @param MySQL query result $mysqlResult
//     * @param int $nIndex
//     * @return Subproject
//     */
//    private function createSubprojectFromMySQLResult($mysqlResult, $nIndex)
//    {
//        // init
//        $subproject = new Subproject();
//
//        // register
//        $subproject->setId(mysql_result($mysqlResult, $nIndex, 'id'));
//        $subproject->setName(mysql_result($mysqlResult, $nIndex, 'name'));
//        $subproject->setContactName(mysql_result($mysqlResult, $nIndex, 'contact_name'));
//        $subproject->setPhase(mysql_result($mysqlResult, $nIndex, 'phase'));
//        $subproject->setStateId(mysql_result($mysqlResult, $nIndex, 'state_id'));
//        $subproject->setProbability(mysql_result($mysqlResult, $nIndex, 'probability'));
//        $subproject->setBudget(mysql_result($mysqlResult, $nIndex, 'budget'));
//        $subproject->setPaymentType(mysql_result($mysqlResult, $nIndex, 'payment_type'));
//
//        // load
//        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_SUBPROJECTSTATES." WHERE id='".$subproject->getStateId()."'";
//        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
//        $nItemCount = mysql_num_rows($result);
//        
//        // register for data representation
//        if ($nItemCount == 1) $subproject->setStateName(mysql_result($result, 0, 'name')); //<- memcached (+flush)
//        
//        // send
//        return $subproject;   
//    }
//}

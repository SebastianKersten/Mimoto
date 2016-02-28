<?php

// classpath
namespace MaidoProjects\Subproject;

// Momkai classes
use MaidoProjects\Subproject\Subproject;
use MaidoProjects\Subproject\SubprojectRepositoryCriteria;
use MaidoProjects\Subproject\SubprojectException;
use MaidoProjects\Subproject\SubprojectPhases;


/**
 * SubprojectRepository
 *
 * @author Sebastian Kersten
 */
class SubprojectRepository
{
    
    // private
    const MYSQL_TABLE_SUBPROJECTS = 'subprojects';
    
    
    
    public function __construct() {}
    
    
    public function get($nId)
    {
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_SUBPROJECTS." WHERE id=".$nId;
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        if ($nItemCount !== 1)
        {
             throw new SubprojectException('Cannot find subproject with ID='.$nId);
        }
        else
        {
            
            // init
            $subproject = new Subproject();
            
            // register
            $subproject->setId(mysql_result($result, 0, 'id'));
            $subproject->setName(mysql_result($result, 0, 'name'));
            
            // send
            return $subproject;
        }
    }
    
    public function find(SubprojectRepositoryCriteria $criteria = null)
    {
        
        // init
        $aSubprojects = array
        (
            SubprojectPhases::REQUEST => array(),
            SubprojectPhases::CURRENTPROJECT => array(),
            SubprojectPhases::ARCHIVED => array()
        );
        
        // load
        switch($criteria->getCriterium())
        {
            case SubprojectRepositoryCriteria::ALL:
                
                $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_SUBPROJECTS." ORDER BY name ASC";
                break;
                
            case SubprojectRepositoryCriteria::BY_PROJECT_ID:
                
                $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_SUBPROJECTS." WHERE project_id='".$criteria->getProjectId()."' ORDER BY name ASC";
                break;
            
            default:
                
                throw new SubprojectException('Cannot find subprojects with these CRITERIA');
        }
                
        
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $subproject = new Subproject();
            
            $subproject->setId(mysql_result($result, $i, 'id'));
            $subproject->setName(mysql_result($result, $i, 'name'));
            $subproject->setContactName(mysql_result($result, $i, 'contact_name'));
            $subproject->setPhase(mysql_result($result, $i, 'phase'));
            $subproject->setStateId(mysql_result($result, $i, 'state_id'));
            
            $subproject->setStateName('xxx');
            
            $subproject->setProbability(mysql_result($result, $i, 'probability'));
            $subproject->setBudget(mysql_result($result, $i, 'budget'));
            $subproject->setPaymentType(mysql_result($result, $i, 'payment_type'));
            
            
            $aSubprojects[$subproject->getPhase()][] = $subproject;
        }
        
        // send
        return $aSubprojects;
    }
    
}

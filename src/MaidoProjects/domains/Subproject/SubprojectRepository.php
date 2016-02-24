<?php

namespace MaidoProjects\Subproject;

use MaidoProjects\Subproject\Subproject;
use MaidoProjects\Subproject\SubprojectException;


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
    
    public function find()
    {
        
        // init
        $aSubprojects = array();
        
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_SUBPROJECTS." ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $subproject = new Client();
            
            $subproject->setId(mysql_result($result, $i, 'id'));
            $subproject->setName(mysql_result($result, $i, 'name'));
            
            $aSubprojects[] = $subproject;
        }
        
        // send
        return $aSubprojects;
    }
    
}

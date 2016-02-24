<?php

namespace MaidoProjects\Agency;

use MaidoProjects\Agency\Agency;
use MaidoProjects\Agency\AgencyException;


/**
 * ClientRepository
 *
 * @author Sebastian Kersten
 */
class AgencyRepository
{
    
    // private
    const MYSQL_TABLE_AGENCIES = 'agencies';
    
    
    
    public function __construct() {}
    
    
    public function get($nId)
    {
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_AGENCIES." WHERE id=".$nId;
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        if ($nItemCount !== 1)
        {
             throw new AgencyException('Cannot find agency with ID='.$nId);
        }
        else
        {
            
            // init
            $agency = new Agency();
            
            // register
            $agency->setId(mysql_result($result, 0, 'id'));
            $agency->setName(mysql_result($result, 0, 'name'));
            
            // send
            return $agency;
        }
    }
    
    public function find()
    {
        
        // init
        $aAgencies = array();
        
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_AGENCIES." ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $agency = new Agency();
            
            $agency->setId(mysql_result($result, $i, 'id'));
            $agency->setName(mysql_result($result, $i, 'name'));
            
            $aAgencies[] = $agency;
        }
        
        // send
        return $aAgencies;
    }
    
}

<?php

namespace MaidoProjects\Subproject;

use MaidoProjects\Subproject\SubprojectState;
use MaidoProjects\Subproject\SubprojectStateException;


/**
 * SubprojectStateRepository
 *
 * @author Sebastian Kersten
 */
class SubprojectStateRepository
{
    
    // private
    const MYSQL_TABLE_SUBPROJECTSTATES = 'subproject_states';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct() {}
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get subproject state by ID
     * @param int $nId
     * @return SubprojectState
     * @throws SubprojectStateException
     */
    public function get($nId)
    {
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_SUBPROJECTSTATES." WHERE id=".$nId;
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        if ($nItemCount !== 1)
        {
             throw new SubprojectStateException('Cannot find subproject state with ID='.$nId);
        }
        else
        {
            
            // init
            $subprojectState = new SubprojectState();
            
            // register
            $subprojectState->setId(mysql_result($result, 0, 'id'));
            $subprojectState->setName(mysql_result($result, 0, 'name'));
            
            // send
            return $subprojectState;
        }
    }
    
    /**
     * Find subproject states
     * @return Array containing SubprojectState
     */
    public function find()
    {
        
        // init
        $aSubprojectStates = array();
        
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_SUBPROJECTSTATES." ORDER BY created ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $subprojectState = new SubprojectState();
            
            $subprojectState->setId(mysql_result($result, $i, 'id'));
            $subprojectState->setName(mysql_result($result, $i, 'name'));
            
            $aSubprojectStates[] = $subprojectState;
        }
        
        // send
        return $aSubprojectStates;
    }
    
    /**
     * Store subproject state
     * @param type $nId
     * @param type $sName
     */
    public function store($nId, $sName)
    {
        
        if (!empty($nId) && !is_nan($nId))
        {
             $query = "
                UPDATE
                    ".self::MYSQL_TABLE_SUBPROJECTSTATES."
                SET
                    name='".$sName."',
                    created='".date('YmdHis')."'
                WHERE
                    id='".$nId."'";
            
            $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        }
        else
        {
            $query = "
                INSERT INTO
                    ".self::MYSQL_TABLE_SUBPROJECTSTATES."
                SET
                    name='".$sName."',
                    created='".date('YmdHis')."'";

            $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        }
    }
    
}

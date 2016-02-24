<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Momkai classes
use MaidoProjects\ProjectManager\ProjectManager;
use MaidoProjects\ProjectManager\ProjectManagerException;


/**
 * ProjectManagerRepository
 *
 * @author Sebastian Kersten
 */
class ProjectManagerRepository
{
    
    // private
    const MYSQL_TABLE_PROJECTMANAGERS = 'projectmanagers';
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructief -----------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct() {}
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get single project manager by ID
     * @param int $nId
     * @return ProjectManager
     * @throws ProjectManagerException
     */
    public function get($nId)
    {
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_PROJECTMANAGERS." WHERE id=".$nId;
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        if ($nItemCount !== 1)
        {
             throw new ProjectManagerException('Cannot find project manager with ID='.$nId);
        }
        else
        {
            
            // init
            $projectManager = new ProjectManager();
            
            // register
            $projectManager->setId(mysql_result($result, 0, 'id'));
            $projectManager->setName(mysql_result($result, 0, 'name'));
            
            // send
            return $projectManager;
        }
    }
    
    /**
     * Find project managers
     * @return Array containing ProjectManager
     */
    public function find()
    {
        
        // init
        $aProjectManagers = array();
        
        // load
        $sQuery = "SELECT * FROM ".self::MYSQL_TABLE_PROJECTMANAGERS." ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        // register
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $projectManager = new ProjectManager();
            
            $projectManager->setId(mysql_result($result, $i, 'id'));
            $projectManager->setName(mysql_result($result, $i, 'name'));
            
            $aProjectManagers[] = $projectManager;
        }
        
        // send
        return $aProjectManagers;
    }
    
    /**
     * Store project manager
     * @param type $nId
     * @param type $sName
     */
    public function store($nId, $sName)
    {
        
        if (!empty($nId) && !is_nan($nId))
        {
             $query = "
                UPDATE
                    ".self::MYSQL_TABLE_PROJECTMANAGERS."
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
                    ".self::MYSQL_TABLE_PROJECTMANAGERS."
                SET
                    name='".$sName."',
                    created='".date('YmdHis')."'";

            $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        }
    }    
    
}

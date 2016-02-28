<?php

// classpath
namespace MaidoProject\Subproject;

/**
 * subproject filter
 *
 * @author Sebastian Kersten
 */
class SubprojectFilter {
    
    const COOKIE_FILTER = 'filter';
    const FILTER_SETTING_REQUEST = 'request';
    const FILTER_SETTING_CURRENTPROJECT = 'currentproject';
    const FILTER_SETTING_ARCHIVED = 'archived';
    
    
    public function getCurrentFilterSettings()
    {   
        
        // clear
        unset($_COOKIE[self::COOKIE_FILTER]);
        
        
        
        // default filter settings
        if (!isset($_COOKIE[self::COOKIE_FILTER]))
        {
            // init
            $filterSettings = $defaultFilterSettings = array(
                self::FILTER_SETTING_REQUEST => true,
                self::FILTER_SETTING_CURRENTPROJECT => true
            );
            
            // store
            setcookie(self::COOKIE_FILTER, json_encode($defaultFilterSettings));
        }
        else
        {
            $filterSettings = json_decode($_COOKIE[self::COOKIE_FILTER], true);
        }
        
        
        // load data
        $aProjects = $app['ProjectService']->getAllProjects($filterSettings);
        
    }
}

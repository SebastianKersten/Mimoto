<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaidoProjects\Controller\pages;


use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * Description of newPHPClass
 *
 * @author apple
 */
class SettingsController
{
    
    /**
     * Get settings overview
     * @param Application $app
     * @return rendered twig
     */
    public function getOverview(Application $app)
    {   
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/overview.twig'
            )
        );
    }
    
    /**
     * Get project manager overview
     * @param Application $app
     * @return rendered twig
     */
    public function getProjectManagerOverview(Application $app)
    {   
        
        $sQuery = "
            SELECT 
                *
            FROM
                projectmanagers
            ORDER BY
                name ASC";
                
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        
        $aObjects = array();
        
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $object = (object) array();
            
            $object->id = mysql_result($result, $i, 'id');
            $object->label = mysql_result($result, $i, 'name');
            
            $aObjects[] = $object;
        }
        // in use | unused
        //print_r($aObjects);
        //die();
        
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/projectmanagers.twig',
                'simplelist_data' => $aObjects
            )
        );
    }
    
    public function formNewProjectManager(Application $app)
    {   
        return $app['twig']->render(
            'forms/projectmanager.twig'
        );
    }
    
    public function saveProjectManager(Application $app, Request $request)
    {
        
        $sName = $request->get('name');
        
        
        $query = "
            INSERT INTO
                projectmanagers
            SET
                name='".$sName."',
                created='".date('YmdHis')."'";
        
        $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        
        
        $response = (object) array();
        $response->result = 'Ok!';
        $response->name = $sName;
        
        return json_encode($response);
    }    
    
    
    /**
     * Get client overview
     * @param Application $app
     * @return rendered twig
     */
    public function getClientOverview(Application $app)
    {   
        
        $sQuery = "
            SELECT 
                *
            FROM
                clients
            ORDER BY
                name ASC";
                
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        
        $aObjects = array();
        
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $object = (object) array();
            
            $object->id = mysql_result($result, $i, 'id');
            $object->label = mysql_result($result, $i, 'name');
            
            $aObjects[] = $object;
        }
        // in use | unused
        //print_r($aObjects);
        //die();
        
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/clients.twig',
                'simplelist_data' => $aObjects
            )
        );
    }
    
    public function saveClient(Application $app, Request $request)
    {
        
        $sName = $request->get('name');
        
        
        $query = "
            INSERT INTO
                clients
            SET
                name='".$sName."',
                created='".date('YmdHis')."'";
        
        $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        
        
        $response = (object) array();
        $response->result = 'Ok!';
        $response->name = $sName;
        
        return json_encode($response);
    }   
    
    public function formNewClient(Application $app)
    {   
        return $app['twig']->render(
            'forms/client.twig'
        );
    }
    
    
    
    /**
     * Get client overview
     * @param Application $app
     * @return rendered twig
     */
    public function getAgencyOverview(Application $app)
    {   
        
        $sQuery = "
            SELECT 
                *
            FROM
                agencies
            ORDER BY
                name ASC";
                
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        
        $aObjects = array();
        
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $object = (object) array();
            
            $object->id = mysql_result($result, $i, 'id');
            $object->label = mysql_result($result, $i, 'name');
            
            $aObjects[] = $object;
        }
        // in use | unused
        //print_r($aObjects);
        //die();
        
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/agencies.twig',
                'simplelist_data' => $aObjects
            )
        );
    }
    
    public function formNewAgency(Application $app)
    {   
        return $app['twig']->render(
            'forms/agency.twig'
        );
    }
    
    public function saveAgency(Application $app, Request $request)
    {
        
        $sName = $request->get('name');
        
        
        $query = "
            INSERT INTO
                agencies
            SET
                name='".$sName."',
                created='".date('YmdHis')."'";
        
        $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        
        
        $response = (object) array();
        $response->result = 'Ok!';
        $response->name = $sName;
        
        return json_encode($response);
    }   
}
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
                'simplelist_data' => $aObjects,
                'changeMethod' => 'changeProjectManager'
            )
        );
    }
    
    public function formProjectManager(Application $app, $id = false)
    {
        return $this->formSimpleListItem($app, 'projectmanagers', 'projectmanager', $id);
    }
    
    public function saveProjectManager(Application $app, Request $request)
    {
        return $this->saveSimpleListItem('projectmanagers', $request->get('id'), $request->get('name'));
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
                'simplelist_data' => $aObjects,
                'changeMethod' => 'changeClient'
            )
        );
    }
    
    
    public function formClient(Application $app, $id = false)
    {
        return $this->formSimpleListItem($app, 'clients', 'client', $id);
    }
    
    public function saveClient(Application $app, Request $request)
    {
        return $this->saveSimpleListItem('clients', $request->get('id'), $request->get('name'));
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
                'simplelist_data' => $aObjects,
                'changeMethod' => 'changeAgency'
            )
        );
    }
    
    public function formAgency(Application $app, $id = false)
    {
        return $this->formSimpleListItem($app, 'agencies', 'agency', $id);
    }
    
    public function saveAgency(Application $app, Request $request)
    {
        return $this->saveSimpleListItem('agencies', $request->get('id'), $request->get('name'));
    }
    
    
    
    
    
    
    private function formSimpleListItem(Application $app, $sDBTable, $sTwig, $nID)
    {
        
        $aData = array();
        
        if ($nID !== false && !is_nan($nID))
        {   
            $sQuery = "SELECT * FROM ".$sDBTable." WHERE id='".$nID."'";
            $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
            $nItemCount = mysql_num_rows($result);
            
            if ($nItemCount == 1)
            {
                $aData['id'] = mysql_result($result, 0, 'id');
                $aData['name'] = mysql_result($result, 0, 'name');
            }
        }
        
        return $app['twig']->render(
            'forms/'.$sTwig.'.twig',
            $aData
        );
    }
    
    private function saveSimpleListItem($sDBTable, $nID, $sName)
    {
        
        if (!empty($nID) && !is_nan($nID))
        {
             $query = "
                UPDATE
                    ".$sDBTable."
                SET
                    name='".$sName."',
                    created='".date('YmdHis')."'
                WHERE
                    id='".$nID."'";
            
            $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        }
        else
        {
            $query = "
                INSERT INTO
                    ".$sDBTable."
                SET
                    name='".$sName."',
                    created='".date('YmdHis')."'";

            $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        }
        
        
        $response = (object) array();
        $response->result = 'Ok!';
        $response->name = $sName;
        
        return json_encode($response);
    }    
}
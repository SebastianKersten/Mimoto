<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MaidoProjects\UserInterface;


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
    public function getSettingsOverview(Application $app)
    {   
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/SettingsOverviewPage.twig'
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
        
        // load data
        $aProjectManagers = $app['ProjectManagerService']->getAllProjectManagers();
        
        // output
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/ProjectManagersPage.twig',
                'simplelist_data' => $aProjectManagers,
                'changeMethod' => 'changeProjectManager'
            )
        );
    }
    
    public function formProjectManager(Application $app, $nId = false)
    {
        // init
        $data = [];
        
        if ($nId !== false && !is_nan($nId))
        { 
            // load data
            $data['data'] = $app['ProjectManagerService']->getProjectManagerById($nId);
        }
        
        // output
        return $app['twig']->render(
            'forms/ProjectManagerForm.twig',
            $data
        );
    }
    
    public function saveProjectManager(Application $app, Request $request)
    {
        
        // load data
        $app['ProjectManagerService']->saveProjectManager($request->get('id'), $request->get('name'));
        
        // setup
        $response = (object) array();
        $response->result = 'Ok!';
        $response->name = $sName;
        
        // send
        return json_encode($response);
    }
    
    
    /**
     * Get client overview
     * @param Application $app
     * @return rendered twig
     */
    public function getClientOverview(Application $app)
    {   
        
        // load data
        $aClients = $app['ClientService']->getAllClients();
        
        // output
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/ClientsPage.twig',
                'simplelist_data' => $aClients,
                'changeMethod' => 'changeClient'
            )
        );
    }
    
    public function formClient(Application $app, $nId = false)
    {
        // init
        $data = [];
        
        if ($nId !== false && !is_nan($nId))
        { 
            // load data
            $data['data'] = $app['ClientService']->getClientById($nId);
        }
        
        // output
        return $app['twig']->render(
            'forms/ClientForm.twig',
            $data
        );
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
        // load data
        $aAgencies = $app['AgencyService']->getAllAgencies();
        
        // output
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/AgenciesPage.twig',
                'simplelist_data' => $aAgencies,
                'changeMethod' => 'changeAgency'
            )
        );
    }
    
    public function formAgency(Application $app, $nId = false)
    {
        // init
        $data = [];
        
        if ($nId !== false && !is_nan($nId))
        { 
            // load data
            $data['data'] = $app['AgencyService']->getAgencyById($nId);
        }
        
        // output
        return $app['twig']->render(
            'forms/AgencyForm.twig',
            $data
        );
    }
    
    public function saveAgency(Application $app, Request $request)
    {
        return $this->saveSimpleListItem('agencies', $request->get('id'), $request->get('name'));
    }
    
    
    // -------------------------
    // --- Subproject states ---
    // -------------------------
    
    
    /**
     * Get subproject states overview
     * @param Application $app
     * @return rendered twig
     */
    public function getSubprojectStatesOverview(Application $app)
    {   
        
        // load data
        $aSubprojectStates = $app['SubprojectService']->getAllSubprojectStates();
        
        // output
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/SubprojectStatesPage.twig',
                'simplelist_data' => $aSubprojectStates,
                'changeMethod' => 'changeSubprojectState'
            )
        );
    }
    
    
    public function formSubprojectState(Application $app, $nId = false)
    {
        // init
        $data = [];
        
        if ($nId !== false && !is_nan($nId))
        { 
            // load data
            $data['data'] = $app['SubprojectService']->getSubprojectStateById($nId);
        }
        
        // output
        return $app['twig']->render(
            'forms/SubprojectStateForm.twig',
            $data
        );
        
        
        return $this->formSimpleListItem($app, 'subproject_states', 'subproject_state', $id);
    }
    
    public function saveSubprojectState(Application $app, Request $request)
    {
        return $this->saveSimpleListItem('subproject_states', $request->get('id'), $request->get('name'));
    }
    
    public function removeSubprojectState(Application $app, Request $request)
    {
        return $this->saveSimpleListItem('subproject_states', $request->get('id'), $request->get('name'));
    }
    
    
    
    
    // ----------------------
    // --- Common methods ---
    // ----------------------
    
    
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
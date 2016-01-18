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
class ProjectsController
{
    
    public function getIndex(Application $app)
    {   
        
        
        $aProjects = array();
        
        $aProjects[] = array('name' => 'Project 1', 'client' => 'Client 1');
        $aProjects[] = array('name' => 'Project 2', 'client' => 'Client 2');
        $aProjects[] = array('name' => 'Project 3', 'client' => 'Client 3');
        
        
        
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'projects',
                'pagetemplate' => 'page_projects.twig',
                'projects' => $aProjects
            )
        );
    }
    
    public function formNewProject(Application $app)
    {   
        
        $sQuery = "SELECT * FROM clients ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        $aClients = array();
        
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $object = (object) array();
            
            $object->id = mysql_result($result, $i, 'id');
            $object->name = mysql_result($result, $i, 'name');
            
            $aClients[] = $object;
        }
        
        $sQuery = "SELECT * FROM agencies ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        $aAgencies = array();
        
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $object = (object) array();
            
            $object->id = mysql_result($result, $i, 'id');
            $object->name = mysql_result($result, $i, 'name');
            
            $aAgencies[] = $object;
        }
        
        $sQuery = "SELECT * FROM projectmanagers ORDER BY name ASC";
        $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
        $nItemCount = mysql_num_rows($result);
        
        $aProjectManagers = array();
        
        for ($i = 0; $i < $nItemCount; $i++)
        {
            
            $object = (object) array();
            
            $object->id = mysql_result($result, $i, 'id');
            $object->name = mysql_result($result, $i, 'name');
            
            $aProjectManagers[] = $object;
        }
        
        return $app['twig']->render(
            'forms/project.twig',
            array(
                'clients' => $aClients,
                'agencies' => $aAgencies,
                'projectmanagers' => $aProjectManagers
            )
        );
    }
    
    public function saveProject(Application $app, Request $request)
    {
        
        $sName = $request->get('name');
        $sDescription = $request->get('description');
        $nClientID = $request->get('client_id');
        $nAgencyID = $request->get('agency_id');
        $nProjectManagerID = $request->get('projectmanager_id');
        
        
        $query = "
            INSERT INTO
                projects
            SET
                name='".$sName."',
                description='".$sDescription."',
                client_id='".$nClientID."',
                agency_id='".$nAgencyID."',
                projectmanager_id='".$nProjectManagerID."',
                created='".date('YmdHis')."'";
        
        $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        
        
        $response = (object) array();
        $response->result = 'Ok!';
        $response->name = $sName;
        
        return json_encode($response);
    }   
}

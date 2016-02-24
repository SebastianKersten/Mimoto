<?php

// classpath
namespace MaidoProjects\UserInterface;

// Silex classes
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * ProjectsController
 *
 * @author Sebastian Kersten
 */
class ProjectsController
{
    
    public function getProjectOverview(Application $app)
    {   
        
        // load data
        $aProjects = $app['ProjectService']->getAllProjects();
        
        // in use | unused
        //print_r($aProjects);
        //die();
        
        
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'projects',
                'pagetemplate' => 'pages/projects/ProjectsPage.twig',
                'projects' => $aProjects
            )
        );
    }
    
    
    
    
    public function formProject(Application $app, $id = false)
    {   
        
        $aData = array();
        
        if ($id !== false && !is_nan($id))
        {   
            $sQuery = "SELECT * FROM projects WHERE id='".$id."'";
            $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
            $nItemCount = mysql_num_rows($result);
            
            if ($nItemCount == 1)
            {
                $aData['id'] = mysql_result($result, 0, 'id');
                $aData['name'] = mysql_result($result, 0, 'name');
                $aData['description'] = mysql_result($result, $i, 'description');
                $aData['client_id'] = mysql_result($result, $i, 'client_id');
                $aData['agency_id'] = mysql_result($result, $i, 'agency_id');
                $aData['projectmanager_id'] = mysql_result($result, $i, 'projectmanager_id');
            }
        }
        
        
        
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
                'projectmanagers' => $aProjectManagers,
                'formdata' => $aData
            )
        );
    }
    
    public function saveProject(Application $app, Request $request)
    {
        
        $nID = $request->get('id');
        $sName = $request->get('name');
        $sDescription = $request->get('description');
        $nClientID = $request->get('client_id');
        $nAgencyID = $request->get('agency_id');
        $nProjectManagerID = $request->get('projectmanager_id');
        
        
        if (!empty($nID) && !is_nan($nID))
        {
            $query = "
                UPDATE
                    projects
                SET
                    name='".$sName."',
                    description='".$sDescription."',
                    client_id='".$nClientID."',
                    agency_id='".$nAgencyID."',
                    projectmanager_id='".$nProjectManagerID."'
                WHERE
                    id='".$nID."'";
        
            $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        }
        else
        {
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
        }
        
        
        $response = (object) array();
        $response->result = 'Ok!';
        $response->name = $sName;
        
        return json_encode($response);
    }
    
    
    
    public function formSubproject(Application $app, $project_id = false)
    {   
        
        $aData = array();
        
        if ($project_id !== false && !is_nan($project_id))
        {
            
            
            
            $sQuery = "SELECT * FROM subprojects WHERE project_id='".$project_id."'";
            $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
            $nItemCount = mysql_num_rows($result);
            
            if ($nItemCount == 1)
            {
                $aData['id'] = mysql_result($result, 0, 'id');
                $aData['name'] = mysql_result($result, 0, 'name');
            }
        }
        
        
        $aProbabilities = array('10%', '50%', '90%');
        $aStates = array(
            'Onbehandeld',
            'Wacht op vervolg',
            'Offerte gestuurd',
            'In uitvoering',
            'Vervallen',
            'Afgerond',
        );
        
        
        // order by period (toekomstige zaken komen verderop in de lijst
        
        return $app['twig']->render(
            'forms/subproject.twig',
            array(
                'probabilities' => $aProbabilities,
                'formdata' => $aData
            )
        );
    }
}

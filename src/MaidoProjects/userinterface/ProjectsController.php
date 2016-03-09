<?php

// classpath
namespace MaidoProjects\UserInterface;

// Momkai classes
use MaidoProjects\Subproject\SubprojectPaymentTypes;
use MaidoProjects\Subproject\SubprojectPhases;
use MaidoProjects\Subproject\SubprojectProbabilities;

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
    
    const COOKIE_FILTER = 'filter';
    const FILTER_SETTING_REQUEST = 'request';
    const FILTER_SETTING_CURRENTPROJECT = 'currentproject';
    const FILTER_SETTING_ARCHIVED = 'archived';
    
    
    public function getProjectOverview(Application $app)
    {   
        
        // clear
        unset($_COOKIE[self::COOKIE_FILTER]);
        
        
        
        // default filter settings
        if (!isset($_COOKIE[self::COOKIE_FILTER]))
        {
            // init
            $filterSettings = $defaultFilterSettings = array(
                self::FILTER_SETTING_REQUEST => true,
                self::FILTER_SETTING_CURRENTPROJECT => true,
                self::FILTER_SETTING_ARCHIVED => false
            );
            
            // store
            setcookie(self::COOKIE_FILTER, json_encode($defaultFilterSettings));
        }
        else
        {
            $filterSettings = json_decode($_COOKIE[self::COOKIE_FILTER], true);
        }
        
        
        // load data
        $aProjects = $app['ProjectService']->getAllProjects();
        
        //echo "<pre>";
        //print_r($aProjects);
        //echo "</pre>";
        //die();
        
        
        
        
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'projects',
                'pagetemplate' => 'pages/projects/ProjectsPage.twig',
                'projects' => $aProjects,
                'filter' => array(
                    self::FILTER_SETTING_REQUEST => $filterSettings[self::FILTER_SETTING_REQUEST] === true,
                    self::FILTER_SETTING_CURRENTPROJECT => $filterSettings[self::FILTER_SETTING_CURRENTPROJECT] === true,
                    self::FILTER_SETTING_ARCHIVED => $filterSettings[self::FILTER_SETTING_ARCHIVED] === true
                )
            )
        );
    }
    
    
    public function formProject(Application $app, $nId = false)
    {   
        
        $aData = array();
        
        if ($nId !== false && !is_nan($nId))
        {   
            $sQuery = "SELECT * FROM projects WHERE id='".$nId."'";
            $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
            $nItemCount = mysql_num_rows($result);
            
            if ($nItemCount == 1)
            {
                $aData['id'] = mysql_result($result, 0, 'id');
                $aData['name'] = mysql_result($result, 0, 'name');
                $aData['description'] = mysql_result($result, 0, 'description');
                $aData['client_id'] = mysql_result($result, 0, 'client_id');
                $aData['agency_id'] = mysql_result($result, 0, 'agency_id');
                $aData['projectmanager_id'] = mysql_result($result, 0, 'projectmanager_id');
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
            'forms/ProjectForm.twig',
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
    
    
    
    public function formSubproject(Application $app, $nProjectId = false, $nId = false)
    {   
        
        $aFormData = array();
        
        if ($nId !== false && !is_nan($nId))
        {
            
            $sQuery = "SELECT * FROM subprojects WHERE id='".$nId."'";
            $result = mysql_query($sQuery) or die('Query failed: ' . mysql_error());
            $nItemCount = mysql_num_rows($result);
            
            if ($nItemCount == 1)
            {
                $aFormData['id'] = mysql_result($result, 0, 'id');
                $aFormData['name'] = mysql_result($result, 0, 'name');
                $aFormData['contact_name'] = mysql_result($result, 0, 'contact_name');
                $aFormData['phase'] = mysql_result($result, 0, 'phase');
                $aFormData['state_id'] = mysql_result($result, 0, 'state_id');
                $aFormData['probability'] = mysql_result($result, 0, 'probability');
                $aFormData['budget'] = mysql_result($result, 0, 'budget');
                $aFormData['payment_type'] = mysql_result($result, 0, 'payment_type');
            }
        }
        
        
        $aPhases = [
            (object) array('label' => 'Request', 'value' => SubprojectPhases::REQUEST),
            (object) array('label' => 'Current project', 'value' => SubprojectPhases::CURRENTPROJECT),
            (object) array('label' => 'Archived', 'value' => SubprojectPhases::ARCHIVED),
        ];
        
        $aProbabilities = [
            (object) array('label' => '10%', 'value' => SubprojectProbabilities::VERY_UNSURE),
            (object) array('label' => '50%', 'value' => SubprojectProbabilities::COULD_GO_EITHER_WAY),
            (object) array('label' => '90%', 'value' => SubprojectProbabilities::PRETTY_SURE),
        ];
        
        $aPaymentTypes = [
            (object) array('label' => 'Time/material', 'value' => SubprojectPaymentTypes::TIME_MATERIAL),
            (object) array('label' => 'Fixed', 'value' => SubprojectPaymentTypes::FIXED)
        ];
        
        
        $aStates = [
            (object) array('label' => 'Onbehandeld', 'id' => 1),
            (object) array('label' => 'Wacht op vervolg', 'id' => 2),
            (object) array('label' => 'Offerte gestuurd', 'id' => 3),
            (object) array('label' => 'In uitvoering', 'id' => 4),
            (object) array('label' => 'Vervallen', 'id' => 5),
            (object) array('label' => 'Afgerond', 'id' => 6),
        ];
        
        
        // order by period (toekomstige zaken komen verderop in de lijst
        
        
        $twigData = array(
            'phases' => $aPhases,
            'states' => $aStates,
            'probabilities' => $aProbabilities,
            'payment_types' => $aPaymentTypes,
            'formdata' => $aFormData
        );
        
        if ($nProjectId !== false) { $twigData['project_id'] = $nProjectId; }

        
        // output
        return $app['twig']->render(
            'forms/SubprojectForm.twig',
            $twigData
        );
    }
    
    
    public function saveSubproject(Application $app, Request $request)
    {
        
        $nProjectId = $request->get('project_id');
        $nId = $request->get('id');
        $sName = $request->get('name');
        $sContactName = $request->get('contact_name');
        $sPhase = $request->get('phase');
        $nStateId = $request->get('state_id');
        $nProbability = $request->get('probability');
        $nBudget = $request->get('budget');
        $sPaymentType = $request->get('payment_type');
        
        
        if (!empty($nId) && !is_nan($nId))
        {
            $query = "
                UPDATE
                    subprojects
                SET
                    name='".$sName."',
                    contact_name='".$sContactName."',
                    phase='".$sPhase."',
                    state_id='".$nStateId."',
                    probability='".$nProbability."',
                    budget='".$nBudget."',
                    payment_type='".$sPaymentType."'
                WHERE
                    id='".$nId."'";
        
            $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        }
        else
        {
            $query = "
                INSERT INTO
                    subprojects
                SET
                    name='".$sName."',
                    contact_name='".$sContactName."',
                    project_id='".$nProjectId."',
                    phase='".$sPhase."',
                    state_id='".$nStateId."',
                    probability='".$nProbability."',
                    budget='".$nBudget."',
                    payment_type='".$sPaymentType."',
                    created='".date('YmdHis')."'";
        
            $result = mysql_query($query) or die('Query failed: ' . mysql_error());
        }
        
        
        $response = (object) array();
        $response->result = 'Ok!';
        $response->name = $sName;
        
        return json_encode($response);
    }
}

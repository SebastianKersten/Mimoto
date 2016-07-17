<?php

// classpath
namespace MaidoProjects\UserInterface;

// Momkai classes
use MaidoProjects\Subproject\SubprojectPaymentTypes;
use MaidoProjects\Subproject\SubprojectPhases;
use MaidoProjects\Subproject\SubprojectProbabilities;
use MaidoProjects\Expertise\Expertise;

// Mimoto classes
use Mimoto\Data\MimotoData;
use Mimoto\Data\MimotoEntity;

// Silex classes
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * ProjectsController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ProjectsController
{
    
    const COOKIE_FILTER = 'filter';
    const FILTER_SETTING_REQUEST = 'request';
    const FILTER_SETTING_CURRENTPROJECT = 'currentproject';
    const FILTER_SETTING_ARCHIVED = 'archived';
    
    
    public function viewProjects(Application $app)
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
        
        
        
        // load
        $aProjects = $app['Mimoto.Data']->find('project');
        
        // create
        $page = $app['Mimoto.Aimless']->createComponent('page_projects');
        
        // setup
        $page->setCollection('___projects', 'project_listitem', $aProjects);
        
        // render and send
        return $page->render();
        
        
        
        // dashboard -> wat kan er fout gaan: Buckaroo
        
        
        // -----------------------------
        // --- Text Width Calculator ---
        // -----------------------------
        
        
        // "abcdefghijklmnopqrstuvwxyz 1234567890.,;'"
        
        
        // ----------------------------
        // --- Mimoto.Data ---
        // ----------------------------
        
        
        // 1. store entity
        // 2. if hasCanges subentity, forward store
        // 3. connect aimless id generator
        // 4. broadcast update on entity
        // 5. connection.add
        
        
        
        $before = memory_get_usage();
        
        //$client = $app['Mimoto.Data']->getEntityById('client', 2);
//        echo "<pre>";
//        print_r($client);
//        echo "</pre>";
//        
        //$agency = $app['Mimoto.Data']->getEntityById('agency', 1);
//        echo "<pre>";
//        print_r($agency);
//        echo "</pre>";
//        
//        $projectManager = $app['Mimoto.Data']->getEntityById('projectManager', 4);
//        echo "<pre>";
//        print_r($projectManager);
//        echo "</pre>";
//        
//        $subprojectState = $app['Mimoto.Data']->getEntityById('subprojectState', 6);
//        echo "<pre>";
//        print_r($subprojectState);
//        echo "</pre>";
        
        
        //  project = {
        //      name
        //  }
        
        //  "options.mailUpdates" = 
        //  {
        //      type: value
        //      persistentValue: mixed,
        //      currentValue: mixed
        //  }
        
        // private $_persistentId;
        // private $_currentId;
        
        
        // 1. setup unit tests for property selectors
        
        
        
        $project = new MimotoData();
        
        $project->setValueAsProperty('name');
        $project->setEntityAsProperty('client', 'client');
        $project->setEntityAsProperty('agency', 'agency');
        $project->setCollectionAsProperty('subprojects', 'client');
        
        
        $project->setValue('name', 'VanMoof');
        $project->setValue('client', 2);
        $project->setValue('client.name', 'Yeah!');
        $project->setValue('agency', 1);
        
        $client = $project->getValue('client');
        $agency = $project->getValue('agency');
        
        
        //$project->setValue('subprojects', []);
        //$project->setValue('subprojects', [3, $client]); // check doubles
        $project->setValue('subprojects', [2, $client]); // check doubles
        
        
        
        $project->addValue('subprojects', 4);       // should work
        //$project->addValue('subprojects', $client); // should work
        //$project->addValue('subprojects', $agency); // should fail
        
        
        //$sClientName = $project->getValue('client.name'); // mag falen indien client-not-set (null-client? / "")
        
        
//        echo "<hr>";
//        $sProjectName = $project->getValue('name');
//        echo "<br>project.name:<br>";
//        print_r($sProjectName);
//        echo "<br><br>";
        
//        $nClientId = $project->getValue('client', true);
//        $storedClient = $project->getValue('client');
//        echo "Client ID = ".$nClientId."<br>";
//        print_r($storedClient);
        
        
        output('Client', $client);
        
        output('Project', $project);
        
        
        
        
        
        
//        $property = getProperty($sPropertySelector, )
//        
//        
//        
//        $project = $app['Mimoto.Data']->getEntityById('project', 2);
//        
//        
//        $project->setValue('name', 'Bla!');
//        $project->setValue('agency', '2');
//        $project->setValue('options.mailUpdates', 'Hell yes!');
//        $project->setValue('options.sendLiveNotification', 'Oh, certainly not!');
//        
//        echo "<br><hr><br>";
//        
//        $aChanges = $project->getChanges();
//        
//        print_r($aChanges);
//        
//        echo "<hr><br>";
        
        
        
        //$project->add('subprojects', 5);
        
        
        $after = memory_get_usage();
        
        
        
        
        
        echo "<br><br><hr><b style='color:#06AFEA'>Memory usage = ".number_format(ceil(($after - $before)/1000), 0, ',', '.')."kb (".number_format(($after - $before), 0, ',', '.')." bytes)</b><br><br>";
        
        die();
        
        
        // ------------------
        // --- MimotoData ---
        // ------------------
        
        
        $sProjectName = 'Maido.Projects';
        $sProjectDescription = 'Lorem ipsum';
        $nClientId = 2;
        $nAgencyId = '';
        $nProjectManagerId = 1;
        $aSubprojects = [4,7,22];
        
        
        $before = memory_get_usage();
        
        
        $aProjects = [];
        $nEntityCount = 1;
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            
            // init
            $project = new MimotoData(false);
            //MimotoEntityService->getEntity('project', $nId = 0);

            // setup structure
            $project->setValueAsProperty('name');
            $project->setValueAsProperty('description');
            $project->setEntityAsProperty('client', 'client'); // type, id
            $project->setEntityAsProperty('agency', 'agency');
            $project->setEntityAsProperty('projectManager', 'projectManager');
            $project->setCollectionAsProperty('subprojects', 'subproject');
            $project->setValueAsProperty('options.mailUpdates');
            $project->setValueAsProperty('options.sendLiveNotification');

            // set data
            $project->setValue('name', $sProjectName);
            $project->setValue('description', $sProjectDescription);
            $project->setValue('client', $nClientId); // zet id, maar pas op get wordt de echte entity (wat een data is) opgehaald
            $project->setValue('agency', $nAgencyId);
            $project->setValue('projectManager', $nProjectManagerId);
            $project->setValue('subprojects', $aSubprojects);
            $project->setValue('options.mailUpdates', true);
            $project->setValue('options.sendLiveNotification', false);
            
            // eventlisteners op nodes
            // getmodifiedvalues -> als jason (mogelijk hele data opslag als json? met addon voor 
            
            // store
            $aProjects[] = $project;
        }
        
        $after = memory_get_usage();
        
        echo "<b style='color:#06AFEA'>Memory usage with ".$nEntityCount." ".(($nEntityCount == 1) ? 'entity' : 'entities')." = ".number_format(ceil(($after - $before)/1000), 0, ',', '.')."kb (".number_format(($after - $before), 0, ',', '.')." bytes)</b><br><br>";
        
        echo "----<br>";
        
        echo "name = ".$project->getValue('name')."<br>";
        echo "description = ".$project->getValue('description')."<br>";
        echo "client = ".$project->getValue('client')."<br>";
        print_r($project->getValue('client'));
        echo "options.mailUpdates = ".$project->getValue('options.mailUpdates')."<br>";
        echo "options.sendLiveNotification = ".$project->getValue('options.sendLiveNotification')."<br>";
        //echo "nameNotExist = ".$project->getValue('nameNotExist')."<br>";
        
        echo "----<br>";
        
        print_r($project);
        
        
        // #todo
        // ------------------------------------------------------------------------------
        // "Mimoto.Data"
        // "Mimoto.CollectionService"
        // ------------------------------------------------------------------------------
        
        
        
//        if (subitem->hasChanges())
//            $this->_sName + $subitem->getName();
//        
//        
//        public function outputAsJSON() {}
//        
//        // -------
//        
//        $project = MimotoEntity(false);
//        
//        $project->setId(3);
//        $project->setValue('name', 'Maido.Projects');
//        
//        $project->trackChanges();
//        
//        
//        $project->setId(7);
//        
//        if (id changed) -> flush values (= MimotoData)
//        
//        $project->setValue
//                
//        
//        structuur = MimotoData
//        werkelijke data = MimotoEntity
//
//
//        group = MimotoData en wordt automatisch doorgevoerd, het is geen bewuste stap om
//                te groeperen anders dan door het data object zo te structureren
//
//        project.getValue()
//
//
//
//        // values gaan vullen
//        project.setValue('name', $sProjectName);
//        project.setValue('description', $sProjectDescription);
//        project.setValue(''$sPropertyName, $sEntityType); // ophalen via EntityService -> type, via config connected
//        project.setGroupAsProperty($sPropertyName);
                
                
         
        // MimotoGroup = MimotoEntity achtig object zonder entity Id
        
        
        
        echo "</pre>";
        die();
        
        
        // ---- verkapte unittest ----
        
//        echo "<pre>";
//
//        $project = $app['ProjectService']->getEntityById(3);
//        
//        
//        $client = $project->getValue('client');
//        
//        
//        $clientId = $project->getValue('client', false);
//        echo 'Current client.id = '.$clientId.'<br>';
//        
//        $project->setClient(3);
//        
//        
//        $clientId = $project->getValue('client', false);
//        echo 'Current client.id = '.$clientId.'<br>';
//        
//        
//        $project = $app['ProjectService']->storeProject(
//                $project->getId(),
//                $project->getName(),
//                $project->getDescription(),
//                1,
//                0,
//                1
//        );
//        
//        
//        $project = $app['ProjectService']->getEntityById(3);
//        $clientId = $project->getValue('client', false);
//        echo 'Current client.id = '.$clientId.'<br>';
        
//        
//        $client = $project->getClient();
//        echo 'Current client.id = '.$client->getId().'<br>';
//        
//        $agency = $project->getAgency();
//        $projectManager = $project->getProjectManager();
//        
//        
//        print_r($agency);
        
        
//        $nId
//        $sName
//        $sDescription
//        $nClientId
//        $nAgencyId
//        $nProjectManagerId
        
        //$project->getAgency()->getId() // --> getDirectValue (parameter?)
        
        
        
        
//        
        
        
//        echo "</pre>";
//        
//        die();
        
        
        // ---- einde verkapte unittest ----
        
        
        // load data
        $aProjects = $app['ProjectService']->getAllProjects();
        
        // output
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => '___projects',
                'pagetemplate' => 'pages/___projects/ProjectsPage.twig',
                '___projects' => $aProjects,
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
        // init
        $aData = array();
        
        if ($nId !== false && !is_nan($nId))
        {
            
            $project = $app['ProjectService']->getProjectById($nId);
            
            $aData['id'] = $project->getId();
            $aData['name'] = $project->getName();
            $aData['description'] = $project->getDescription();
            $aData['client_id'] = $project->getValue('client', false);
            $aData['agency_id'] = $project->getValue('agency', false);
            $aData['projectmanager_id'] = $project->getValue('projectmanager', false);
        }
        
        // dropdown data
        $aClients = $app['ClientService']->getAllClients();
        $aAgencies = $app['AgencyService']->getAllAgencies();
        $aProjectManagers = $app['ProjectManagerService']->getAllProjectManagers();
        
        
        
        // form config
    // inputfield->type, options
    
    
    // general loadForm
    // general saveForm
    // by config
    
//    $form = (object) array();
//    
//    $form->name = 'project';
//    $form->entity = 'project';
//    $form->addField('name', 'textline', $config);
//    $form->addField('description', 'textfield', { label:'Project description', autoFocus:true, saveOnEnter:true });
//    $form->addField('client_id', 'dropdown', { label:'Client', values:[] });
//    $form->addField('agency_id', 'dropdown', { label:'Agency', optional:true, values:[] });
//    $form->addField('projectmanager_id', 'dropdown', { label:'Project manager', values:[] });
//    $form->setValues($entity);
//    
//    $form->onSave->connectToEntity(); // add/remove and auto move
//    $form->onSave->connectToMultipleEntities('client'); // add/remove
//            
//    
//    
//    $form->name = 'client';
//    $form->entity = 'client';
//    $form->addField('name', 'textline', { label:'Name', maxchars:255, autoFocus:true, saveOnEnter:true });
//    $form->setValues($entity);
//    
//    
//    loadForm($sFormName, $nEntityId);
    
    
    // entityMaker
    // formMaker
    
    
    // eventlistener op wijziging project.subprojects -> herberekenen budgetten, 
    // -> broadcast ViewModel.ProjectBudgets (met berkeningen)
        
        
        
        
        // output
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
        
        // load data
        $app['ProjectService']->storeProject(
            $request->get('id'),
            $request->get('name'),
            $request->get('description'),
            $request->get('client_id'),
            $request->get('agency_id'),
            $request->get('projectmanager_id')    
        );
        
        // setup
        $response = (object) array();
        $response->result = 'Ok!';
        
        // send
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

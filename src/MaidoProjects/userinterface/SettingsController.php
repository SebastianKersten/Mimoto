<?php

// classpath
namespace MaidoProjects\UserInterface;

// Mimoto classes
use Mimoto\library\controllers\MimotoController;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * SettingsController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SettingsController extends MimotoController
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
                'pagetemplate' => 'pages/settings/SettingsOverviewPage.twig',
                'pageSubTemplate' => 'pages/settings/projectmanagers/ProjectManagersPage.twig',
                'projectManagers' => $aProjectManagers
            )
        );
    }
    
    /**
     * Get the form to create or edit a project manager
     * @param Application $app
     * @param $nId The project manager's ID or empty in case of new project manager
     * @return rendered HTML
     */
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
    
    /**
     * Save project manager
     * @param Application $app
     * @param Request $request
     * @return json with result
     */
    public function saveProjectManager(Application $app, Request $request)
    {
        // load data
        $app['ProjectManagerService']->storeProjectManager($request->get('id'), $request->get('name'));
        
        // setup
        $response = (object) array();
        $response->result = 'Ok!';
        
        // send
        return json_encode($response);
    }
    
    
    /**
     * View clients
     * @param Application $app
     * @return rendered twig
     */
    public function viewClients(Application $app)
    {   
        // load
        $aClients = $app['Mimoto.Data']->find('client');
        
        // create
        $page = $app['Mimoto.Aimless']->createComponent('settingspage');
        
        // setup
        $page->setCollection('clients', 'simplelistitem', $aClients);
        
        // render and send
        return $page->render();
    }
    
    /**
     * Get the form to create or edit a client
     * @param Application $app
     * @param $nId The client's ID or empty in case of new client
     * @return rendered HTML
     */
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
    
    /**
     * Save client
     * @param Application $app
     * @param Request $request
     * @return json with result
     */
    public function saveClient(Application $app, Request $request)
    {
        // load data
        $app['ClientService']->storeClient($request->get('id'), $request->get('name'));
        
        // setup
        $response = (object) array();
        $response->result = 'Ok!';
        
        // send
        return json_encode($response);
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
                'pagetemplate' => 'pages/settings/SettingsOverviewPage.twig',
                'pageSubTemplate' => 'pages/settings/agencies/AgenciesPage.twig',
                'agencies' => $aAgencies
            )
        );
    }
    
    /**
     * Get the form to create or edit an agency
     * @param Application $app
     * @param $nId The agency's ID or empty in case of new agency
     * @return rendered HTML
     */
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
    
    /**
     * Save agency
     * @param Application $app
     * @param Request $request
     * @return json with result
     */
    public function saveAgency(Application $app, Request $request)
    {
        // load data
        $app['AgencyService']->storeAgency($request->get('id'), $request->get('name'));
        
        // setup
        $response = (object) array();
        $response->result = 'Ok!';
        
        // send
        return json_encode($response);
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
        $aSubprojectStates = $app['SubprojectStateService']->getAllSubprojectStates();
        
        // output
        return $app['twig']->render(
            'interface.twig',
            array(
                'section' => 'settings',
                'pagetemplate' => 'pages/settings/SettingsOverviewPage.twig',
                'pageSubTemplate' => 'pages/settings/subprojectstates/SubprojectStatesPage.twig',
                'subprojectStates' => $aSubprojectStates
            )
        );
    }
    
    /**
     * Get the form to create or edit a subproject state
     * @param Application $app
     * @param $nId The subproject state's ID or empty in case of new subproject state
     * @return rendered HTML
     */
    public function formSubprojectState(Application $app, $nId = false)
    {
        // init
        $data = [];
        
        if ($nId !== false && !is_nan($nId))
        { 
            // load data
            $data['data'] = $app['SubprojectStateService']->getSubprojectStateById($nId);
        }
        
        // output
        return $app['twig']->render(
            'forms/SubprojectStateForm.twig',
            $data
        );
    }
    
    /**
     * Save subproject state
     * @param Application $app
     * @param Request $request
     * @return json with result
     */
    public function saveSubprojectState(Application $app, Request $request)
    {
        // load data
        $app['SubprojectStateService']->storeSubprojectState($request->get('id'), $request->get('name'));
        
        // setup
        $response = (object) array();
        $response->result = 'Ok!';
        
        // send
        return json_encode($response);
    }
   
}
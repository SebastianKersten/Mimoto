<?php

// classpath
namespace MaidoProjects\UserInterface;

// Silex classes
use Silex\Application;


/**
 * LivescreenController
 *
 * @author Sebastian Kersten
 */
class LivescreenController
{
    
    public function getClient(Application $app, $nId)
    {
        
        $client = $app['ClientService']->getClientById($nId);
        
        
        return $app['twig']->render(
            'components/data/simplelist_item.twig',
            array(
                'id' => $nId,
                'label' => $client->getName(),
                'changeMethod' => 'changeClient'
            )
        );
    }
    
    public function getAgency(Application $app, $nId)
    {
        
        $client = $app['AgencyService']->getAgencyById($nId);
        
        
        return $app['twig']->render(
            'components/data/simplelist_item.twig',
            array(
                'id' => $nId,
                'label' => $client->getName(),
                'changeMethod' => 'changeAgency'
            )
        );
    }
    
    public function getProjectManager(Application $app, $nId)
    {
        
        $client = $app['ProjectManagerService']->getProjectManagerById($nId);
        
        
        return $app['twig']->render(
            'components/data/simplelist_item.twig',
            array(
                'id' => $nId,
                'label' => $client->getName(),
                'changeMethod' => 'changeProjectManager'
            )
        );
    }
    
    public function getSubprojectState(Application $app, $nId)
    {
        
        $client = $app['SubprojectService']->getSubprojectStateById($nId);
        
        
        return $app['twig']->render(
            'components/data/simplelist_item.twig',
            array(
                'id' => $nId,
                'label' => $client->getName(),
                'changeMethod' => 'changeSubprojectstate'
            )
        );
    }
}

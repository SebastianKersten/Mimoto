<?php

// classpath
namespace Mimoto\Livescreen;

// Silex classes
use Silex\Application;


/**
 * MimotoLivescreenController
 *
 * @author Sebastian Kersten
 */
class MimotoLivescreenController
{
    
    public function getView(Application $app, $sEntityType, $nId, $sTemplate)
    {
        
        // connect entity to service and connect template
        
        
        $client = $app['ClientService']->getClientById($nId);
        
        
        
        //call service en laat die de logicat uitvoeren, niet deze class!!
        
        
        return $app['twig']->render(
            'pages/settings/clients/ClientListItem.twig',
            array(
                'client' => $client,
                'changeMethod' => 'changeClient'
            )
        );
    }
    
}

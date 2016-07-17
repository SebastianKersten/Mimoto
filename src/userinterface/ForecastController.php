<?php

// classpath
namespace MaidoProjects\UserInterface;

// Silex classes
use Silex\Application;


/**
 * ForecastController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ForecastController
{
    
    public function viewForecast(Application $app)
    {
        // create
        $page = $app['Mimoto.Aimless']->createComponent('page_forecast');
        
        // render and send
        return $page->render();
    }
    
}

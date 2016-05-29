<?php

// classpath
namespace MaidoProjects\UserInterface;

// Silex classes
use Silex\Application;


/**
 * ResultController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ResultController
{
    
    public function viewResult(Application $app)
    {   
        // create
        $page = $app['Mimoto.Aimless']->createComponent('page_result');
        
        // render and send
        return $page->render();
    }
    
}

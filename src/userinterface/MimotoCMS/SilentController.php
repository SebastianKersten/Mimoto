<?php

// classpath
namespace MaidoProjects\UserInterface\MimotoCMS;

// Silex classes
use Silex\Application;


/**
 * SilentController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SilentController
{
    
    public function viewSilent(Application $app)
    {
        // create
        $page = $app['Mimoto.Aimless']->createComponent('page_silent');
        
        // render and send
        return $page->render();
    }
    
}

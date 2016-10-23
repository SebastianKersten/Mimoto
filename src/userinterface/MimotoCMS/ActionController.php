<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;


/**
 * ActionController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ActionController
{
    
    public function viewActionOverview(Application $app)
    {
        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_actions_ActionOverview');

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Actions',
                    "url" => '/mimoto.cms/actions'
                )
            )
        );

        // output
        return $page->render();
    }
    
}

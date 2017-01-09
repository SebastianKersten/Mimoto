<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\UserInterface\MimotoCMS\utils\InterfaceUtils;
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
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_actions_ActionOverview');

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

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

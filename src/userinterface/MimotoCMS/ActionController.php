<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
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
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_actions_ActionOverview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Actions',
                    "url" => '/mimoto.cms/actions'
                )
            )
        );

        // 4. output
        return $page->render();
    }
    
}

<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

// Silex classes
use Silex\Application;


/**
 * APIController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class APIController
{

    /**
     * View layout overview
     * @return string The rendered html output
     */
    public function viewAPIOverview()
    {
        // 1. use general module
        // 2. build page
        // 3. use layout




        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_api_APIOverview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'API',
                    "url" => '/mimoto.cms/api'
                )
            )
        );

        // 4. output
        return $page->render();
    }

}

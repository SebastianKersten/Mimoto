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
 * SelectionController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SelectionController
{

    /**
     * View selection overview
     * @return string The rendered html output
     */
    public function viewSelectionOverview()
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_pages_selections_SelectionOverview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Selections',
                    "url" => '/mimoto.cms/selections'
                )
            )
        );

        // 4. output
        return $page->render();
    }

}

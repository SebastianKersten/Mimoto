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
 * PageController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class PageController
{

    /**
     * View page overview
     * @return string The rendered html output
     */
    public function overview()
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_pages_Overview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Pages',
                    "url" => '/mimoto.cms/pages'
                )
            )
        );

        // 4. output
        return $page->render();
    }

    /**
     * View page
     * @return string The rendered html output
     */
    public function pageView(Application $app, $nItemId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $ePage = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROUTE, $nItemId);

        // 3. validate data
        if (empty($ePage)) return $app->redirect("/mimoto.cms/pages");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_pages_Detail', $ePage);

        // 5. connect
        $page->addComponent('content', $component);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Pages',
                    "url" => '/mimoto.cms/pages'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_ROUTE.'.'.$ePage->getId().'.name">'.$ePage->getValue('name').'</span>',
                    "url" => '/mimoto.cms/page/'.$ePage->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

}

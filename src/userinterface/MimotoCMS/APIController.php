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
    public function viewOverview()
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_api_Overview', $eRoot));

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

    /**
     * View page
     * @return string The rendered html output
     */
    public function viewDetail(Application $app, $nInstanceId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eAPI = Mimoto::service('data')->get(CoreConfig::MIMOTO_API, $nInstanceId);

        // 3. validate data
        if (empty($eAPI)) return $app->redirect("/mimoto.cms/api");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_api_Detail', $eAPI);

        // 5. connect
        $page->addComponent('content', $component);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'API',
                    "url" => '/mimoto.cms/api'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_PAGE.'.'.$eAPI->getId().'.name">'.$eAPI->getValue('name').'</span>',
                    "url" => '/mimoto.cms/api/'.$eAPI->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

}

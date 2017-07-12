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
     * View new page form
     * @return string The rendered html output
     */
    public function pageNew()
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create form layout
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup form
        $component->addForm(
            CoreConfig::MIMOTO_ROUTE,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ROOT.'.'.CoreConfig::MIMOTO_ROOT.'.pages',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect content
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
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

    /**
     * Edit page
     * @param Application $app
     * @param $nItemId
     * @return mixed
     */
    public function pageEdit(Application $app, $nItemId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load
        $ePage = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROUTE, $nItemId);

        // 3. validate
        if (empty($ePage)) return $app->redirect("/mimoto.cms/pages");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 5. setup
        $component->addForm(
            CoreConfig::MIMOTO_ROUTE,
            $ePage,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $popup->render();
    }

    /**
     * Delete page
     * @param Application $app
     * @param $nItemId
     * @return mixed
     */
    public function pageDelete(Application $app, $nItemId)
    {
        // 1. load
        $ePage = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROUTE, $nItemId);

        // 2. delete
        Mimoto::service('data')->delete($ePage);

        // 3. output
        return Mimoto::service('messages')->response((object) array('result' => 'Page deleted! '.date("Y.m.d H:i:s")), 200);
    }

}

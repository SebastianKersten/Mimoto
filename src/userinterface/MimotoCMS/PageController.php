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
        $component = Mimoto::service('output')->createComponent('MimotoCMS_pages_pages_Detail', $ePage);

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

    public function createPageFromNonExistingPath(Application $app, Request $request)
    {
        // 1. read
        $sPath = $request->get('path');

        // 2. validate
        if (empty($sPath)) return $app->redirect('/mimoto.cms'); // #todo - improve

        // 3. split
        $aPathElements = explode('/', $sPath);

        // 4. cleanup
        array_splice($aPathElements, 0, 1);


        // ---


        // 5. create
        $eRoute = Mimoto::service('data')->create(Coreconfig::MIMOTO_ROUTE);

        // 6. setup
        $eRoute->set('name', 'Created from non-existing path: '.$sPath); // #todo - improve security

        // 7. create path
        $nPathElementCount = count($aPathElements);
        for ($nPathElementIndex = 0; $nPathElementIndex < $nPathElementCount; $nPathElementIndex++)
        {
            // a. register
            $sPathElement = $aPathElements[$nPathElementIndex];

            if (empty($sPathElement)) continue;

            // b. create
            $ePathElement = Mimoto::service('data')->create(Coreconfig::MIMOTO_ROUTE_PATH_ELEMENT);

            // c. setup
            $ePathElement->set('type', 'static');
            $ePathElement->set('staticValue', $sPathElement);

            // d. store
            Mimoto::service('data')->store($ePathElement);

            // e. connect
            $eRoute->add('path', $ePathElement);

            // f. verify
            if ($nPathElementIndex < ($nPathElementCount - 1))
            {
                // I. create
                $ePathElement = Mimoto::service('data')->create(Coreconfig::MIMOTO_ROUTE_PATH_ELEMENT);

                // II. setup
                $ePathElement->set('type', 'slash');

                // III. store
                Mimoto::service('data')->store($ePathElement);

                // IV. connect
                $eRoute->add('path', $ePathElement);
            }
        }

        // 8. store
        $eRoute = Mimoto::service('data')->store($eRoute);

        // 9. read
        $nRouteId = $eRoute->getId();


        // ---


        // 10. load
        $eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT);

        // 11. connect
        $eRoot->add('pages', $eRoute);

        // 12. store
        Mimoto::service('data')->store($eRoot);


        // ---


        // 13. redirect
        return $app->redirect('/mimoto.cms/page/'.$nRouteId.'/view');
    }

}

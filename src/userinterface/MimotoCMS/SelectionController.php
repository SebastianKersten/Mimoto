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
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_selections_Overview', $eRoot));

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

    /**
     * View selection overview
     * @return string The rendered html output
     */
    public function selectionView(Application $app, $nSelectionId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eSelection = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTION, $nSelectionId);

        // 3. validate data
        if (empty($eSelection)) return $app->redirect("/mimoto.cms/selections");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_selections_Detail', $eSelection);

        // 5. connect
        $page->addComponent('content', $component);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Selections',
                    "url" => '/mimoto.cms/selections'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_SELECTION.'.'.$eSelection->getId().'.name">'.$eSelection->getValue('name').'</span>',
                    "url" => '/mimoto.cms/selection/'.$eSelection->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

}

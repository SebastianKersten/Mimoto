<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

// Silex classes
use Silex\Application;


/**
 * ComponentController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ComponentController
{

    /**
     * View component overview
     * @return string The rendered html output
     */
    public function viewComponentOverview()
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_components_ComponentOverview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Components and layouts',
                    "url" => '/mimoto.cms/components'
                )
            )
        );

        // 4. output
        return $page->render();
    }

    public function componentView(Application $app, $nComponentId)
    {
        // 1. init popup
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eComponent = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENT, $nComponentId);

        // 3. validate data
        if (empty($eComponent)) return $app->redirect("/mimoto.cms/entities");

        // 4. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_components_ComponentDetail', $eComponent);

        // 6. connect
        $page->addComponent('content', $component);

        // 7. output
        return $page->render();
    }

}

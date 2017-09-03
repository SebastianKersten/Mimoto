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
 * ConfigurationController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ConfigurationController
{

    /**
     * View formatting option overview
     * @return string The rendered html output
     */
    public function overview()
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_configuration_Overview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Configuration',
                    "url" => '/mimoto.cms/configuration'
                )
            )
        );

        // 4. output
        return $page->render();
    }

}

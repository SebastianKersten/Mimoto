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
 * FormattingOptionController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormattingOptionController
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
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_formattingoptions_Overview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Configuration',
                    "url" => '/mimoto.cms/configuration'
                ),
                (object) array(
                    "label" => 'Formatting',
                    "url" => '/mimoto.cms/configuration/formatting'
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
    public function formattingOptionView(Application $app, $nItemId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eFormattingOption = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORMATTINGOPTION, $nItemId);

        // 3. validate data
        if (empty($eFormattingOption)) return $app->redirect("/mimoto.cms/configuration/formatting");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_configuration_formattingoptions_Detail', $eFormattingOption);

        // 5. connect
        $page->addComponent('content', $component);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Configuration',
                    "url" => '/mimoto.cms/configuration'
                ),
                (object) array(
                    "label" => 'Formatting',
                    "url" => '/mimoto.cms/configuration/formatting'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_FORMATTINGOPTION.'.'.$eFormattingOption->getId().'.name">'.$eFormattingOption->getValue('name').'</span>',
                    "url" => '/mimoto.cms/formattingOption/'.$eFormattingOption->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

}

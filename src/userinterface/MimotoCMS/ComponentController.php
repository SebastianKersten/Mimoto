<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
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

    public function viewComponentOverview(Application $app)
    {
        // load
        $aComponents = $app['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_COMPONENT]);

        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_components_ComponentOverview');

        // setup
        $page->addSelection('components', 'Mimoto.CMS_components_ComponentOverview_ListItem', $aComponents);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Components',
                    "url" => '/mimoto.cms/components'
                )
            )
        );

        // output
        return $page->render();
    }

    public function componentNew(Application $app)
    {
        // create dummy
        $entity = $app['Mimoto.Data']->create(CoreConfig::MIMOTO_COMPONENT);

        // 1. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_COMPONENT_NEW, $entity);

        // 3. render and send
        return $component->render();
    }

    public function componentView(Application $app, $nComponentId)
    {
        // 1. load requested entity
        $entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_COMPONENT, $nComponentId);

        // 2. check if entity exists
        if ($entity === false) return $app->redirect("/mimoto.cms/components");

        // 3. create component
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_components_ComponentDetail', $entity);

        // 4. setup component
        //$page->setPropertyComponent('properties', 'Mimoto.CMS_components_ComponentDetail-ComponentConditional');

        // 5. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Components',
                    "url" => '/mimoto.cms/components'
                ),
                (object) array(
                    "label" => '"<span mls_value="'.CoreConfig::MIMOTO_COMPONENT.'.'.$entity->getId().'.name">'.$entity->getValue('name').'</span>"',
                    "url" => '/mimoto.cms/component/'.$entity->getId().'/view'
                )
            )
        );

        // 5. output
        return $page->render();
    }

    public function componentEdit(Application $app, $nComponentId)
    {
        // 1. load
        $entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_COMPONENT, $nComponentId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/components");

        // 3. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_COMPONENT_EDIT, $entity);

        // 5. render and send
        return $component->render();
    }
}

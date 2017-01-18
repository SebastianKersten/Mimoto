<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\UserInterface\MimotoCMS\utils\InterfaceUtils;

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

    public function componentNew(Application $app, $nEntityId)
    {
        // create dummy
        $entity = Mimoto::service('data')->create(CoreConfig::MIMOTO_COMPONENT);

        // 1. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');


        // 2. setup
        $component->addForm(CoreConfig::COREFORM_COMPONENT, $entity,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ENTITY.'.'.$nEntityId.'.components',
                'response' => [
                    'onSuccess' => [
                        'closePopup' => true
                    ]
                ]
            ]
        );

        // 3. render and send
        return $component->render();
    }

    public function componentView(Application $app, $nComponentId)
    {
        // 1. load requested entity
        $entity = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENT, $nComponentId);

        // 2. check if entity exists
        if ($entity === false) return $app->redirect("/mimoto.cms/components");

        // 3. create component
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_components_ComponentDetail', $entity);

        // 4. setup component
        //$page->setPropertyComponent('properties', 'Mimoto.CMS_components_ComponentDetail-ComponentConditional');

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // 5. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Components',
                    "url" => '/mimoto.cms/components'
                ),
                (object) array(
                    "label" => '"<span data-aimless-value="'.CoreConfig::MIMOTO_COMPONENT.'.'.$entity->getId().'.name">'.$entity->getValue('name').'</span>"',
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
        $entity = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENT, $nComponentId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/components");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_COMPONENT, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 5. render and send
        return $component->render();
    }

    public function componentDelete(Application $app, $nComponentId)
    {
        // 1. load
        $component = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENT, $nComponentId);

        // 2. load
        $parentEntity = $app['Mimoto.Config']->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--components', $component);

        // 3. remove connection
        $parentEntity->removeValue('components', $component);

        // 4. persist removed
        Mimoto::service('data')->store($parentEntity);

        // 5. delete property
        Mimoto::service('data')->delete($component);

        // 6. send
        return new JsonResponse((object) array('result' => 'Component deleted! '.date("Y.m.d H:i:s")), 200);

    }

}

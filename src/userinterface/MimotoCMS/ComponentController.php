<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
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

    public function componentNew(Application $app, $nEntityId)
    {
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 3. setup content
        $component->addForm(
            CoreConfig::COREFORM_COMPONENT,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ENTITY.'.'.$nEntityId.'.components',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
    }

    public function componentEdit(Application $app, $nComponentId)
    {
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. load data
        $eComponent = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENT, $nComponentId);

        // 3. validate data
        if (empty($eComponent)) return $app->redirect("/mimoto.cms/components");

        // 4. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 5. setup content
        $component->addForm(
            CoreConfig::COREFORM_COMPONENT,
            $eComponent,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $component->render();
    }

    public function componentDelete(Application $app, $nComponentId)
    {
        // 1. load
        $eComponent = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENT, $nComponentId);

        // 5. cleanup
        Mimoto::service('data')->delete($eComponent);

        // 6. send
        return Mimoto::service('messages')->response((object) array('result' => 'Component deleted! '.date("Y.m.d H:i:s")), 200);
    }

}

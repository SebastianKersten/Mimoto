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
 * DataController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DataController
{

    /**
     * View component overview
     * @return string The rendered html output
     */
    public function createAndConnect(Application $app, Request $request)
    {


        // 1. wat openen? page or popup? create = page
        // 2. select = popup



        // 1. validate
        if (!MimotoDataUtils::isValidId($nEntityId)) $app->redirect('/mimoto.cms');


        // ---


        // 2. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 3. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');


        // ---


        // 4. setup
        $aParentEntities = [(object) array('type' => CoreConfig::MIMOTO_ROOT, 'id' => CoreConfig::MIMOTO_ROOT, 'property' => 'components')];

        // 5. verify and add
        if (MimotoDataUtils::isValidId($nEntityId))
        {
            $aParentEntities[] = (object) array('type' => CoreConfig::MIMOTO_ENTITY, 'id' => $nEntityId, 'property' => 'components');
        }

        // 6. create and connect
        $eComponent = Mimoto::service('data')->createAndConnect(CoreConfig::MIMOTO_COMPONENT, $aParentEntities);


        // ---


        // 7. setup content
        $component->addForm(
            CoreConfig::COREFORM_COMPONENT,
            $eComponent,
            [
                //'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $page->addComponent('content', $component);

        // 5. output
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
        $component = Mimoto::service('output')->createComponent('Mimoto.CMS_entities_EntityDetail-ComponentDetail', $eComponent);

        // 6. connect
        $page->addComponent('content', $component);

        // 7. output
        return $page->render();
    }

    public function componentEdit(Application $app, $nComponentId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load data
        $eComponent = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENT, $nComponentId);

        // 3. validate data
        if (empty($eComponent)) return $app->redirect("/mimoto.cms/entities");

        // 4. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

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
        return $popup->render();
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

    public function componentConditionalNew(Application $app, $nComponentId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup
        $component->addForm(CoreConfig::COREFORM_COMPONENTCONDITIONAL, null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_COMPONENT.'.'.$nComponentId.'.conditionals',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
    }

    public function componentConditionalEdit(Application $app, $nComponentConditionalId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load data
        $eComponentConditional = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENTCONDITIONAL, $nComponentConditionalId);

        // 3. validate data
        if (empty($eComponentConditional)) return $app->redirect("/mimoto.cms/components");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 5. setup
        $component->addForm(CoreConfig::COREFORM_COMPONENTCONDITIONAL, $eComponentConditional, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $component->render();
    }

    public function componentConditionalDelete(Application $app, $nComponentConditionalId)
    {
        // 1. load
        $eComponentConditional = Mimoto::service('data')->get(CoreConfig::MIMOTO_COMPONENTCONDITIONAL, $nComponentConditionalId);

        // 2. delete
        Mimoto::service('data')->delete($eComponentConditional);

        // 3. output
        return Mimoto::service('messages')->response((object) array('result' => 'ComponentConditional deleted! '.date("Y.m.d H:i:s")), 200);
    }


    /**
     * View layout overview
     * @return string The rendered html output
     */
    public function viewLayoutOverview()
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('Mimoto.CMS_layouts_LayoutOverview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Layouts',
                    "url" => '/mimoto.cms/layouts'
                )
            )
        );

        // 4. output
        return $page->render();
    }

    /**
     * View new layout form
     * @return string The rendered html output
     */
    public function layoutNew()
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create form layout
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup form
        $component->addForm(
            CoreConfig::COREFORM_LAYOUT,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ROOT.'.'.CoreConfig::MIMOTO_ROOT.'.layouts',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect content
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
    }

    /**
     * View layout
     * @return string The rendered html output
     */
    public function layoutView(Application $app, $nLayoutId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eLayout = Mimoto::service('data')->get(CoreConfig::MIMOTO_LAYOUT, $nLayoutId);

        // 3. validate data
        if (empty($eLayout)) return $app->redirect("/mimoto.cms/layouts");

        // 4. create
        $component = Mimoto::service('output')->createComponent('Mimoto.CMS_layouts_LayoutDetail', $eLayout);

        // 5. connect
        $page->addComponent('content', $component);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Layouts',
                    "url" => '/mimoto.cms/layouts'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_LAYOUT.'.'.$eLayout->getId().'.name">'.$eLayout->getValue('name').'</span>',
                    "url" => '/mimoto.cms/layout/'.$eLayout->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

    public function layoutEdit(Application $app, $nLayoutId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load
        $eLayout = Mimoto::service('data')->get(CoreConfig::MIMOTO_LAYOUT, $nLayoutId);

        // 3. validate
        if (empty($eLayout)) return $app->redirect("/mimoto.cms/layouts");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 5. setup
        $component->addForm(
            CoreConfig::COREFORM_LAYOUT,
            $eLayout,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $popup->render();
    }

    public function layoutDelete(Application $app, $nLayoutId)
    {
        // 1. load
        $eLayout = Mimoto::service('data')->get(CoreConfig::MIMOTO_LAYOUT, $nLayoutId);

        // 2. delete
        Mimoto::service('data')->delete($eLayout);

        // 3. output
        return Mimoto::service('messages')->response((object) array('result' => 'Layout deleted! '.date("Y.m.d H:i:s")), 200);
    }

    public function layoutContainerNew(Application $app, $nLayoutId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup
        $component->addForm(CoreConfig::COREFORM_LAYOUTCONTAINER, null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_LAYOUT.'.'.$nLayoutId.'.containers',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
    }

    public function layoutContainerEdit(Application $app, $nLayoutContainerId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load data
        $eLayoutContainer = Mimoto::service('data')->get(CoreConfig::MIMOTO_LAYOUTCONTAINER, $nLayoutContainerId);

        // 3. validate data
        if (empty($eLayoutContainer)) return $app->redirect("/mimoto.cms/layouts");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 5. setup
        $component->addForm(CoreConfig::COREFORM_LAYOUTCONTAINER, $eLayoutContainer, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $component->render();
    }

    public function layoutContainerDelete(Application $app, $nLayoutContainerId)
    {
        // 1. load
        $eLayoutContainer = Mimoto::service('data')->get(CoreConfig::MIMOTO_LAYOUTCONTAINER, $nLayoutContainerId);

        // 2. delete
        Mimoto::service('data')->delete($eLayoutContainer);

        // 3. output
        return Mimoto::service('messages')->response((object) array('result' => 'LayoutContainer deleted! '.date("Y.m.d H:i:s")), 200);
    }


}

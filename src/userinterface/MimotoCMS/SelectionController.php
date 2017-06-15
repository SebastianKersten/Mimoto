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
        $page->addComponent('content', Mimoto::service('output')->createComponent('Mimoto.CMS_selections_Overview', $eRoot));

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
     * View new selection form
     * @return string The rendered html output
     */
    public function selectionNew()
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create form layout
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup form
        $component->addForm(
            CoreConfig::COREFORM_SELECTION,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ROOT.'.'.CoreConfig::MIMOTO_ROOT.'.selections',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect content
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
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
        $component = Mimoto::service('output')->createComponent('Mimoto.CMS_selections_Detail', $eSelection);

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

    public function selectionEdit(Application $app, $nSelectionId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load
        $eContentSection = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTION, $nSelectionId);

        // 3. validate
        if (empty($eContentSection)) return $app->redirect("/mimoto.cms/selections");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 5. setup
        $component->addForm(
            CoreConfig::COREFORM_SELECTION,
            $eContentSection,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $popup->render();
    }

    public function selectionDelete(Application $app, $nSelectionId)
    {
        // 1. load
        $eSelection = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTION, $nSelectionId);

        // 2. delete
        Mimoto::service('data')->delete($eSelection);

        // 3. output
        return Mimoto::service('messages')->response((object) array('result' => 'Selection deleted! '.date("Y.m.d H:i:s")), 200);
    }

    public function selectionRuleNew(Application $app, $nSelectionId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup
        $component->addForm(CoreConfig::COREFORM_SELECTIONRULE, null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_SELECTION.'.'.$nSelectionId.'.rules',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
    }

    public function selectionRuleEdit(Application $app, $nSelectionRuleId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load data
        $eSelectionRule = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTIONRULE, $nSelectionRuleId);

        // 3. validate data
        if (empty($eSelectionRule)) return $app->redirect("/mimoto.cms/selections");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 5. setup
        $component->addForm(CoreConfig::COREFORM_SELECTIONRULE, $eSelectionRule, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $component->render();
    }

    public function selectionRuleDelete(Application $app, $nSelectionRuleId)
    {
        // 1. load
        $eSelectionRule = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTIONRULE, $nSelectionRuleId);

        // 2. delete
        Mimoto::service('data')->delete($eSelectionRule);

        // 3. output
        return Mimoto::service('messages')->response((object) array('result' => 'SelectionRule deleted! '.date("Y.m.d H:i:s")), 200);
    }


    public function selectionRuleEditEntityType(Application $app, $nSelectionRuleId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load data
        $eSelectionRule = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTIONRULE, $nSelectionRuleId);

        // 3. validate data
        if (empty($eSelectionRule)) return $app->redirect("/mimoto.cms/selections");

        // 4. create
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_List');
    }

}

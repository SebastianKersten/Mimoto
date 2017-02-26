<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\UserInterface\MimotoCMS\utils\InterfaceUtils;
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

    public function viewSelectionOverview(Application $app)
    {
        // load
        $eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT);

        // create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_selections_SelectionOverview', $eRoot);

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Selections',
                    "url" => '/mimoto.cms/selections'
                )
            )
        );

        // output
        return $page->render();
    }

    public function selectionNew(Application $app)
    {
        // 1. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_SELECTION, null, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 3. render and send
        return $component->render();
    }

    public function selectionView(Application $app, $nSelectionId)
    {
        // 1. load
        $eSelection = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTION, $nSelectionId);

        // 2. validate
        if ($eSelection === false) return $app->redirect("/mimoto.cms/selections");

        // 3. create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_selections_SelectionDetail', $eSelection);

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Selections',
                    "url" => '/mimoto.cms/selections'
                ),
                (object) array(
                    "label" => '"<span data-aimless-value="'.CoreConfig::MIMOTO_SELECTION.'.'.$eSelection->getId().'.name">'.$eSelection->getValue('name').'</span>"',
                    "url" => '/mimoto.cms/selection/'.$eSelection->getId().'/view'
                )
            )
        );

        // 5. output
        return $page->render();
    }

    public function selectionEdit(Application $app, $nSelectionId)
    {
        // 1. load
        $contentSection = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTION, $nSelectionId);

        // 2. validate
        if ($contentSection === false) return $app->redirect("/mimoto.cms/selections");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_SELECTION, $contentSection, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 5. render and send
        return $component->render();
    }

    public function selectionDelete(Application $app, $nSelectionId)
    {
        // 1. load
        $eSelection = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTION, $nSelectionId);

        // 2. delete
        Mimoto::service('data')->delete($eSelection);

        // 3. send
        return Mimoto::service('messages')->response((object) array('result' => 'Selection deleted! '.date("Y.m.d H:i:s")), 200);
    }

    public function selectionRuleNew(Application $app, $nSelectionId)
    {
        // 1. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_SELECTIONRULE, null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_SELECTION.'.'.$nSelectionId.'.rules',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 3. render and send
        return $component->render();
    }

    public function selectionRuleEdit(Application $app, $nSelectionRuleId)
    {
        // 1. load
        $eSelectionRule = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTIONRULE, $nSelectionRuleId);

        // 2. validate
        if ($eSelectionRule === false) return $app->redirect("/mimoto.cms/selections");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_SELECTIONRULE, $eSelectionRule, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 5. render and send
        return $component->render();
    }

    public function selectionRuleDelete(Application $app, $nSelectionRuleId)
    {
        // 1. load
        $eSelectionRule = Mimoto::service('data')->get(CoreConfig::MIMOTO_SELECTIONRULE, $nSelectionRuleId);

//        // 2. find
//        $parentEntity = $app['Mimoto.Config']->getParentEntity($eSelectionRule);
//
//        // 3. remove connection
//        $parentEntity->removeValue('properties', $eSelectionRule);
//
//        // 4. persist removed
//        Mimoto::service('data')->store($parentEntity);

        // 5. delete property
        Mimoto::service('data')->delete($eSelectionRule);

        // 6. send
        return Mimoto::service('messages')->response((object) array('result' => 'SelectionRule deleted! '.date("Y.m.d H:i:s")), 200);
    }
}

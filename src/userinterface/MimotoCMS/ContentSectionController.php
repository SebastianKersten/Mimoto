<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\UserInterface\MimotoCMS\utils\InterfaceUtils;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;


/**
 * ContentSectionController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ContentSectionController
{

    public function viewContentSectionOverview(Application $app)
    {
        // load
        $eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT);

        // create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_contentsections_ContentSectionOverview', $eRoot);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Data',
                    "url" => '/mimoto.cms/contentsections'
                )
            )
        );

        // output
        return $page->render();
    }

    public function contentSectionNew(Application $app)
    {
        // create dummy
        $entity = Mimoto::service('data')->create(CoreConfig::MIMOTO_CONTENTSECTION);

        // 1. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(
            CoreConfig::COREFORM_CONTENTSECTION,
            $entity,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ROOT.'.'.CoreConfig::MIMOTO_ROOT.'.contentSections',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 3. render and send
        return $component->render();
    }

    public function contentSectionView(Application $app, $nContentSectionId)
    {
        // 1. load
        $eContentSection = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentSectionId);

        // 2. validate
        if ($eContentSection === false) return $app->redirect("/mimoto.cms/contentsections");

        // 3. load
        $eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT);

        // 4. create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Page', $eRoot);

        // 5. setup
        $page->addForm(CoreConfig::COREFORM_CONTENTSECTION, $eContentSection, ['response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/contentsections']]]);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Data',
                    "url" => '/mimoto.cms/contentsections'
                ),
                (object) array(
                    "label" => '"<span data-aimless-value="'.CoreConfig::MIMOTO_CONTENTSECTION.'.'.$eContentSection->getId().'.name">'.$eContentSection->getValue('name').'</span>"',
                    "url" => '/mimoto.cms/contentsection/'.$eContentSection->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

    public function contentSectionEdit(Application $app, $nContentSectionId)
    {
        // 1. load
        $eContentSection = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentSectionId);

        // 2. validate
        if ($eContentSection === false) return $app->redirect("/mimoto.cms/contentsections");

        // 3. load
        $eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT);

        // 4. create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Page', $eRoot);

        // 4. setup
        $page->addForm(CoreConfig::COREFORM_CONTENTSECTION, $eContentSection, ['response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/contentsections']]]);

        // 5. render and send
        return $page->render();
    }

    public function contentSectionDelete(Application $app, $nContentSectionId)
    {
        // 1. load
        $eContentSection = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentSectionId);

        // 2. selete
        Mimoto::service('data')->delete($eContentSection);

        // 3. send
        return Mimoto::service('messages')->response((object) array('result' => 'Content section deleted! '.date("Y.m.d H:i:s")), 200);
    }
}

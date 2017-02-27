<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
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
        // 1. init page
        $page = Mimoto::service('aimless')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('aimless')->createComponent('Mimoto.CMS_contentsections_ContentSectionOverview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Data',
                    "url" => '/mimoto.cms/contentsections'
                )
            )
        );

        // 4. output
        return $page->render();
    }

    public function contentSectionNew(Application $app)
    {
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 3. setup content
        $component->addForm(
            CoreConfig::COREFORM_CONTENTSECTION,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ROOT.'.'.CoreConfig::MIMOTO_ROOT.'.contentSections',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
    }

    public function contentSectionView(Application $app, $nContentSectionId)
    {
        // 1. init page
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eContentSection = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentSectionId);

        // 3. validate data
        if ($eContentSection === false) return $app->redirect("/mimoto.cms/contentsections");

        // 4. create content
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_contentsections_ContentSectionDetail', $eContentSection);

        // 5. connect
        $page->addComponent('content', $component);

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
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. load data
        $eContentSection = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentSectionId);

        // 3. validate data
        if ($eContentSection === false) return $app->redirect("/mimoto.cms/contentsections");

        // 4. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 5. setup contennt
        $component->addForm(
            CoreConfig::COREFORM_CONTENTSECTION,
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

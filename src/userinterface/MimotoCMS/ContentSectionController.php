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
        $aContentSections = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_CONTENTSECTION]);

        // create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_contentsections_ContentSectionOverview');

        // setup
        $page->addSelection('contentSections', $aContentSections, 'Mimoto.CMS_contentsections_ContentSectionOverview_ListItem');

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

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
        $component->addForm(CoreConfig::COREFORM_CONTENTSECTION, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 3. render and send
        return $component->render();
    }

    public function contentSectionView(Application $app, $nContentSectionId)
    {
        // 1. load requested entity
        $contentSection = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentSectionId);

        // 2. check if contentSection exists
        if ($contentSection === false) return $app->redirect("/mimoto.cms/contentsections");

        // 3. create component
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_contentsections_ContentSectionDetail', $contentSection);

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Data',
                    "url" => '/mimoto.cms/contentsections'
                ),
                (object) array(
                    "label" => '"<span data-aimless-value="'.CoreConfig::MIMOTO_CONTENTSECTION.'.'.$contentSection->getId().'.name">'.$contentSection->getValue('name').'</span>"',
                    "url" => '/mimoto.cms/contentsection/'.$contentSection->getId().'/view'
                )
            )
        );

        // 5. output
        return $page->render();
    }

    public function contentSectionEdit(Application $app, $nContentSectionId)
    {
        // 1. load
        $contentSection = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentSectionId);

        // 2. validate
        if ($contentSection === false) return $app->redirect("/mimoto.cms/contentsections");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_CONTENTSECTION, $contentSection, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 5. render and send
        return $component->render();
    }

    public function contentSectionDelete(Application $app, $nContentSectionId)
    {
        // delete
        //Mimoto::service('config')->entityDelete($nContentSectionId);

        // send
        //return new JsonResponse((object) array('result' => 'Content deleted! '.date("Y.m.d H:i:s")), 200);
    }
}

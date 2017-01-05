<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
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
        $aContentSections = $app['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_CONTENTSECTION]);

        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_contentsections_ContentSectionOverview');

        // setup
        $page->addSelection('contentSections', 'Mimoto.CMS_contentsections_ContentSectionOverview_ListItem', $aContentSections);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Content sections',
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
        $entity = $app['Mimoto.Data']->create(CoreConfig::MIMOTO_CONTENTSECTION);

        // 1. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_CONTENTSECTION_NEW, $entity);

        // 3. render and send
        return $component->render();
    }

    public function contentSectionView(Application $app, $nEntityId)
    {
        // 1. load requested entity
        $entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_CONTENTSECTION, $nEntityId);

        // 2. check if entity exists
        if ($entity === false) return $app->redirect("/mimoto.cms/contentsections");

        // 3. create component
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_contentsections_ContentSectionDetail', $entity);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Content',
                    "url" => '/mimoto.cms/contentsections'
                ),
                (object) array(
                    "label" => '"<span data-aimless-value="'.CoreConfig::MIMOTO_CONTENTSECTION.'.'.$entity->getId().'.name">'.$entity->getValue('name').'</span>"',
                    "url" => '/mimoto.cms/contentsection/'.$entity->getId().'/view'
                )
            )
        );

        // 5. output
        return $page->render();
    }

    public function contentSectionEdit(Application $app, $nEntityId)
    {
        // 1. load
        $entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_CONTENTSECTION, $nEntityId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/contentsections");

        // 3. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_CONTENTSECTION_EDIT, $entity);

        // 5. render and send
        return $component->render();
    }

    public function contentSectionDelete(Application $app, Request $request, $nEntityId)
    {
        // delete
        $app['Mimoto.Config']->entityDelete($nEntityId);

        // send
        return new JsonResponse((object) array('result' => 'Content deleted! '.date("Y.m.d H:i:s")), 200);
    }
}

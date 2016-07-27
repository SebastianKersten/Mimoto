<?php

// classpath
namespace Mimoto\UserInterface;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;



/**
 * EntityController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityController
{

    public function viewEntityOverview(Application $app)
    {
        // load
        $aEntities = $app['Mimoto.Data']->find(['type' => '_mimoto_entity']);

        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_entities_Overview');

        // setup
        $page->addSelection('entities', 'Mimoto.CMS_entities_EntityListItem', $aEntities);

        // output
        return $page->render();
    }

    public function entityNew(Application $app)
    {
        // create
        $form = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_entities_FormEntityNew');

        // output
        return $form->render();
    }

    public function entityCreate(Application $app, Request $request)
    {
        // register
        $sEntityName = $request->get('name');

        // create entity
        $app['Mimoto.Config']->entityCreate($sEntityName);

        // send
        return new JsonResponse((object) array('result' => 'Entity created! '.date("Y.m.d H:i:s")), 200);
    }

    public function entityView(Application $app, $nEntityId)
    {
        // load
        $entity = $app['Mimoto.Data']->get('_mimoto_entity', $nEntityId);

        // validate
        if ($entity === false) return $app->redirect("/mimoto.cms/entities");

        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_entities_Detail', $entity);

        // setup
        $page->setPropertyTemplate('properties', 'Mimoto.CMS_entities_PropertyListItem');

        // output
        return $page->render();
    }

    public function entityEdit(Application $app, $nEntityId)
    {
        // load
        $entity = $app['Mimoto.Data']->get('_mimoto_entity', $nEntityId);

        // validate
        if ($entity === false) return $app->redirect("/mimoto.cms/entities");

        // create
        $form = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_entities_FormEntityEdit', $entity);

        // output
        return $form->render();
    }

    public function entityUpdate(Application $app, Request $request, $nEntityId)
    {
        // register
        $sNewEntityName = $request->get('name');

        // change
        $app['Mimoto.Config']->entityUpdate($nEntityId, $sNewEntityName);

        // send
        return new JsonResponse((object) array('result' => 'Entity updated! '.date("Y.m.d H:i:s")), 200);
    }

    public function entityDelete(Application $app, Request $request, $nEntityId)
    {
        // delete
        $app['Mimoto.Config']->entityDelete($nEntityId);

        // send
        return new JsonResponse((object) array('result' => 'Entity deleted! '.date("Y.m.d H:i:s")), 200);
    }



    // --- EntityProperty ---


    public function entityPropertyNew(Application $app, $nEntityId)
    {
        // create
        $form = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_entities_FormEntityProperty');

        // setup
        $form->setVar('nEntityId', $nEntityId);

        // output
        return $form->render();
    }

    public function entityPropertyCreate(Application $app, Request $request, $nEntityId)
    {
        // register
        $sEntityPropertyName = $request->get('name');
        $sEntityPropertyType = 'value'; //$request->get('type');

        // create entity
        $app['Mimoto.Config']->entityPropertyCreate($nEntityId, $sEntityPropertyName, $sEntityPropertyType);

        // send
        return new JsonResponse((object) array('result' => 'EntityProperty created! '.date("Y.m.d H:i:s")), 200);
    }


    public function entityPropertyChange(Application $app)
    {

    }
}

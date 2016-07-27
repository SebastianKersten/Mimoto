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

    public function viewEntity(Application $app, $nId)
    {
        // load
        $entity = $app['Mimoto.Data']->get('_mimoto_entity', $nId);

        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_entities_Detail', $entity);

        // setup
        $page->setPropertyTemplate('properties', 'Mimoto.CMS_entities_PropertyListItem');

        // output
        return $page->render();
    }


    // entityNew -> form
    // entityEdit -> form


    public function entityNew(Application $app)
    {
        // create
        $form = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_entities_FormEntity');

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

    public function entityChange(Application $app, Request $request, $nEntityId)
    {
        // register
        $sNewEntityName = 'test2'; //$request->get('name'); // INSTALL mysql

        // change
        $app['Mimoto.Config']->entityChange($nEntityId, $sNewEntityName);

        // send
        return new JsonResponse((object) array('result' => 'Entity changed! '.date("Y.m.d H:i:s")), 200);
    }

    public function entityDelete(Application $app, Request $request, $nEntityId)
    {
        // delete
        $app['Mimoto.Config']->entityDelete($nEntityId);

        // send
        return new JsonResponse((object) array('result' => 'Entity deleted! '.date("Y.m.d H:i:s")), 200);
    }



    // --- EntityProperty ---


    public function entityPropertyCreate(Application $app, Request $request, $nEntityId)
    {
        // register
        $sEntityPropertyName = 'type'; //$request->get('name');
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

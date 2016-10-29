<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Mimoto\Core\CoreConfig;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

// Silex classes
use Silex\Application;



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
        $aEntities = $app['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_ENTITY]);

        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_entities_EntityOverview');

        // setup
        $page->addSelection('entities', 'Mimoto.CMS_entities_EntityListItem', $aEntities);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Entities',
                    "url" => '/mimoto.cms/entities'
                )
            )
        );

        // output
        return $page->render();
    }


    public function entityNew(Application $app)
    {
        // create dummy
        $entity = $app['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITY);

        // 1. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Page');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_ENTITY_NEW, $entity);

        // 3. render and send
        return $component->render();
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
        // 1. load requested entity
        $entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // 2. check if entity exists
        if ($entity === false) return $app->redirect("/mimoto.cms/entities");

        // 3. create component
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_entities_EntityDetail', $entity);

        // 4. setup component
        $page->setPropertyComponent('properties', 'Mimoto.CMS_entities_PropertyListItem');

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Entities',
                    "url" => '/mimoto.cms/entities'
                ),
                (object) array(
                    "label" => '<span mls_value="'.CoreConfig::MIMOTO_ENTITY.'.'.$entity->getId().'.name">'.$entity->getValue('name').'</span>',
                    "url" => '/mimoto.cms/entity/'.$entity->getId().'/view'
                )
            )
        );

        // 5. output
        return $page->render();
    }

    public function entityEdit(Application $app, $nEntityId)
    {
        // 1. load
        $entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/entities");

        // 3. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_ENTITY_NEW, $entity);

        // 5. render and send
        return $component->render();
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


    public function entityPropertyEdit(Application $app, $nEntityPropertyId)
    {
        // 1. load
        $entity = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $nEntityPropertyId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/entities");

        // 3. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_ENTITYPROPERTY_NEW, $entity);

        // 5. render and send
        return $component->render();
    }
}

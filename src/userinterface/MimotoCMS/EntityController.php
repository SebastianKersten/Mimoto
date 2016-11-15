<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\EntityConfig\MimotoEntityConfig;

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
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

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
        $page->setPropertyComponent('properties', 'Mimoto.CMS_entities_EntityPropertyListItem');

        // setup page
        $page->setVar('entityStructure', $this->getEntityStructure($entity));
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Entities',
                    "url" => '/mimoto.cms/entities'
                ),
                (object) array(
                    "label" => '"<span mls_value="'.CoreConfig::MIMOTO_ENTITY.'.'.$entity->getId().'.name">'.$entity->getValue('name').'</span>"',
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
        $component->addForm(CoreConfig::COREFORM_ENTITY_EDIT, $entity);

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
        // 1. auto-create entity if new (in plaats van create ooraf)
        // 2. hidden vars


        // create dummy
        $entityProperty = $app['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);

        // 1. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_ENTITYPROPERTY_NEW, $entityProperty);

        // 3. render and send
        return $component->render();

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
        //$component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Page');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_ENTITYPROPERTY_EDIT, $entity);

        // 5. render and send
        return $component->render();
    }




    private function getEntityStructure(MimotoEntity $entity)
    {
        // init
        $entityStructure = (object) array();
        $entityStructure->name = $entity->getValue('name');
        $entityStructure->hasTable = (intval($entity->getValue('noTable')) === 1) ? false : true;
        $entityStructure->instanceCount = 0;
        $entityStructure->extends = [];
        $entityStructure->extendedBy = [];
        $entityStructure->properties = [];



        // --- instanceCount ---


        if ($entityStructure->hasTable)
        {
            // load
            $stmt = $GLOBALS['database']->prepare('SELECT count(id) FROM ' . $entity->getValue('name'));
            $params = array();
            $stmt->execute($params);

            // load
            $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($aResults) == 0)
            {
                $GLOBALS['Mimoto.Log']->error('Entity table issue', "The entity '".$entityStructure->name."' is missing its mysql table");
            }
            else
            {
                // store
                $entityStructure->instanceCount = $aResults[0]['count(id)'];
            }
        }


        // --- extends ---


        // load
        $entityExtends = $entity->getValue('extends');

        if (!empty($entityExtends))
        {
            // compose and store
            $entityStructure->extends[] = (object) array(
                'id' => $entityExtends->getId(),
                'name' => $entityExtends->getValue('name')
            );

            $bHasParent = true;
            $nParentId = $entityExtends->getId();
            while($bHasParent)
            {
                // load
                $parent = $GLOBALS['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, $nParentId);

                // load
                $entityExtends = $parent->getValue('extends');

                if (!empty($entityExtends))
                {
                    // compose and store
                    $entityStructure->extends[] = (object) array(
                        'id' => $entityExtends->getId(),
                        'name' => $entityExtends->getValue('name')
                    );
                    $nParentId = $entityExtends->getId();
                }
                else
                {
                    $bHasParent = false;
                }
            }
        }


        // --- extendedBy ---


        $entityStructure->extendedBy =$this->getChildExtension($entity->getId());



        // --- properties ---


        // load
        $aEntityProperties = $entity->getValue('properties', true);

        $nPropertyCount = count($aEntityProperties);
        for ($i = 0; $i < $nPropertyCount; $i++)
        {
            // register
            $entityProperty = $aEntityProperties[$i];

            // init
            $aSettings = [];

            // load
            $aPropertySettings = $entityProperty->getValue('settings', true);

            $nSettingCount = count($aPropertySettings);
            for ($j = 0; $j < $nSettingCount; $j++)
            {
                // register
                $propertySetting = $aPropertySettings[$j];

                $sKey = $propertySetting->getValue('key');
                $sType = $propertySetting->getValue('type');
                $value = $propertySetting->getValue('value');

                switch($sKey)
                {
                    case MimotoEntityConfig::OPTION_ENTITY_ALLOWEDENTITYTYPE:

                        $value = '<a href="/mimoto.cms/entity/'.$value.'/view">'.$GLOBALS['Mimoto.Config']->getEntityNameById($value).'</a>';
                        break;

                    case MimotoEntityConfig::OPTION_COLLECTION_ALLOWEDENTITYTYPES:

                        // convert
                        $aAllowedEntityTypes = json_decode($value);

                        $value = '[<br>';

                        $nAllowedEntityTypeCount = count($aAllowedEntityTypes);
                        for ($k = 0; $k < $nAllowedEntityTypeCount; $k++)
                        {
                            // register
                            $nAllowedEntityType = $aAllowedEntityTypes[$k];

                            $value .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="/mimoto.cms/entity/'.$nAllowedEntityType.'/view">'.$GLOBALS['Mimoto.Config']->getEntityNameById($nAllowedEntityType).'</a>';
                            if ($k < $nAllowedEntityTypeCount - 1) $value .= ',<br>'; else $value .= '<br>';
                        }

                        $value .= ' ]';

                        break;
                }


                $setting = (object) array(
                    'key' => $sKey,
                    'type' => $sType,
                    'value' => $value,
                );

                // store
                $aSettings[] = $setting;
            }

            // store
            $entityStructure->properties[] = (object) array(
                'id' => $entityProperty->getId(),
                'name' => $entityProperty->getValue('name'),
                'type' => $entityProperty->getValue('type'),
                'settings' => $aSettings
            );
        }

        // send
        return $entityStructure;
    }


    private function getChildExtension($nEntityId)
    {
        // init
        $aChildExtensions = [];

        // load
        $stmt = $GLOBALS['database']->prepare(
            "SELECT * FROM ".CoreConfig::MIMOTO_CONNECTIONS_CORE." WHERE ".
            "parent_entity_type_id = :parent_entity_type_id && ".
            "parent_property_id = :parent_property_id && ".
            "child_entity_type_id = :child_entity_type_id &&".
            "child_id = :child_id"
        );
        $params = array(
            ':parent_entity_type_id' => CoreConfig::MIMOTO_ENTITY,
            ':parent_property_id' => CoreConfig::MIMOTO_ENTITY.'--extends',
            ':child_entity_type_id' => CoreConfig::MIMOTO_ENTITY,
            ':child_id' => $nEntityId
        );

        $stmt->execute($params);

        // load
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($aResults as $row)
        {
            // load
            $offspring = $GLOBALS['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, $row['parent_id']);

            // compose and store
            $aChildExtensions[] = (object) array(
                'id' => $row['parent_id'],
                'name' => $offspring->getValue('name')
            );

            // check
            if (!empty($aSubchildExtensions = $this->getChildExtension($row['parent_id'])))
            {
                $aChildExtensions = array_merge($aChildExtensions, $aSubchildExtensions);
            }
        }

        // send
        return $aChildExtensions;
    }

    private function getChildConnections($nEntityId)
    {
        // init
        $aChildConnection = [];

        // load
        $stmt = $GLOBALS['database']->prepare(
            "SELECT * FROM ".CoreConfig::MIMOTO_CONNECTIONS_PROJECT." WHERE ".
            "parent_entity_type_id = :parent_entity_type_id && ".
            "parent_property_id = :parent_property_id && ".
            "child_entity_type_id = :child_entity_type_id &&".
            "child_id = :child_id"
        );
        $params = array(
            ':parent_entity_type_id' => CoreConfig::MIMOTO_ENTITY,
            ':parent_property_id' => CoreConfig::MIMOTO_ENTITY.'--extends',
            ':child_entity_type_id' => CoreConfig::MIMOTO_ENTITY,
            ':child_id' => $nEntityId
        );

        $stmt->execute($params);

        // load
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($aResults as $row)
        {
            // load
            $offspring = $GLOBALS['Mimoto.Data']->get(CoreConfig::MIMOTO_ENTITY, $row['parent_id']);

            // compose and store
            $aChildConnection[] = (object) array(
                'id' => $row['parent_id'],
                'name' => $offspring->getValue('name')
            );

            // check
            if (!empty($aSubchildExtensions = $this->getChildExtension($row['parent_id'])))
            {
                $aChildExtensions = array_merge($aChildConnection, $aSubchildExtensions);
            }
        }

        // send
        return $aChildConnection;
    }
}

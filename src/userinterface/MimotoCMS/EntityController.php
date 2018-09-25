<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\EntityConfig\EntityConfig;

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
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_entities_EntityOverview', $eRoot));


        //$page->addComponent('userComponent', Mimoto::service('output')->createComponent('MimotoCMS_entities_EntityOverview', $eRoot));


        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Entities',
                    "url" => '/mimoto.cms/entities'
                )
            )
        );

        // 4. output
        return $page->render();
    }

    public function entityView(Application $app, $nEntityId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // 3. validate data
        if (empty($eEntity)) return $app->redirect("/mimoto.cms/entities");

        // 4. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_entities_EntityDetail', $eEntity);

        // 5. load
        //$aInstances = (count($eEntity->getValue('properties'))) ? Mimoto::service('data')->select(['type' => $eEntity->getValue('name')]) : [];

        // 6. add instances
        //$component->addSelection('instances', $aInstances);

        // 7. setup content
        $component->setVar('entityStructure', $this->getEntityStructure($eEntity));

        // 8. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Entities',
                    "url" => '/mimoto.cms/entities'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_ENTITY.'.'.$eEntity->getId().'.name">'.$eEntity->getValue('name').'</span>',
                    "url" => '/mimoto.cms/entity/'.$eEntity->getId().'/view'
                )
            )
        );

        // 9. connect
        $page->addComponent('content', $component);

        // 10. output
        return $page->render();
    }

    public function instanceDeleteAll(Application $app, $sEntityType)
    {
        // 1. init
        $aInstances = Mimoto::service('data')->select(['type' => $sEntityType]);

        // 2. delete
        $nInstanceCount = count($aInstances);
        for ($nInstanceIndex = 0; $nInstanceIndex < $nInstanceCount; $nInstanceIndex++)
        {
            // 2a. load
            $eInstance = $aInstances[$nInstanceIndex];

            // 2b. delete
            Mimoto::service('data')->delete($eInstance);
        }

        // 3. send
        return Mimoto::service('messages')->response((object) array('result' => 'All instances of type '.$sEntityType.' deleted! '.date("Y.m.d H:i:s")), 200);
    }


    public function useAsUserExtension(Application $app, $nEntityId)
    {
        // init
        $sEntityNameAsUserExtension = '';

        // load
        $aEntities = Mimoto::service('data')->select(array('type' => CoreConfig::MIMOTO_ENTITY));

        // toggle
        $nEntityCount = count($aEntities);
        for ($nEntityIndex = 0; $nEntityIndex < $nEntityCount; $nEntityIndex++)
        {
            // register
            $eEntity = $aEntities[$nEntityIndex];

            // read
            $bCurrentlyIsUserExtension = $eEntity->get('isUserExtension');

            //
            if (!empty($nEntityId) && $eEntity->getId() == $nEntityId)
            {
                // toggle
                $eEntity->set('isUserExtension', true);

                // store
                Mimoto::service('data')->store($eEntity);

                // register
                $sEntityNameAsUserExtension = $eEntity->get('name');
            }
            else
            {
                if ($bCurrentlyIsUserExtension)
                {
                    // toggle
                    $eEntity->set('isUserExtension', false);

                    // store
                    Mimoto::service('data')->store($eEntity);
                }
            }
        }

        // report
        return Mimoto::service('messages')->response((object) array('result' => 'Entity `'.$sEntityNameAsUserExtension.'` is now being used as Mimoto`s user object extension! '.date("Y.m.d H:i:s")), 200);
    }

    public function stopUsingAsUserExtension(Application $app, $nEntityId)
    {
        // load
        $eEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // verify
        if (empty($eEntity)) return Mimoto::service('messages')->response((object) array('result' => 'No entity with id = `'.$nEntityId.'` to stop using as user extension'.date("Y.m.d H:i:s")), 400);

        // register
        $sEntityNameAsUserExtension = $eEntity->get('name');

        // toggle
        $eEntity->set('isUserExtension', false);

        // store
        Mimoto::service('data')->store($eEntity);

        // report
        return Mimoto::service('messages')->response((object) array('result' => 'Entity `'.$sEntityNameAsUserExtension.'` has now stopped from being used as Mimoto`s user object extension! '.date("Y.m.d H:i:s")), 200);
    }


    // --- other ---


    private function getEntityStructure(MimotoEntity $entity)
    {
        // init
        $entityStructure = (object) array();
        $entityStructure->name = $entity->getValue('name');
        $entityStructure->hasTable = true; //(intval($entity->getValue('isAbstract')) === 1) ? false : true;
        $entityStructure->instanceCount = 0;
        $entityStructure->extends = [];
        $entityStructure->extendedBy = [];
        $entityStructure->entityNames = [];



        // --- instanceCount ---


        if ($entityStructure->hasTable)
        {
            // load
            $stmt = Mimoto::service('database')->prepare('SELECT count(mimoto_id) FROM `' . $entity->getValue('name').'`');
            $params = array();
            $stmt->execute($params);

            // load
            $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (count($aResults) == 0)
            {
                Mimoto::service('log')->error('Entity table issue', "The entity '".$entityStructure->name."' is missing its mysql table");
            }
            else
            {
                // store
                $entityStructure->instanceCount = $aResults[0]['count(mimoto_id)'];
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
                $parent = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nParentId);

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



        // --- entity names ---


        // load
        $aEntityProperties = $entity->getValue('properties');

        $nPropertyCount = count($aEntityProperties);
        for ($i = 0; $i < $nPropertyCount; $i++)
        {
            // register
            $entityProperty = $aEntityProperties[$i];

            // load
            $aPropertySettings = $entityProperty->getValue('settings');

            $nSettingCount = count($aPropertySettings);
            for ($j = 0; $j < $nSettingCount; $j++)
            {
                // register
                $propertySetting = $aPropertySettings[$j];

                $sKey = $propertySetting->getValue('key');
                $value = $propertySetting->getValue('value');

                switch($sKey)
                {
                    case EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE:

                        $entityStructure->entityNames[$value] = Mimoto::service('entityConfig')->getEntityNameById($value);
                        break;

                    case EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES:

                        // convert
                        $aAllowedEntityTypes = (!empty($value)) ? $value : [];

                        // parse
                        $nAllowedEntityTypeCount = count($aAllowedEntityTypes);
                        for ($k = 0; $k < $nAllowedEntityTypeCount; $k++)
                        {
                            // register
                            $nAllowedEntityType = $aAllowedEntityTypes[$k];

                            // register
                            $entityStructure->entityNames[$nAllowedEntityType] = Mimoto::service('entityConfig')->getEntityNameById($nAllowedEntityType);
                        }
                        break;
                }
            }
        }

        // send
        return $entityStructure;
    }


    private function getChildExtension($nEntityId)
    {
        // init
        $aChildExtensions = [];

        // load
        $stmt = Mimoto::service('database')->prepare(
            "SELECT * FROM `".CoreConfig::MIMOTO_CONNECTION."` WHERE ".
            "parent_entity_type_id = :parent_entity_type_id && ".
            "parent_property_id = :parent_property_id && ".
            "child_entity_type_id = :child_entity_type_id && ".
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
            $offspring = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $row['parent_id']);

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
        $stmt = Mimoto::service('database')->prepare(
            "SELECT * FROM `".CoreConfig::MIMOTO_CONNECTION."` WHERE ".
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
            $offspring = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $row['parent_id']);

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

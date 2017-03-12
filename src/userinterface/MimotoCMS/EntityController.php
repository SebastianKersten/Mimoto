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
        $page = Mimoto::service('aimless')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('aimless')->createComponent('Mimoto.CMS_entities_EntityOverview', $eRoot));
        
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


    public function entityNew(Application $app)
    {
        // 1. init popup
        $popup =  Mimoto::service('aimless')->createPopup();

        // 2. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 3. setup content
        $component->addForm(
            CoreConfig::COREFORM_ENTITY,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ROOT.'.'.CoreConfig::MIMOTO_ROOT.'.entities',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $component->render();
    }

    public function entityView(Application $app, $nEntityId)
    {
        // 1. init page
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // 3. validate data
        if (empty($eEntity)) return $app->redirect("/mimoto.cms/entities");

        // 4. create content
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_entities_EntityDetail', $eEntity);

        // 5. setup content
        $component->setVar('entityStructure', $this->getEntityStructure($eEntity));

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Entities',
                    "url" => '/mimoto.cms/entities'
                ),
                (object) array(
                    "label" => '<span data-aimless-value="'.CoreConfig::MIMOTO_ENTITY.'.'.$eEntity->getId().'.name">'.$eEntity->getValue('name').'</span>',
                    "url" => '/mimoto.cms/entity/'.$eEntity->getId().'/view'
                )
            )
        );

        // 7. connect
        $page->addComponent('content', $component);

        // 8. output
        return $page->render();
    }

    public function entityEdit(Application $app, $nEntityId)
    {
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. load data
        $eEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // 2. validate data
        if (empty($eEntity)) return $app->redirect("/mimoto.cms/entities");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 4. setup
        $component->addForm(
            CoreConfig::COREFORM_ENTITY,
            $eEntity,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 5. connect
        $popup->addComponent('content', $component);

        // 6. output
        return $component->render();
    }

    public function entityDelete(Application $app, $nEntityId)
    {
        // 1. load
        $entity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // 3. cleanup
        Mimoto::service('config')->entityDelete($entity);

        // 2. delete
        Mimoto::service('data')->delete($entity);

        // 4. send
        return Mimoto::service('messages')->response((object) array('result' => 'Entity deleted! '.date("Y.m.d H:i:s")), 200);
    }



    // --- EntityProperty ---


    public function entityPropertyNew(Application $app, $nEntityId)
    {
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 2. setup content
        $component->addForm(
            CoreConfig::COREFORM_ENTITYPROPERTY,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ENTITY.'.'.$nEntityId.'.properties',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $component->render();

    }

    public function entityPropertyEdit(Application $app, $nEntityPropertyId)
    {
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. load data
        $eEntityProperty = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $nEntityPropertyId);

        // 3. validate data
        if (empty($eEntityProperty)) return $app->redirect("/mimoto.cms/entities");

        // 4. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 5. setup content
        $component->addForm(
            CoreConfig::COREFORM_ENTITYPROPERTY,
            $eEntityProperty,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. render and send
        return $popup->render();
    }

    public function entityPropertyDelete(Application $app, $nEntityPropertyId)
    {
        // 1. load
        $eEtityProperty = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $nEntityPropertyId);

        // 5. delete property
        Mimoto::service('data')->delete($eEtityProperty);

        // 6. send
        return Mimoto::service('messages')->response((object) array('result' => 'EntityProperty deleted! '.date("Y.m.d H:i:s")), 200);
    }


    // --- EntityPropertySetting ---

    public function entityPropertySettingEdit(Application $app, $nEntityPropertySettingId)
    {
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. load data
        $eEntityProperty = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING, $nEntityPropertySettingId);

        // 3. validate data
        if (empty($eEntityProperty)) return $app->redirect("/mimoto.cms/entities");

        // 4. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 5. select form based on type
        switch ($eEntityProperty->getValue('key'))
        {
            case EntityConfig::SETTING_VALUE_TYPE:

                $sFormName = CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE;
                break;

            case EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE:

                $sFormName = CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE;
                break;

            case EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES:

                $sFormName = CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES;
                break;

            case EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES:

                $sFormName = CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES;
                break;
        }

        // 6. setup content
        $component->addForm(
            $sFormName,
            $eEntityProperty,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 7. connect
        $popup->addComponent('content', $component);

        // 8. render and send
        return $component->render();
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
            $stmt = Mimoto::service('database')->prepare('SELECT count(id) FROM `' . $entity->getValue('name').'`');
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

                        $entityStructure->entityNames[$value] = Mimoto::service('config')->getEntityNameById($value);
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
                            $entityStructure->entityNames[$nAllowedEntityType] = Mimoto::service('config')->getEntityNameById($nAllowedEntityType);
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

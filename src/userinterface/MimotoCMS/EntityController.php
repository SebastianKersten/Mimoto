<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\UserInterface\MimotoCMS\utils\InterfaceUtils;
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
        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_ENTITY]);

        // create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_entities_EntityOverview');

        // setup
        $page->addSelection('entities', $aEntities, 'Mimoto.CMS_entities_EntityOverview_ListItem');

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);
        
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
        $entity = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITY);

        // 1. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_ENTITY, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 3. render and send
        return $component->render();
    }

    public function entityView(Application $app, $nEntityId)
    {
        // 1. load requested entity
        $entity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // 2. check if entity exists
        if ($entity === false) return $app->redirect("/mimoto.cms/entities");

        // 3. create component
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_entities_EntityDetail', $entity);

        // 4. setup component
        $page->setPropertyComponent('properties', 'Mimoto.CMS_entities_EntityDetail-EntityProperty');

        //error($page);
        $page->addSelection('menuContentSections', []);

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);


        // todo - insert as simple values, add realtime support later

        // setup page
        $page->setVar('entityStructure', $this->getEntityStructure($entity));
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Entities',
                    "url" => '/mimoto.cms/entities'
                ),
                (object) array(
                    "label" => '"<span data-aimless-value="'.CoreConfig::MIMOTO_ENTITY.'.'.$entity->getId().'.name">'.$entity->getValue('name').'</span>"',
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
        $entity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/entities");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_ENTITY, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 5. render and send
        return $component->render();
    }

    public function entityDelete(Application $app, $nEntityId)
    {
        // 1. load
        $entity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // delete
        Mimoto::service('data')->delete($entity);
        Mimoto::service('config')->entityDelete($entity);

        // send
        return new JsonResponse((object) array('result' => 'Entity deleted! '.date("Y.m.d H:i:s")), 200);
    }



    // --- EntityProperty ---


    public function entityPropertyNew(Application $app, $nEntityId)
    {
        // create dummy
        $entityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);

        // 1. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_ENTITYPROPERTY, $entityProperty, ['onCreatedConnectTo' => CoreConfig::MIMOTO_ENTITY.'.'.$nEntityId.'.properties', 'response' => ['onSuccess' => ['closePopup' => true]]]);

        // 3. render and send
        return $component->render();

    }

    public function entityPropertyEdit(Application $app, $nEntityPropertyId)
    {
        // 1. load
        $entity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $nEntityPropertyId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/entities");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_ENTITYPROPERTY, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 5. render and send
        return $component->render();
    }

    public function entityPropertyDelete(Application $app, $nEntityPropertyId)
    {
        // 1. load
        $entityProperty = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITYPROPERTY, $nEntityPropertyId);

        // 2. load settings
        $aEntityPropertySetting = $entityProperty->getValue('settings');

        // 3. delete settings
        $aSettingCount = count($aEntityPropertySetting);
        for ($aSettingIndex = 0; $aSettingIndex < $aSettingCount; $aSettingIndex++)
        {
            // register
            $setting = $aEntityPropertySetting[$aSettingIndex];

            // remoe connections from settings
            switch($setting->getValue('key'))
            {
                case EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE:

                    // unset
                    $setting->setValue(EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE, null);

                    // persist
                    Mimoto::service('data')->store($setting);

                    break;

                case EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES:

                    $aAllowedEntityTypes = $setting->getValue(EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES);

                    $nAllowedEntityTypeCount = count($aAllowedEntityTypes);
                    for ($nAllowedEntityTypeIndex = 0; $nAllowedEntityTypeIndex < $nAllowedEntityTypeCount; $nAllowedEntityTypeIndex++)
                    {
                        // register
                        $allowedEntityType = $aAllowedEntityTypes[$nAllowedEntityTypeIndex];

                        // remove
                        $setting->removeValue(EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES, $allowedEntityType);
                    }

                    // persist
                    Mimoto::service('data')->store($setting);

                    break;
            }

            // remove connection
            $entityProperty->removeValue('settings', $setting);

            // delete connection
            Mimoto::service('data')->delete($setting);
        }

        // 4. persist removed connections
        Mimoto::service('data')->store($entityProperty);

        // 5. load
        $parentEntity = $app['Mimoto.Config']->getParentEntity($entityProperty);

        // 6. remove connection
        $parentEntity->removeValue('properties', $entityProperty);

        // 7. persist removed
        Mimoto::service('data')->store($parentEntity);

        // 5. delete property
        Mimoto::service('data')->delete($entityProperty);

        // 6. send
        return new JsonResponse((object) array('result' => 'EntityProperty deleted! '.date("Y.m.d H:i:s")), 200);
    }


    // --- EntityPropertySetting ---

    public function entityPropertySettingEdit(Application $app, $nEntityPropertySettingId)
    {
        // 1. load
        $entity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING, $nEntityPropertySettingId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/entities");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. select form based on type
        switch ($entity->getValue('key'))
        {
            case EntityConfig::SETTING_VALUE_TYPE:

                $component->addForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);
                break;

            case EntityConfig::SETTING_ENTITY_ALLOWEDENTITYTYPE:

                $component->addForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);
                break;

            case EntityConfig::SETTING_COLLECTION_ALLOWEDENTITYTYPES:

                $component->addForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);
                break;

            case EntityConfig::SETTING_COLLECTION_ALLOWDUPLICATES:

                $component->addForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);
                break;
        }

        // 5. render and send
        return $component->render();
    }




    // --- other ---


    private function getEntityStructure(MimotoEntity $entity)
    {
        // init
        $entityStructure = (object) array();
        $entityStructure->name = $entity->getValue('name');
        $entityStructure->hasTable = false; //(intval($entity->getValue('isAbstract')) === 1) ? false : true;
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

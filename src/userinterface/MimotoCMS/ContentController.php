<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Core\entities\Dataset;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;


/**
 * ContentController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ContentController
{

    public function contentEdit(Application $app, $nContentId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eContentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_DATASET, $nContentId);

        // 3. validate data
        if (empty($eContentSectionEntity)) return $app->redirect("/mimoto.cms");

        // 4. read properties
        $sName = $eContentSectionEntity->getValue('name');
        $sType = $eContentSectionEntity->getValue('type');
        $sFormName = $eContentSectionEntity->getValue('form.name');

        // 5. toggle between contentItem and contentGroup
        switch($sType)
        {
            case Dataset::TYPE_ITEM:

                // 5a. read current value (could also be empty)
                $contentItem = $eContentSectionEntity->getValue('contentItem');

                // 5b. create page containing a form
                $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

                // 5c. setup form
                $component->addForm($sFormName, $contentItem, ['onCreatedConnectTo' => CoreConfig::MIMOTO_DATASET.'.'.$nContentId.'.contentItem']);

                break;

            case Dataset::TYPE_GROUP:

                // 5d. create component
                $component = Mimoto::service('output')->createComponent('MimotoCMS_content_ContentOverview', $eContentSectionEntity);

                // 5e. setup content
                $component->setVar('nContentSectionId', $nContentId);

                break;

            default:

                // 5f. report
                Mimoto::service('log')->warn("ContentSection with invalid type", "A content section id=`$nContentId` requested for edit has an unknown type of value `$sType`");
        }

        // 6. connect
        $page->addComponent('content', $component);

        // 7. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => $sName,
                    "url" => '/mimoto.cms/content/'.$nContentId
                )
            )
        );

        // 8. output
        return $page->render();
    }

    public function contentGroupItemNew(Application $app, $nContentId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eContentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_DATASET, $nContentId);

        // 3. validate data
        if (empty($eContentSectionEntity)) return $app->redirect("/mimoto.cms/datasets");

        // 4. read properties
        //$sName = $eContentSectionEntity->getValue('name');
        $sFormName = $eContentSectionEntity->getValue('form.name');


        // 5. --- instantly create new entity


        // 5a. get form
        $eForm = Mimoto::service('input')->getFormByName($sFormName);

        // 5b. get form's entity
        $eFormParentEntity = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $eForm);

        // 5c. create entity
        $eNewEntity = Mimoto::service('data')->create($eFormParentEntity->getValue('name'));

        // 5d. persist entity
        Mimoto::service('data')->store($eNewEntity);

        // 5e. connect
        $eContentSectionEntity->addValue('contentItems', $eNewEntity);

        // 5f. persist connection
        Mimoto::service('data')->store($eContentSectionEntity);


        // 5. --- [end]

        // redirect to edit
        return $app->redirect('/mimoto.cms/content/'.$nContentId.'/'.$eFormParentEntity->getValue('name').'/'.$eNewEntity->getId().'/edit');

//
//        // 6. create content
//        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');
//
//        // 7. setup content
//        $component->addForm(
//            $sFormName,
//            $eNewEntity,
//            [
//                //'onCreatedConnectTo' => CoreConfig::MIMOTO_DATASET.'.'.$nContentId.'.contentItems',
//                'response' => [
//                    'onSuccess' => [
//                        'loadPage' => '/mimoto.cms/content/'.$nContentId
//                    ]
//                ]
//            ]
//        );
//
//        // 8. setup page
//        $page->setVar('nContentSectionId', $nContentId);
//        $page->setVar('pageTitle', array(
//                (object) array(
//                    "label" => $sName,
//                    "url" => '/mimoto.cms/content/'.$nContentId
//                ),
//                (object) array(
//                    "label" => 'new',
//                    "url" => ''
//                )
//            )
//        );
//
//        // 9. connect
//        $page->addComponent('content', $component);
//
//        // 10. output
//        return $page->render();
    }

    public function contentGroupItemEdit(Application $app, $nContentId, $sContentTypeName, $nContentItemId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load config data
        $contentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_DATASET, $nContentId);

        // 3. validate config data
        if (empty($contentSectionEntity)) return $app->redirect("/mimoto.cms/datasets");

        // 4. read properties
        $sName = $contentSectionEntity->getValue('name');
        $sFormName = $contentSectionEntity->getValue('form.name');

        // 5. load data
        $eEntity = Mimoto::service('data')->get($sContentTypeName, $nContentItemId);


        // 3. validate config data
        if (empty($eEntity)) return $app->redirect('/mimoto.cms/content/'.$nContentId);


        // 6. create page containing a form
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 7. setup form
        $component->addForm(
            $sFormName,
            $eEntity,
            [
                //'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/content/'.$nContentId]]
            ]
        );


        // init
        $sLabelProperty = '...';

        // get first value field
        $aPropertyNames = $eEntity->getPropertyNames();

        $nPropertyNameCount = count($aPropertyNames);
        for ($nPropertyNameIndex = 0; $nPropertyNameIndex < $nPropertyNameCount; $nPropertyNameIndex++)
        {
            // register
            $sPropertyName = $aPropertyNames[$nPropertyNameIndex];

            // verify
            if ($eEntity->getPropertyType($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
            {
                $sLabelProperty = '<span data-mimoto-value="'.$eEntity->getEntityTypeName().'.'.$eEntity->getId().'.'.$sPropertyName.'">'.$eEntity->getValue($sPropertyName).'</span>';
                break;
            }
        }


        // 8. connect
        $page->addComponent('content', $component);

        // 9. setup page
        $page->setVar('nContentSectionId', $nContentId);
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => $sName,
                    "url" => '/mimoto.cms/content/'.$nContentId
                ),
                (object) array(
                    "label" => $sLabelProperty,
                    "url" => '/mimoto.cms/content/'.$nContentId
                )
            )
        );

        // 10. output
        return $page->render();
    }

    public function contentGroupItemDelete(Application $app, $nContentId, $sContentTypeName, $nContentItemId)
    {
        // 1. load data
        $eEntity = Mimoto::service('data')->get($sContentTypeName, $nContentItemId);

        // 2. cleanup
        Mimoto::service('data')->delete($eEntity);

        // 3. send
        return Mimoto::service('messages')->response((object) array('result' => 'Content item deleted! '.date("Y.m.d H:i:s")), 200);
    }

}

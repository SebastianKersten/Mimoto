<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Core\entities\ContentSection;
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
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eContentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentId);

        // 3. validate data
        if ($eContentSectionEntity === false) return $app->redirect("/mimoto.cms");

        // 4. read properties
        $sName = $eContentSectionEntity->getValue('name');
        $sType = $eContentSectionEntity->getValue('type');
        $sFormName = $eContentSectionEntity->getValue('form.name');

        // 5. toggle between contentItem and contentGroup
        switch($sType)
        {
            case ContentSection::TYPE_ITEM:

                // 5a. read current value (could also be empty)
                $contentItem = $eContentSectionEntity->getValue('contentItem');

                // 5b. create page containing a form
                $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

                // 5c. setup form
                $component->addForm($sFormName, $contentItem, ['onCreatedConnectTo' => CoreConfig::MIMOTO_CONTENTSECTION.'.'.$nContentId.'.contentItem']);

                break;

            case ContentSection::TYPE_GROUP:

                // 5d. create component
                $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_content_ContentOverview', $eContentSectionEntity);

                break;

            default:

                // 5e. report
                Mimoto::service('log')->warn("ContentSection with invalid type", "A content section id=`$nContentId` requested for edit has an unknown type of value `$sType`");
        }

        // 6. connect
        $page->addComponent('content', $component);

        // 7. setup page
        $page->setVar('nContentSectionId', $nContentId);
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
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eContentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentId);

        // 3. validate data
        if ($eContentSectionEntity === false) return $app->redirect("/mimoto.cms/contentsections");

        // 4. read properties
        $sName = $eContentSectionEntity->getValue('name');
        $sFormName = $eContentSectionEntity->getValue('form.name');

        // 5. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 6. setup content
        $component->addForm(
            $sFormName,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_CONTENTSECTION.'.'.$nContentId.'.contentItems',
                'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/content/'.$nContentId]]
            ]
        );

        // 7. setup page
        $page->setVar('nContentSectionId', $nContentId);
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => $sName,
                    "url" => '/mimoto.cms/content/'.$nContentId
                ),
                (object) array(
                    "label" => '- temp label -',
                    "url" => '/mimoto.cms/content/'.$nContentId
                )
            )
        );

        // connect
        $page->addComponent('content', $component);

        // 8. output
        return $page->render();
    }

    public function contentGroupItemEdit(Application $app, $nContentId, $sContentTypeName, $nContentItemId)
    {
        // 1. init page
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load config data
        $contentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentId);

        // 3. validate config data
        if ($contentSectionEntity === false) return $app->redirect("/mimoto.cms/contentsections");

        // 4. read properties
        $sName = $contentSectionEntity->getValue('name');
        $sFormName = $contentSectionEntity->getValue('form.name');

        // 5. load data
        $eEntity = Mimoto::service('data')->get($sContentTypeName, $nContentItemId);

        // 6. create page containing a form
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 7. setup form
        $component->addForm(
            $sFormName,
            $eEntity,
            [
                'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/content/'.$nContentId]]
            ]
        );

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
                    "label" => '- temp label -',
                    "url" => '/mimoto.cms/content/'.$nContentId
                )
            )
        );

        // 10. output
        return $page->render();
    }

}

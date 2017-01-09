<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Core\entities\ContentSection;
use Mimoto\Mimoto;
use Mimoto\UserInterface\MimotoCMS\utils\InterfaceUtils;
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
        // 1. load content section
        $contentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentId);

        // 2. check if contentSection exists
        if ($contentSectionEntity === false) return $app->redirect("/mimoto.cms/contentsections");

        // 3. read properties
        $sName = $contentSectionEntity->getValue('name');
        $sType = $contentSectionEntity->getValue('type');
        $sFormName = $contentSectionEntity->getValue('form.name');

        // 4. toggle between contentItem and contentGroup
        switch($sType)
        {
            case ContentSection::TYPE_ITEM:

                // 4a. read current value (could also be empty)
                $contentItem = $contentSectionEntity->getValue('contentItem');

                // 4b. create page containing a form
                $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Page');

                // 4c. setup form
                $page->addForm($sFormName, $contentItem, ['onCreatedConnectTo' => CoreConfig::MIMOTO_CONTENTSECTION.'.'.$nContentId.'.contentItem']);

                break;

            case ContentSection::TYPE_GROUP:

                // 4d. create component
                $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_contents_ContentOverview', $contentSectionEntity);

                break;

            default:

                // 4e. report
                Mimoto::service('log')->warn("ContentSection with invalid type", "A content section id=`$nContentId` requested for edit has an unknown type of value `$sType`");
        }

        // 5. add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // 6. setup page
        $page->setVar('nContentSectionId', $nContentId);
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => $sName,
                    "url" => '/mimoto.cms/content/'.$nContentId
                )
            )
        );

        // 7. output
        return $page->render();
    }

    public function contentGroupItemNew(Application $app, $nContentId)
    {
        // 1. load content section
        $contentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentId);

        // 2. check if contentSection exists
        if ($contentSectionEntity === false) return $app->redirect("/mimoto.cms/contentsections");


        // 3. read properties
        $sName = $contentSectionEntity->getValue('name');
        $sFormName = $contentSectionEntity->getValue('form.name');

        // 4b. create page containing a form
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Page');

        // 4c. setup form
        $page->addForm($sFormName, null, ['onCreatedConnectTo' => CoreConfig::MIMOTO_CONTENTSECTION.'.'.$nContentId.'.contentItems', 'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/content/'.$nContentId]]]);

        // 5. add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // 6. setup page
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

        // 7. output
        return $page->render();
    }

    public function contentGroupItemEdit(Application $app, $nContentId, $sContentTypeName, $nContentItemId)
    {
        // 1. load content section
        $contentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentId);

        // 2. check if contentSection exists
        if ($contentSectionEntity === false) return $app->redirect("/mimoto.cms/contentsections");

        // 3. read properties
        $sName = $contentSectionEntity->getValue('name');
        $sFormName = $contentSectionEntity->getValue('form.name');


        $entity = Mimoto::service('data')->get($sContentTypeName, $nContentItemId);


        // 4b. create page containing a form
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Page');

        // 4c. setup form
        $page->addForm($sFormName, $entity, ['response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/content/'.$nContentId]]]);

        // 5. add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // 6. setup page
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

        // 7. output
        return $page->render();
    }

}

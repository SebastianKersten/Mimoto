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
        // 1. load contentSection
        // 2. check type
        // 3. if single -> load form
        // 4. if group -> show overview


        // 1. load content section
        $contentSectionEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_CONTENTSECTION, $nContentId);

        // 2. check if contentSection exists
        if ($contentSectionEntity === false) return $app->redirect("/mimoto.cms");



        // 5. read contentItem

        // 6. read contentItems


        // read
        $sName = $contentSectionEntity->getValue('name');
        $sType = $contentSectionEntity->getValue('type');
        $sFormName = $contentSectionEntity->getValue('form.name');

        // toggle
        switch($sType)
        {
            case ContentSection::TYPE_ITEM:

                // 1. read current value (could also be empty)
                $contentItem = $contentSectionEntity->getValue('contentItem');

                // 2. create page containing a form
                $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Page');

                // 3. setup form
                $page->addForm($sFormName, $contentItem, ['onCreatedConnectTo' => CoreConfig::MIMOTO_CONTENTSECTION.'.'.$nContentId.'.contentItem']);

                break;

            case ContentSection::TYPE_GROUP:

                $aContentItems = $contentSectionEntity->getValue('contentItems');

                // create
                $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_contentsections_ContentSectionOverview');

                // setup
                $page->addSelection('contentItems', $aContentItems, 'Mimoto.CMS_contentsections_ContentSectionOverview_ListItem');

                break;

            default:

                Mimoto::service('log')->warn("ContentSection with invalid type", "A content section id=`$nContentId` requested for edit has an unknown type of value `$sType`");
        }

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => $sName,
                    "url" => '/mimoto.cms/content/'.$nContentId
                )
            )
        );

        // output
        return $page->render();
    }

}

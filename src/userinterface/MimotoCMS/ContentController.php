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

    public function contentView(Application $app, $nDatasetId)
    {
        // 1. init page
        $page = Mimoto::service('output')->create(Mimoto::value('page.layout.default'), Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eDataset = Mimoto::service('data')->get(CoreConfig::MIMOTO_DATASET, $nDatasetId);

        // 3. validate data
        if (empty($eDataset)) return $app->redirect("/mimoto.cms");

        // 4. read properties
        $sName = $eDataset->getValue('name');

        // 5. create component
        $component = Mimoto::service('output')->create('MimotoCMS_content_ContentOverview', $eDataset);

        // 6. setup content
        $component->setVar('nDatasetId', $nDatasetId);

        // 7. connect
        $page->addComponent('content', $component);

        // 8. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => $sName,
                    "url" => '/mimoto.cms/content/'.$nDatasetId
                )
            )
        );

        // 9. output
        return $page->render();
    }

    public function contentEdit(Application $app, $sContentTypeName, $nContentItemId)
    {
        // 1. init page
        $page = Mimoto::service('output')->create(Mimoto::value('page.layout.default'), Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eInstance = Mimoto::service('data')->get($sContentTypeName, $nContentItemId);

        // 3. validate config data
        if (empty($eInstance)) return $app->redirect('/mimoto.cms/datasets');

        // 4. get containing dataset
        $eDataset = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_DATASET, CoreConfig::MIMOTO_DATASET.'--data', $eInstance);

        // 5. read properties
        $nDatasetId = $eDataset->getId();
        $sName = $eDataset->getValue('name');
        $sFormName = $eDataset->getValue('form.name');

        // 6. load
        $eForm = $eDataset->getValue('form');

        // 7. create page containing a form
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form', $eForm);

        // 8. setup form
        $component->addForm(
            $sFormName,
            $eInstance,
            [
                //'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/content/'.$nContentId]]
            ]
        );

        $component->setVar('onClickFormMenuButtonOk', (object) array('menu' => ['onClick' => ['loadPage' => '/mimoto.cms/content/'.$nDatasetId]]));


        // init
        $sLabelProperty = '...';

        // get first value field
        $aPropertyNames = $eInstance->getPropertyNames();

        $nPropertyNameCount = count($aPropertyNames);
        for ($nPropertyNameIndex = 0; $nPropertyNameIndex < $nPropertyNameCount; $nPropertyNameIndex++)
        {
            // register
            $sPropertyName = $aPropertyNames[$nPropertyNameIndex];

            // verify
            if ($eInstance->getPropertyType($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
            {
                // do not output objects like a password or json #todo - check type (pwd or json)
                $sLabelProperty = !is_object($eInstance->get($sPropertyName)) ? '<span data-mimoto-value="'.$eInstance->getEntityTypeName().'.'.$eInstance->getId().'.'.$sPropertyName.'">'.$eInstance->getValue($sPropertyName).'</span>' : '';
                break;
            }
        }


        // 8. connect
        $page->addComponent('content', $component);

        // 9. setup page
        $page->setVar('nContentSectionId', $nDatasetId);
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => $sName,
                    "url" => '/mimoto.cms/content/'.$nDatasetId
                ),
                (object) array(
                    "label" => $sLabelProperty,
                    "url" => '/mimoto.cms/content/instance/'.$eInstance->getEntityTypeName().'/'.$eInstance->getId().'/edit'
                )
            )
        );

        // 10. output
        return $page->render();
    }

}

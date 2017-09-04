<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;


/**
 * DatasetController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DatasetController
{

    public function viewDatasetOverview(Application $app)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage($eRoot = Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. create and connect content
        $page->addComponent('content', Mimoto::service('output')->createComponent('MimotoCMS_datasets_DatasetOverview', $eRoot));

        // 3. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Datasets',
                    "url" => '/mimoto.cms/datasets'
                )
            )
        );

        // 4. output
        return $page->render();
    }

    public function datasetView(Application $app, $nDatasetId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eDataset = Mimoto::service('data')->get(CoreConfig::MIMOTO_DATASET, $nDatasetId);

        // 3. validate data
        if (empty($eDataset)) return $app->redirect("/mimoto.cms/datasets");

        // 4. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_datasets_DatasetDetail', $eDataset);

        // 5. connect
        $page->addComponent('content', $component);

        // 6. setup page
        $page->setVar('pageTitle', array(
                (object) array(
                    "label" => 'Datasets',
                    "url" => '/mimoto.cms/datasets'
                ),
                (object) array(
                    "label" => '<span data-mimoto-value="'.CoreConfig::MIMOTO_DATASET.'.'.$eDataset->getId().'.name">'.$eDataset->getValue('name').'</span>',
                    "url" => '/mimoto.cms/dataset/'.$eDataset->getId().'/view'
                )
            )
        );

        // 7. output
        return $page->render();
    }

}

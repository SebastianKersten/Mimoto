<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

// Silex classes
use Silex\Application;


/**
 * DataController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DataController
{

    /**
     * View component overview
     * @return string The rendered html output
     */
    public function createAndAdd(Application $app, Request $request)
    {


        // 1. wat openen? page or popup? create = page
        // 2. select = popup



        // 1. validate
        if (!MimotoDataUtils::isValidId($nEntityId)) $app->redirect('/mimoto.cms');


        // ---


        // 2. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 3. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');


        // ---


        // 4. setup
        $aParentEntities = [(object) array('type' => CoreConfig::MIMOTO_ROOT, 'id' => CoreConfig::MIMOTO_ROOT, 'property' => 'components')];

        // 5. verify and add
        if (MimotoDataUtils::isValidId($nEntityId))
        {
            $aParentEntities[] = (object) array('type' => CoreConfig::MIMOTO_ENTITY, 'id' => $nEntityId, 'property' => 'components');
        }

        // 6. create and connect
        $eComponent = Mimoto::service('data')->createAndConnect(CoreConfig::MIMOTO_COMPONENT, $aParentEntities);


        // ---


        // 7. setup content
        $component->addForm(
            CoreConfig::COREFORM_COMPONENT,
            $eComponent,
            [
                //'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $page->addComponent('content', $component);

        // 5. output
        return $page->render();
    }


    public function remove($sEntitySelector)
    {
        // split elements from selector and forward
        // check permissions
    }

}

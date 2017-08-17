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

    public function edit(Application $app, Request $request)
    {
        // 1. register
        $sPropertySelector = $request->get('sPropertySelector');
        $sFormName = $request->get('sFormName');

        // 2. extract
        $sEntity = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);

        // 3. load
        $eEntity = Mimoto::service('data')->get($sEntity, $nInstanceId);


        // ---


        // 4. init page
        $popup = Mimoto::service('output')->createPopup();

        // 3. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 7. setup content
        $component->addForm(
            $sFormName,
            $eEntity,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
    }

    /**
     * .......
     * @return string The rendered html output
     */
    public function add(Application $app, Request $request)
    {
        // 1. register
        $sPropertySelector = $request->get('sPropertySelector');
        $sFormName = $request->get('sFormName');

        // 2. extract
        $sEntity = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);
        $sPropertyName = MimotoDataUtils::getPropertyFromFromEntityPropertySelector($sPropertySelector);

        // 3. setup
        $aParentEntities[] = [(object) array('type' => CoreConfig::MIMOTO_ENTITY, 'id' => $nInstanceId, 'property' => $sPropertyName)];


        // get parent

        // 3. load
        $eEntity = Mimoto::service('data')->createAndConnect(CoreConfig::MIMOTO_COMPONENT, $aParentEntities);




        // 6. create and connect
        $eComponent =




        // 4. init page
        $popup = Mimoto::service('output')->createPopup();

        // 3. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 7. setup content
        $component->addForm(
            $sFormName,
            $eEntity,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();


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

        }




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

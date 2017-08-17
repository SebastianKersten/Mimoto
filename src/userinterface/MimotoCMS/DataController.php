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
        $sEntitySelector = $request->get('sEntitySelector');
        $sFormName = $request->get('sFormName');

        // 2. extract
        $sEntity = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sEntitySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sEntitySelector);

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
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);
        $sPropertyName = MimotoDataUtils::getPropertyFromFromEntityPropertySelector($sPropertySelector);

        // 3. load
        $eForm = Mimoto::service('input')->getFormByName($sFormName);


        // if form name not found -> return error message
        //Mimoto::error($eForm);

        // 1. what about multiple options


        $sNewEntityType = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $eForm);



        // 5. configure
        $aParentEntitySelectionConfigs = [(object) array('type' => $sInstanceType, 'id' => $nInstanceId, 'property' => $sPropertyName)];

        //Mimoto::error($aParentEntitySelectionConfigs);

        // 6. load
        $eNewEntity = Mimoto::service('data')->createAndConnect($sNewEntityType, $aParentEntitySelectionConfigs);


        // ---


        // 7. init page
        $popup = Mimoto::service('output')->createPopup();

        // 8. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 9. setup content
        $component->addForm(
            $sFormName,
            $eNewEntity,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 10. connect
        $popup->addComponent('content', $component);

        // 11. output
        return $popup->render();
    }


    public function remove(Application $app, Request $request)
    {
        // 1. register
        $sEntitySelector = $request->get('sEntitySelector');

        // 2. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sEntitySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sEntitySelector);

        // 3. load
        $eEntity = Mimoto::service('data')->get($sInstanceType, $nInstanceId);

        // 4. remove
        Mimoto::service('data')->delete($eEntity);

        // 5. output
        return Mimoto::service('messages')->response((object) array('result' => 'Instance deleted! '.date("Y.m.d H:i:s")), 200);
    }

}

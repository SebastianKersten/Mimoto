<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
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

    public function select(Application $app, Request $request)
    {
        // 1. register
        $sPropertySelector = $request->get('sPropertySelector');
        $xSelection = $request->get('xSelection');

        // 2. select
        $aSelection = Mimoto::service('data')->select($xSelection);


        // ---


        // 3. init popup
        $popup = Mimoto::service('output')->create('MimotoCMS_layout_Selection');

        // 4. prepare
        $options = (object) array(
            'values' => (object) array(
                'sPropertySelector' => $sPropertySelector
            )
        );

        // 5. fill
        $popup->fillContainer('selection', $aSelection, 'MimotoCMS_components_selection_SelectableItem', $options);

        // 6. output
        return $popup->render();
    }

    public function set(Application $app, Request $request)
    {
        // 1. register
        $sPropertySelector = $request->get('sPropertySelector');
        $value = $request->get('value');

        // 2. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);
        $sPropertyName = MimotoDataUtils::getPropertyFromFromEntityPropertySelector($sPropertySelector);


        // ---


        // 3. load
        $eEntity = Mimoto::service('data')->get($sInstanceType, $nInstanceId);

        // 4. register
        $sPropertyType = $eEntity->getPropertyType($sPropertyName);

        // 5. parse
        switch($sPropertyType)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                $eEntity->setValue($sPropertyName, $value);
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                // a. retrieve
                $sChildType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($value);
                $sChildId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($value);

                // b. load
                $eChild = Mimoto::service('data')->get($sChildType, $sChildId);

                // c. set value
                if ($sPropertyType == MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY)
                {
                    $eEntity->setValue($sPropertyName, $eChild);
                }
                else
                {
                    $eEntity->addValue($sPropertyName, $value);
                }

                // d. store
                Mimoto::service('data')->store($eEntity);
                break;
        }

        // 6. output
        return Mimoto::service('messages')->response('Value for '.$sPropertySelector.' set to '.$value);
    }

}

<?php

// classpath
namespace Mimoto\api;

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
        // 1. load and convert
        $data = MimotoDataUtils::decodePostData($request->get('data'));

        // 1. register
        $sEntitySelector = $data->sEntitySelector;
        $sFormName = $data->sFormName;

        // 2. extract
        $sEntity = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sEntitySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sEntitySelector);

        // 3. load
        $eEntity = Mimoto::service('data')->get($sEntity, $nInstanceId);


        // ---

        // 4. load
        $eForm = Mimoto::service('input')->getFormByName($sFormName);


        // ---


        // 5. init page
        $popup = Mimoto::service('output')->createPopup();

        // 6. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_PopupForm', $eForm);

        // 7. setup content
        $component->addForm(
            $sFormName,
            $eEntity,
            [
                //'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 8. connect
        $popup->addComponent('content', $component);

        // 9. output
        return $popup->render();
    }

    /**
     * .......
     * @return string The rendered html output
     */
    public function add(Application $app, Request $request)
    {
        // 1. load and convert
        $data = MimotoDataUtils::decodePostData($request->get('data'));

        // 1. register
        $sPropertySelector = $data->sPropertySelector;
        $sFormName = $data->sFormName;

        // 2. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);
        $sPropertyName = MimotoDataUtils::getPropertyFromFromEntityPropertySelector($sPropertySelector);

        // 3. load
        $eForm = Mimoto::service('input')->getFormByName($sFormName);

        // 4. register
        $bManualSave = $eForm->get('manualSave');

        // 5. setup
        $aActions = [
        //    'response' => ['onSuccess' => ['closePopup' => true]]
        ];

        // 6. verify
        if ($bManualSave)
        {
            // a. init
            $eNewEntity = null;

            // b. setup
            $aActions['onCreatedConnectTo'] = $sPropertySelector;
        }
        else
        {
            // I. load
            $eParent = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $eForm);

            // II. configure
            $aParentEntitySelectionConfigs = [(object) array('type' => $sInstanceType, 'id' => $nInstanceId, 'property' => $sPropertyName)];

            // III. load
            $result = Mimoto::service('data')->createAndConnect($eParent->getValue('name'), $aParentEntitySelectionConfigs);

            // IV. register
            $eNewEntity = $result->entity;
        }



        // ---


        // 7. init page
        $popup = Mimoto::service('output')->createPopup();

        // 8. create content
        $component = Mimoto::service('output')->create('MimotoCMS_layout_PopupForm', $eForm);

        // 9. setup content
        $component->addForm(
            $sFormName,
            $eNewEntity,
            $aActions
        );

        // 10. connect
        $popup->addComponent('content', $component);

        // 11. output
        return $popup->render();
    }


    public function remove(Application $app, Request $request)
    {
        // 1. load and convert
        $data = MimotoDataUtils::decodePostData($request->get('data'));

        // 1. register
        $sEntitySelector = $data->sEntitySelector;
        $nConnectionId = $data->nConnectionId;

        // 2. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sEntitySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sEntitySelector);

        // 3. load
        $eEntity = Mimoto::service('data')->get($sInstanceType, $nInstanceId);

        // 4. remove
        Mimoto::service('data')->delete($eEntity, $nConnectionId);

        // 5. output
        return Mimoto::service('messages')->response((object) array('result' => 'Instance deleted! '.date("Y.m.d H:i:s")), 200);
    }

    public function select(Application $app, Request $request)
    {
        // 1. load and convert
        $data = MimotoDataUtils::decodePostData($request->get('data'));

        // 2. register
        $sPropertySelector = $data->sPropertySelector;
        $xSelection = $data->xSelection;
        $options = (isset($data->options)) ? $data->options : null;

        // 3. load
        $selection = Mimoto::service('selection')->getSelection($xSelection);

        // 4. apply vars
        if (!empty(($options)) && ((is_array($options) && isset($options['vars']) || isset($options->vars))))
        {
            // register
            $aVars = (is_array($options) && isset($options['vars'])) ? $options['vars'] : $options->vars;

            foreach($aVars as $sKey => $sVarValue)
            {
                $selection->applyVar($sKey, $sVarValue);
            }

            // cleanup
            unset($options->vars);
        }

        // 5. select
        $aInstances = Mimoto::service('data')->select($selection);


        // ---


        // 6. init popup
        $popup = Mimoto::service('output')->create('MimotoCMS_layout_Selection');

        // 7. prepare
        $optionsForTemplate = (object) array(
            'values' => (object) array(
                'sPropertySelector' => $sPropertySelector,
                'options' => $options
            )
        );

        // 8. fill
        $popup->fillContainer('selection', $aInstances, 'MimotoCMS_components_selection_SelectableItem', $optionsForTemplate);

        // 9. output
        return $popup->render();
    }

    public function set(Application $app, Request $request)
    {
        // 1. load and convert
        $data = MimotoDataUtils::decodePostData($request->get('data'));

        // 2. register
        $sPropertySelector = $data->sPropertySelector;
        $value = $data->value;
        $options = (isset($data->options)) ? $data->options : null;

        // 3. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);
        $sPropertyName = MimotoDataUtils::getPropertyFromFromEntityPropertySelector($sPropertySelector);


        // ---


        // 4. load
        $eInstance = Mimoto::service('data')->get($sInstanceType, $nInstanceId);

        // 5. register
        $sPropertyType = $eInstance->getPropertyType($sPropertyName);

        // 6. parse
        switch($sPropertyType)
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                // special case for handling core data
                if (substr($value, 0, strlen(CoreConfig::MIMOTO_COREDATA_KEYVALUE)) === CoreConfig::MIMOTO_COREDATA_KEYVALUE)
                {
                    // a. retrieve
                    $sChildType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($value);
                    $sChildId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($value);

                    // b. load
                    $eChild = Mimoto::service('data')->get($sChildType, $sChildId);

                    // c. register
                    $value = $eChild->get('value');
                }

                // update
                $eInstance->setValue($sPropertyName, $value);
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
                    $eInstance->setValue($sPropertyName, $eChild);
                }
                else
                {
                    $eInstance->addValue($sPropertyName, $eChild);
                }
                break;
        }


        // manage changes
        if (!empty(($options)) && !empty($eInstance->getChanges()) && ((is_array($options) && isset($options['onChange']) || isset($options->onChange))))
        {
            // register
            $aOnChange = (is_array($options) && isset($options['onChange'])) ? $options['onChange'] : $options->onChange;

            foreach($aOnChange as $nIndex => $sVarValue)
            {
                // register
                $aDirective = $aOnChange[$nIndex];

                // register
                $sDirective = $aDirective[0];
                $sPropertyName = $aDirective[1];
                $value = (isset($aDirective[2])) ? $aDirective[2] : null;

                switch($sDirective)
                {
                    case 'clear':

                        $this->clearProperty($eInstance, $sPropertyName);
                        break;

                    case 'set': // #todo

                        //$this->setProperty($eInstance, $sPropertyName, $value);
                        break;
                }
            }
        }

        // store
        Mimoto::service('data')->store($eInstance);

        // 7. output
        return Mimoto::service('messages')->response('Value for '.$sPropertySelector.' set to '.$value);
    }

    public function create(Application $app, Request $request)
    {
        // 1. load and convert
        $data = MimotoDataUtils::decodePostData($request->get('data'));

        // 1. register
        $sPropertySelector = $data->sPropertySelector;
        $sEntityName = $data->sEntityName;

        // 2. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);
        $sPropertyName = MimotoDataUtils::getPropertyFromFromEntityPropertySelector($sPropertySelector);

        // 3. configure
        $aParentEntitySelectionConfigs = [(object) array('type' => $sInstanceType, 'id' => $nInstanceId, 'property' => $sPropertyName)];

        // 4. create and connect
        $result = Mimoto::service('data')->createAndConnect($sEntityName, $aParentEntitySelectionConfigs);

        // 5. register
        $eNewEntity = $result->entity;

        // 6. output
        return Mimoto::service('messages')->response("New entity of type `$sEntityName` with id=`".$eNewEntity->getId()."` created and connected to `$sPropertySelector`");
    }

    public function clear(Application $app, Request $request)
    {
        // 1. load and convert
        $data = MimotoDataUtils::decodePostData($request->get('data'));

        // 1. register
        $sPropertySelector = $data->sPropertySelector;

        // 2. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);
        $sPropertyName = MimotoDataUtils::getPropertyFromFromEntityPropertySelector($sPropertySelector);

        // 4. load
        $eInstance = Mimoto::service('data')->get($sInstanceType, $nInstanceId);

        // 5. clear property
        $this->clearProperty($eInstance, $sPropertyName);

        // 6. store
        Mimoto::service('data')->store($eInstance);

        // 7. output
        return Mimoto::service('messages')->response("Value of property `$sPropertySelector` is cleared.");
    }


    public function update(Application $app, Request $request)
    {
        // 1. load and convert
        $data = MimotoDataUtils::decodePostData($request->get('data'));

        // 1. register
        $sPropertySelector = $data->sPropertySelector;

        // 2. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);
        $sPropertyName = MimotoDataUtils::getPropertyFromFromEntityPropertySelector($sPropertySelector);

        // 4. load
        $eEntity = Mimoto::service('data')->get($sInstanceType, $nInstanceId);

        // 5. clear
        switch ($eEntity->getPropertyType($sPropertyName))
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                //Mimoto

                // strip
                if (empty(MimotoDataUtils::getFormattingOptionsForEntityProperty($sInstanceType, $sPropertyName)))
                {
                    $data->newValue = strip_tags($data->newValue);
                }

                $eEntity->setValue($sPropertyName, $data->newValue);
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                //$eEntity->setValue($sPropertyName, null);
                break;
        }

        // 6. store
        Mimoto::service('data')->store($eEntity);

        // 7. output
        return Mimoto::service('messages')->response("Value of property `$sPropertySelector` has been updated.");
    }




    private function clearProperty($eInstance, $sPropertyName)
    {
        // 1. clear
        switch ($eInstance->getPropertyType($sPropertyName))
        {
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                $eInstance->setValue($sPropertyName, '');
                break;

            case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:
            case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                $eInstance->setValue($sPropertyName, null);
                break;
        }
    }
}

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
        $options = (!empty($data->options)) ? $data->options : (object) array();


        // ------- Multi option add - manual form selection


        if (!is_string($sFormName) && is_array($sFormName))
        {
            // register
            $aFormNames = $sFormName;

            // init
            $sOutput  = '<div class="MimotoCMS_layout_Selection">';
            $sOutput .= '<h1 class="MimotoCMS_layouts_Selection-title">Make a selection</h1>';
            $sOutput .= '<div class="MimotoCMS_layout_Selection-container">';

            $nFormCount = count($aFormNames);
            for ($nFormIndex = 0; $nFormIndex < $nFormCount; $nFormIndex++)
            {
                // register
                $option = $aFormNames[$nFormIndex];

                if ((!is_array($option) && !empty($option->label)) || (is_array($option) && !empty($option['label'])))
                {
                    $sLabel = (!is_array($option) && !empty($option->label)) ? $option->label : $option['label'];
                }
                else
                {
                    if ((!is_array($option) && !empty($option->form)) || (is_array($option) && !empty($option['form'])))
                    {

                        $sLabel = (!is_array($option) && !empty($option->form)) ? $option->form : $option['form'];
                    }
                    else
                    {
                        $sLabel = $option;
                    }
                }

                if ((!is_array($option) && !empty($option->form)) || (is_array($option) && !empty($option['form'])))
                {
                    $sForm = (!is_array($option) && !empty($option->form)) ? $option->form : $option['form'];
                }
                else
                {
                    if ((!is_array($option) && !empty($option->label)) || (is_array($option) && !empty($option['label'])))
                    {
                        $sForm = (!is_array($option) && !empty($option->label)) ? $option->label : $option['label'];
                    }
                    else
                    {
                        $sForm = $option;
                    }
                }

                $instructions = (object) array(
                    'form' => $sForm,
                    'propertyType' => 'collection'
                );

                $sDirective = 'data-mimoto-add="'.$sPropertySelector.'|'.htmlentities(json_encode($instructions), ENT_QUOTES, 'UTF-8').'"';

                $sOutput .= "<div class=\"MimotoCMS_components_selection_SelectableItem\" style=\"cursor:pointer\" $sDirective>$sLabel</div>";
            }

            // close
            $sOutput .= '</div></div>';

            // send
            return $sOutput;
        }


        // ------- Multi option add (end)


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


        // I. load
        $eParent = Mimoto::service('entityConfig')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $eForm);


        // 6. verify
        if ($bManualSave)
        {
            // a. init
            $eNewEntity = null;


            // -----


            // IV. verify
            if (isset($options->values))
            {
                $eNewEntity = Mimoto::service('data')->create($eParent->get('name'));

                // set default values
                foreach ($options->values as $sPropertyName => $value)
                {
                    if ($eNewEntity->hasProperty($sPropertyName))
                    {
                        if ($eNewEntity->getPropertyType($sPropertyName) == MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE)
                        {
                            $eNewEntity->set($sPropertyName, $value);
                        }
                    }
                }
            }


            // -----


            // b. setup
            $aActions['onCreatedConnectTo'] = $sPropertySelector;
        }
        else
        {
            // I. configure
            $aParentEntitySelectionConfigs = [(object) array('type' => $sInstanceType, 'id' => $nInstanceId, 'property' => $sPropertyName)];

            // II. load
            $result = Mimoto::service('data')->createAndConnect($eParent->get('name'), $aParentEntitySelectionConfigs, $options);

            // III. register
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
        $options = (!empty($data->options)) ? $data->options : (object) array();

        // 2. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sEntitySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sEntitySelector);

        // 3. load
        $eEntity = Mimoto::service('data')->get($sInstanceType, $nInstanceId);

        // 4. remove
        Mimoto::service('data')->delete($eEntity, $nConnectionId, (isset($options->forceDelete) && $options->forceDelete) ? true : false);

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

        // 8. add label
        $popup->setVar('sPopupLabel', (isset($options->popupLabel)) ? $options->popupLabel : 'Select an item');

        // 9. fill
        $popup->fillContainer('selection', $aInstances, 'MimotoCMS_components_selection_SelectableItem', $optionsForTemplate);

        // 10. output
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
        $options = (!empty($data->options)) ? $data->options : (object) array();

        // 2. register
        $sPropertySelector = $data->sPropertySelector;
        $sEntityName = $data->sEntityName;

        // 3. extract
        $sInstanceType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sPropertySelector);
        $nInstanceId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sPropertySelector);
        $sPropertyName = MimotoDataUtils::getPropertyFromFromEntityPropertySelector($sPropertySelector);

        // 4. configure
        $aParentEntitySelectionConfigs = [(object) array('type' => $sInstanceType, 'id' => $nInstanceId, 'property' => $sPropertyName)];

        // 5. create and connect
        $result = Mimoto::service('data')->createAndConnect($sEntityName, $aParentEntitySelectionConfigs, $options);

        // 6. register
        $eNewEntity = $result->entity;

        // 7. output
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

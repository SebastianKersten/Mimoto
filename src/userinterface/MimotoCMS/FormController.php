<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Aimless\AimlessComponentViewModel;
use Mimoto\Core\entities\InputOption;
use Mimoto\Data\DataFormattingUtils;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;

// Symfony classes
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

// Silex classes
use Silex\Application;


/**
 * FormsController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormController
{

    public function formNew(Application $app, $nEntityId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form');

        // 3. setup content
        $component->addForm(
            CoreConfig::COREFORM_FORM,
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ENTITY.'.'.$nEntityId.'.forms',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $popup->render();
    }

    public function formAutogenerate(Application $app, $nEntityId)
    {
        // 1. get name (check name)
        // 2. get all forms

        // load data
        $eEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_ENTITY, $nEntityId);

        // register
        $sEntityName = $eEntity->getValue('name');

        // validate
        if (empty($eEntity)) return $app->redirect("/mimoto.cms/entities/".$nEntityId.'/edit');

        // load all
        $aExistingForms = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_FORM]);


        // init
        $sNewFormName = $sEntityName;

        // search
        $bNewNameDecided = false;
        $nNameIndex = 0;
        while(!$bNewNameDecided)
        {
            // init
            $bNewNameAlreadyExists = false;

            // search
            $nFormCount = count($aExistingForms);
            for ($nFormIndex = 0; $nFormIndex < $nFormCount;$nFormIndex++)
            {
                // register
                $eExistsingForm = $aExistingForms[$nFormIndex];

                // verify
                if ($eExistsingForm->getValue('name') == $sNewFormName)
                {
                    // 1. en nu? skip en ga naar volgende
                    $bNewNameAlreadyExists = true;
                    break;
                }
            }

            if ($bNewNameAlreadyExists)
            {
                // update
                $nNameIndex++;

                // compose
                $sNewFormName = $sEntityName.' ('.$nNameIndex.')';
            }
            else
            {
                // toggle
                $bNewNameDecided = true;
            }
        }


        // init
        $eNewForm = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM);

        // setup
        $eNewForm->setValue('name', $sNewFormName);



        // create
        $eField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);

        // setup
        $eField->setValue('title', DataFormattingUtils::lowerCameCase2Label($sEntityName));
        $eField->setValue('subtitle', 'Auto-generated form');
        $eField->setValue('description', "This form has been created by Mimoto's auto-generation feature based on the entity's properties on ".date('d F Y H:i:s').". Adjust, add, remove or change the fields as you feel fit!");

        // store
        Mimoto::service('data')->store($eField);

        // connect
        $eNewForm->addValue('fields', $eField);

        // create & connect group start
        $eField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        Mimoto::service('data')->store($eField);
        $eNewForm->addValue('fields', $eField);


        // register
        $aProperties = $eEntity->getValue('properties');

        // parse fields
        $nPropertyCount = count($aProperties);
        for ($nPropertyIndex = 0; $nPropertyIndex < $nPropertyCount; $nPropertyIndex++)
        {
            // register
            $eProperty = $aProperties[$nPropertyIndex];

            // register
            $sPropertyName = $eProperty->getValue('name');
            $aPropertySettings = $eProperty->getValue('settings');


            // init
            $eInputField = null;

            // togglew
            switch($eProperty->getValue('type'))
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                    // parse settings
                    $nSettingCount = count($aPropertySettings);
                    for ($nSettingIndex = 0; $nSettingIndex < $nSettingCount;$nSettingIndex++)
                    {
                        // register
                        $eSetting = $aPropertySettings[$nSettingIndex];

                        // toggle
                        switch($eSetting->getValue('key'))
                        {
                            case EntityConfig::SETTING_VALUE_TYPE:

                                switch($eSetting->getValue('type'))
                                {
                                    case MimotoEntityPropertyValueTypes::VALUETYPE_TEXT:

                                        switch($eSetting->getValue('value'))
                                        {
                                            case CoreConfig::DATA_VALUE_TEXTLINE:

                                                $eInputField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
                                                break;

                                            case CoreConfig::DATA_VALUE_TEXTBLOCK:

                                                $eInputField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK);
                                                break;

                                            case MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME:

                                                $eInputField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_DATEPICKER);
                                                break;

                                            case MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD:

                                                $eInputField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_PASSWORD);
                                                break;
                                        }

                                        break;
                                }

                                break;
                        }
                    }

                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                    switch($eProperty->getValue('subtype'))
                    {
                        case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_IMAGE:

                            $eInputField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_IMAGE);
                            break;

                        case MimotoEntityPropertyTypes::PROPERTY_SUBTYPE_VIDEO:

                            $eInputField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_VIDEO);
                            break;
                    }

                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                    //$eInputField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_LIST);

                    // 1. connects forms if present
                    // 2. present options or ask to auto-generate child-item forms

                    break;
            }


            if (!empty($eInputField))
            {

                // todo primary field (er hoeft niet altijd een label te zijn
                if ($eInputField->hasProperty('label'))
                {
                    $eInputField->setValue('label', DataFormattingUtils::lowerCameCase2Label($sPropertyName));
                }


                // connect property to field value
                $eConnectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $eConnectedEntityProperty->setId($eProperty->getId());
                $eInputField->setValue('value', $eConnectedEntityProperty);

                // store
                Mimoto::service('data')->store($eInputField);

                // connect
                $eNewForm->addValue('fields', $eInputField);
            }
        }


        // create & connect group end
        $eField = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        Mimoto::service('data')->store($eField);
        $eNewForm->addValue('fields', $eField);


        // store
        Mimoto::service('data')->store($eNewForm);

        // connect
        $eEntity->addValue('forms', $eNewForm);

        // store
        Mimoto::service('data')->store($eEntity);

        // output
        return Mimoto::service('messages')->response((object) array('result' => 'Form created! '.date("Y.m.d H:i:s")), 200);
    }

    public function formView(Application $app, $nFormId)
    {
        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eForm = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 3. validate data
        if (empty($eForm)) return $app->redirect("/mimoto.cms/forms");

        // 4. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_forms_FormDetail', $eForm);

        // 5. setup page
//        $page->setVar('pageTitle', array(
//                (object)array(
//                    "label" => 'Forms',
//                    "url" => '/mimoto.cms/forms'
//                ),
//                (object)array(
//                    "label" => '<span data-mimoto-value="' . CoreConfig::MIMOTO_FORM . '.' . $eForm->getId() . '.name">' . $eForm->getValue('name') . '</span>',
//                    "url" => '/mimoto.cms/form/' . $eForm->getId() . '/view'
//                )
//            )
//        );

        // 6. connect
        $page->addComponent('content', $component);

        // 7. output
        return $page->render();
    }

    public function formFieldNew_fieldTypeSelector(Application $app, $nFormId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_forms_FormDetail_TypeSelector');


        // ----------


        // load
        $aInputTypesAll = Mimoto::service('entityConfig')->find(['typeOf' => CoreConfig::MIMOTO_FORM_INPUT]);

        // filter
        $aInputTypes = [];
        $nInputCount = count($aInputTypesAll);
        for ($nInputIndex = 0; $nInputIndex < $nInputCount; $nInputIndex++)
        {
            if ($aInputTypesAll[$nInputIndex]->id != CoreConfig::MIMOTO_FORM_INPUT)
            {
                $aInputTypes[] = $aInputTypesAll[$nInputIndex];
            }
        }


        // load
        $aOutputTypes = Mimoto::service('entityConfig')->find(['typeOf' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE]);

        // load
        $aLayoutTypes = Mimoto::service('entityConfig')->find(['typeOf' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART]);

        $aMoreLayoutTypes = Mimoto::service('entityConfig')->find(['typeOf' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND]);
        $nLayoutCount = count($aMoreLayoutTypes);
        for($nLayoutIndex = 0; $nLayoutIndex < $nLayoutCount; $nLayoutIndex++)
        {
            $aLayoutTypes[] = $aMoreLayoutTypes[$nLayoutIndex];
        }

        $aMoreLayoutTypes = Mimoto::service('entityConfig')->find(['typeOf' => CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER]);
        $nLayoutCount = count($aMoreLayoutTypes);
        for($nLayoutIndex = 0; $nLayoutIndex < $nLayoutCount; $nLayoutIndex++)
        {
            $aLayoutTypes[] = $aMoreLayoutTypes[$nLayoutIndex];
        }


        // register
        $component->setVar('nFormId', $nFormId);
        $component->setVar('aInputTypes', $aInputTypes);
        $component->setVar('aLayoutTypes', $aLayoutTypes);
        $component->setVar('aOutputTypes', $aOutputTypes);



        // #todo
        // -----------------------------
        // 1. collect items (fixed set?)
        // 5. eigen entities
        // 6. setup item
        // 7. hardcoded (_Mimoto_form_input_textline -> textline-form)


        // ----------


        // 3. connect
        $popup->addComponent('content', $component);

        // 4. output
        return $popup->render();
    }

    public function formFieldNew_fieldForm(Application $app, $nFormId, $nFormFieldTypeId)
    {
        // 1. init popup
        $popup = Mimoto::service('output')->createPopup();

        // 2. load
        $eFormForEditing = Mimoto::service('input')->getFormByName(Mimoto::service('input')->getCoreFormByEntityTypeId($nFormFieldTypeId));

        // 3. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_PopupForm', $eFormForEditing);

        // 4. auto create and connect
        $eInputField = Mimoto::service('data')->create($nFormFieldTypeId);

        Mimoto::service('data')->store($eInputField);
        $eForm = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $nFormId);
        $eForm->addValue('fields', $eInputField);
        Mimoto::service('data')->store($eForm);

        // 5. content
        $component->addForm(
            Mimoto::service('input')->getCoreFormByEntityTypeId($nFormFieldTypeId),
            $eInputField,
            [
                //'onCreatedConnectTo' => CoreConfig::MIMOTO_FORM . '.' . $nFormId . '.fields',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 6. inject
        $popup->addComponent('content', $component);

        // 7. output
        return $component->render();
    }

    public function formFieldEdit(Application $app, $nFormFieldTypeId, $nFormFieldId)
    {
        // 1. init popup
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eFormField = Mimoto::service('data')->get($nFormFieldTypeId, $nFormFieldId);

        // 3. validate data
        if (empty($eFormField)) return $app->redirect("/mimoto.cms/forms");

        // 4. request
        $sFormName = Mimoto::service('input')->getCoreFormByEntityTypeId($eFormField->getEntityTypeName());

        // 5. get parent form
        $eParentForm = Mimoto::service('entityConfig')->getParent(CoreConfig::MIMOTO_FORM, CoreConfig::MIMOTO_FORM.'--fields', $eFormField);

        // 6. load
        $eForm = Mimoto::service('input')->getFormByName($sFormName, $eFormField);

        // 7. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_PopupForm', $eForm);

        // 8. setup content
        $component->addForm(
            $sFormName,
            $eFormField,
            [
                'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/form/'.$eParentForm->getId().'/view']]
            ]
        );

        // 9. connect
        $page->addComponent('content', $component);

        // 10. output
        return $page->render();
    }

    public function formFieldDelete(Application $app, $nFormFieldTypeId, $nFormFieldId)
    {
        // #todo add transaction


        // 1. load
        $eFormField = Mimoto::service('data')->get($nFormFieldTypeId, $nFormFieldId);

        // 2. cleanup
        Mimoto::service('data')->delete($eFormField);

        // 3. send
        return Mimoto::service('messages')->response((object) array('result' => 'FormField deleted! '.date("Y.m.d H:i:s")), 200);
    }

    public function formFieldListGetOptions(Application $app, $sInputFieldType, $sInputFieldId, $sPropertySelector)
    {
        // 1. validate
        if (!MimotoDataUtils::validatePropertySelector($sPropertySelector)) die('Invalid property selector');

        // 2. load
        $formField = Mimoto::service('input')->getFormFieldByFieldId($sInputFieldType, $sInputFieldId);

        // 3. validate
        if (empty($formField)) return Mimoto::service('messages')->response('Formfield not found', 400);

        // 4. load
        $aOptions = $formField->getValue('options');

        // 5. compose
        $response = (object) array(
            'optionCount' => count($aOptions),
        );

        // 6. add information
        if (count($aOptions) == 1) $response->optionId = $aOptions[0]->getId();

        // 7. reply
        return Mimoto::service('messages')->response($response, 200);
    }

    public function formFieldListShowOptions(Application $app, $sInputFieldType, $sInputFieldId, $sPropertySelector)
    {
        // validate
        if (!MimotoDataUtils::validatePropertySelector($sPropertySelector)) die('Invalid property selector');

        // load
        $formField = Mimoto::service('input')->getFormFieldByFieldId($sInputFieldType, $sInputFieldId);

        // 2. validate
        if (empty($formField)) return $app->redirect("/mimoto.cms/forms");

        // 1. welk formulierveld hort hierbij? get formid en formselector
        $aOptions = $formField->getValue('options');

        $sOutput = '<div><b>Choose a form:</b><br><br>';


        if ($sInputFieldType == CoreConfig::MIMOTO_FORM_INPUT_LIST)
        {
            $nOptionCount = count($aOptions);
            for ($nOptionIndex = 0; $nOptionIndex < $nOptionCount; $nOptionIndex++)
            {
                // register
                $option = $aOptions[$nOptionIndex];


                if ($option->getValue('type') == InputOption::FORM)
                {
                    // output
                    $sOutput .= '<div class="MimotoCMS_modules_ListItem" style="margin-bottom:1px;">';
                    $sOutput .= '    <div class="MimotoCMS_modules_ListItem-content">';
                    $sOutput .= '        <div class="MimotoCMS_modules_ListItem-info">';
                    $sOutput .= '           <div class="MimotoCMS_modules_ListItem-label"><a href="#" style="color:#000000;" onclick="MimotoCMS.formFieldListItemAddAfterOptionSelected(\''.$sInputFieldType.'\', \''.$sInputFieldId.'\', \''.$sPropertySelector.'\', '.$option->getId().');">'.$option->getValue('label').'</a></div>';
                    $sOutput .= '        </div>';
                    $sOutput .= '    </div>';
                    $sOutput .= '</div>';
                }
            }

            $sOutput .= '</div>';

            // exit
            return $sOutput;
        }
    }

    public function formFieldListItemAdd(Application $app, Request $request, $sInputFieldType, $sInputFieldId, $sPropertySelector, $sOptionId)
    {
        // 1. validate
        if (!MimotoDataUtils::validatePropertySelector($sPropertySelector)) die('Invalid property selector');

        // 2. load
        $formField = Mimoto::service('input')->getFormFieldByFieldId($sInputFieldType, $sInputFieldId);

        // 3. validate
        if (empty($formField)) return $app->redirect("/mimoto.cms/forms");

        // 4. welk formulierveld hort hierbij? get formid en formselector
        $aOptions = $formField->getValue('options');


        // ---

        // 5. init popup
        $output = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));


        // ---


        // init
        $option = null;


        if (count($aOptions) == 1)
        {
            $option = $aOptions[0];
        }
        else
            if (count($aOptions) > 1 && !empty($sOptionId))
            {
                // init
                $bOptionFound = false;

                $nOptionCount = count($aOptions);
                for ($nOptionIndex = 0; $nOptionIndex < $nOptionCount; $nOptionIndex++)
                {
                    // register
                    $option = $aOptions[$nOptionIndex];

                    // verify
                    if ($option->getId() == $sOptionId)
                    {
                        $bOptionFound = true;
                        break;
                    }
                }

                if (!$bOptionFound)
                {
                    Mimoto::service('log')->error("List option not found", "On adding a new item to a list, the requested list option '$sOptionId' wasn't found", true);
                }


                // 1. load form (or selection) based on option id


            }


        // validate
        if (empty($option)) Mimoto::service('log')->error("No options selected", "Please select a valid options for adding items to this list", true);


        // ---


        // 1. read
        $form = $option->getValue('form');

        // 2. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form', $form);

        // 3. setup navigation
        if (!empty($request->get('Mimoto_referrer'))) $component->setVar('onClickFormMenuButtonOk', (object) array('menu' => ['onClick' => ['loadPage' => $request->get('Mimoto_referrer')]]));


        // --- show form


        // 1. read
        $eParent = Mimoto::service('entityConfig')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $form);

        // 2. set
        $sEntityName = $eParent->getValue('name');

        // 3. auto create
        $result = Mimoto::service('data')->createAndConnect($sEntityName, [MimotoDataUtils::convertSelector($sPropertySelector)]);

        // 4. prepare
        $response = (object) array(
            'instanceType' => $result->entity->getEntityTypeName(),
            'instanceId' => $result->entity->getId(),
            'connectionId' => $result->connection->getId()
        );

        // 5. output
        return Mimoto::service('messages')->response($response, 200);
    }

    public function formFieldListItemEdit(Application $app, Request $request, $sInputFieldType, $sInputFieldId, $sPropertySelector, $sInstanceType, $sInstanceId)
    {
        //Mimoto::output($sInputFieldType, $sInputFieldId);

        // 1. init page
        $page = Mimoto::service('output')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eListItem = Mimoto::service('data')->get($sInstanceType, $sInstanceId);

        // 3. validate
        if (empty($eListItem)) return $app->redirect("/mimoto.cms");


        // init
        $form = null;

        // toggle
        switch($sInstanceType)
        {
            case CoreConfig::MIMOTO_FORM_FIELD_OPTION:

                $form = Mimoto::service('input')->getFormByName(CoreConfig::COREFORM_INPUTOPTION);
                break;

            default:

                // 4. load form field
                $eFormField = Mimoto::service('input')->getFormFieldByFieldId($sInputFieldType, $sInputFieldId);

                // 5. validate
                if (empty($eFormField)) Mimoto::error('Not here'); //return $app->redirect("/mimoto.cms");

                // 5. read options
                $aFieldOptions = $eFormField->getValue('options');

                // search best option
                $nFieldOptionCount = count($aFieldOptions);
                for ($nFieldOptionIndex = 0; $nFieldOptionIndex < $nFieldOptionCount; $nFieldOptionIndex++)
                {
                    // register
                    $eFieldOption = $aFieldOptions[$nFieldOptionIndex];

                    switch($eFieldOption->getValue('type'))
                    {
                        case InputOption::VALUE:

                            $form = Mimoto::service('input')->getFormByName(CoreConfig::COREFORM_INPUTOPTION);
                            break;

                        case InputOption::FORM:

                            // read
                            $eConnectedForm = $eFieldOption->getValue('form');

                            // find
                            $eConnectedEntity = Mimoto::service('entityConfig')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $eConnectedForm);

                            // verify
                            if ($eConnectedEntity->getValue('name') == $sInstanceType)
                            {
                                // register
                                $form = $eConnectedForm;
                                break 2;
                            }
                            break;

                        case InputOption::SELECTION:



                            break;

                        default:

                            Mimoto::error("Congratulation! You found a part that hasn't been implemented yet. Your request needs additional code!");
                    }
                }

                break;
        }



        if (empty($form)) return 'Please select your edit strategy ... [finish this code!]';


        // 3. create content
        $component = Mimoto::service('output')->createComponent('MimotoCMS_layout_Form', $form);

        // 6. setup navigation
        if (!empty($request->get('Mimoto_referrer'))) $component->setVar('onClickFormMenuButtonOk', (object) array('menu' => ['onClick' => ['loadPage' => $request->get('Mimoto_referrer')]]));

        // 4. setup content
        $component->addForm(
            $form->getValue('name'),
            $eListItem,
            [
                // This is just wrong! Use [returnPage] instead ---- 'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/formfield/'.$sInputFieldType.'/'.$sInputFieldId.'/edit']]
            ]
        );

        // 5. connect
        $page->addComponent('content', $component);

        // 6. render and send
        return $page->render();
    }



    public function formFieldListItemRemove(Application $app, $sInputFieldType, $sInputFieldId, $sPropertySelector, $sInstanceType, $sInstanceId)
    {
        // load
        $eListItem = Mimoto::service('data')->get($sInstanceType, $sInstanceId);

        // delete
        Mimoto::service('data')->delete($eListItem);

        // output
        return Mimoto::service('messages')->response((object) array('result' => 'Item removed from list! '.date("Y.m.d H:i:s")), 200);
    }

    public function updateSortindex(Application $app, $sPropertySelector, $nConnectionId, $nOldIndex, $nNewIndex)
    {
        // 1. split
        $aPropertySelectorParts = explode('.', $sPropertySelector);

        // 2. load
        $eParent = Mimoto::service('data')->get($aPropertySelectorParts[0], $aPropertySelectorParts[1]);

        // 3. validate
        if (!($eParent->hasProperty($aPropertySelectorParts[2]) && $eParent->getPropertyType($aPropertySelectorParts[2]) == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION))
        {
            // 3a. output
            return Mimoto::service('messages')->response((object) array('result' => 'I encountered a problem while adjusting the sortindex! '.date("Y.m.d H:i:s")), 400);
        }


        // 4. register
        $aConnections = $eParent->getValue($aPropertySelectorParts[2], true);

        // 5. move
        array_splice($aConnections, $nNewIndex, 0, array_splice($aConnections, $nOldIndex, 1));

        // 6. fix sortindex
        $nConnectionCount = count($aConnections);
        for ($nConnectionIndex = 0; $nConnectionIndex < $nConnectionCount; $nConnectionIndex++)
        {
            // register
            $connection = $aConnections[$nConnectionIndex];

            // update
            $connection->setSortindex($nConnectionIndex);
        }

        // 7. store
        Mimoto::service('data')->store($eParent);

        // 8. output
        return Mimoto::service('messages')->response((object) array('result' => 'Sortindex altered! '.date("Y.m.d H:i:s")), 200);
    }
}

<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Core\entities\InputOption;
use Mimoto\EntityConfig\EntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;

// Symfony classes
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

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
        $aExistingForms = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_FORM]);


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
                                        }

                                        break;
                                }

                                break;
                        }
                    }

                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                    break;
            }


            if (!empty($eInputField))
            {

                // todo primary field (er hoeft niet altijd een label te zijn
                $eInputField->setValue('label', $sPropertyName);

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


        // store
        Mimoto::service('data')->store($eNewForm);

        // connect
        $eEntity->addValue('forms', $eNewForm);

        // store
        Mimoto::service('data')->store($eEntity);


        Mimoto::error($sNewFormName);




        // output
        Mimoto::service('messages')->response((object) array('result' => 'For created! '.date("Y.m.d H:i:s")), 200);
    }

    public function formView(Application $app, $nFormId)
    {
        // 1. init page
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eForm = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 3. validate data
        if (empty($eForm)) return $app->redirect("/mimoto.cms/forms");

        // 4. create content
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_forms_FormDetail', $eForm);

        // 5. setup page
        $page->setVar('pageTitle', array(
                (object)array(
                    "label" => 'Forms',
                    "url" => '/mimoto.cms/forms'
                ),
                (object)array(
                    "label" => '"<span data-aimless-value="' . CoreConfig::MIMOTO_FORM . '.' . $eForm->getId() . '.name">' . $eForm->getValue('name') . '</span>"',
                    "url" => '/mimoto.cms/form/' . $eForm->getId() . '/view'
                )
            )
        );

        // 6. connect
        $page->addComponent('content', $component);

        // 7. output
        return $page->render();
    }

    public function formEdit(Application $app, $nFormId)
    {
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. load data
        $eForm = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 3. validate data
        if (empty($eForm)) return $app->redirect("/mimoto.cms/forms");

        // 4. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 5. setup content
        $component->addForm(
            CoreConfig::COREFORM_FORM,
            $eForm,
            [
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 6. connect
        $popup->addComponent('content', $component);

        // 7. output
        return $component->render();
    }

    public function formDelete(Application $app, $nFormId)
    {
        // 1. load
        $eForm = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 2. delete
        Mimoto::service('data')->delete($eForm);

        // 3. send
        return Mimoto::service('messages')->response((object) array('result' => 'Form deleted! '.date("Y.m.d H:i:s")), 200);
    }

    public function formFieldNew_fieldTypeSelector(Application $app, $nFormId)
    {
        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. create content
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_forms_FormDetail_TypeSelector');


        // ----------


        // load
        $aInputTypesAll = Mimoto::service('config')->find(['typeOf' => CoreConfig::MIMOTO_FORM_INPUT]);

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
        $aOutputTypes = Mimoto::service('config')->find(['typeOf' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE]);

        // load
        $aLayoutTypes = Mimoto::service('config')->find(['typeOf' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART]);

        $aMoreLayoutTypes = Mimoto::service('config')->find(['typeOf' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND]);
        $nLayoutCount = count($aMoreLayoutTypes);
        for($nLayoutIndex = 0; $nLayoutIndex < $nLayoutCount; $nLayoutIndex++)
        {
            $aLayoutTypes[] = $aMoreLayoutTypes[$nLayoutIndex];
        }

        $aMoreLayoutTypes = Mimoto::service('config')->find(['typeOf' => CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER]);
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
        $popup = Mimoto::service('aimless')->createPopup();

        // 2. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 3. content
        $component->addForm(
            Mimoto::service('forms')->getCoreFormByEntityTypeId($nFormFieldTypeId),
            null,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_FORM . '.' . $nFormId . '.fields',
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 4. connect
        $popup->addComponent('content', $component);

        // 5. output
        return $component->render();
    }

    public function formFieldEdit(Application $app, $nFormFieldTypeId, $nFormFieldId)
    {
        // 1. init popup
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eFormField = Mimoto::service('data')->get($nFormFieldTypeId, $nFormFieldId);

        // 3. validate data
        if (empty($eFormField)) return $app->redirect("/mimoto.cms/forms");

        // 4. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 5. get parent form
        $eParentForm = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_FORM, CoreConfig::MIMOTO_FORM.'--fields', $eFormField);

        // 6. setup content
        $component->addForm(
            Mimoto::service('forms')->getCoreFormByEntityTypeId($eFormField->getEntityTypeName()),
            $eFormField,
            [
                'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/form/'.$eParentForm->getId().'/view']]
            ]
        );

        // 7. connect
        $page->addComponent('content', $component);

        // 9. output
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

    public function formFieldListItemAdd(Application $app, $sInputFieldType, $sInputFieldId, $sPropertySelector, $sOptionId = null)
    {

        // 1. init popup
        $popup = Mimoto::service('aimless')->createPopup();


        // validate
        if (!MimotoDataUtils::validatePropertySelector($sPropertySelector)) die('Invalid property selector');

        // load
        $formField = Mimoto::service('forms')->getFormFieldByFieldId($sInputFieldType, $sInputFieldId);

        // 2. validate
        if (empty($formField)) return $app->redirect("/mimoto.cms/forms");

        // 1. welk formulierveld hort hierbij? get formid en formselector
        $aOptions = $formField->getValue('options');



        // ---

        // init
        $option = null;

        if (count($aOptions) == 1)
        {
            // register
            $option = $aOptions[0];
        }
        else if (count($aOptions) > 1 && !empty($sOptionId))
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
        else if (count($aOptions) > 1 && empty($sItemId))
        {

            echo '<b>Choose a form:</b><br><br>';


            if ($sInputFieldType == CoreConfig::MIMOTO_FORM_INPUT_LIST)
            {
                $nOptionCount = count($aOptions);
                for ($nOptionIndex = 0; $nOptionIndex < $nOptionCount; $nOptionIndex++)
                {
                    // register
                    $option = $aOptions[$nOptionIndex];


                    if ($option->getValue('type') == InputOption::FORM)
                    {
                        // compose
                        $sURL = '/mimoto.cms/formfield/'.$sInputFieldType.'/'.$sInputFieldId.'/add/'.$sPropertySelector.'/'.$option->getId();

                        // output
                        echo '- <a href="#" style="color:#000000;" onclick="Mimoto.popup.replace(\''.$sURL.'\');">'.$option->getValue('label').'</a><br>';
                    }
                }

                // exit
                return '';
            }
        }
        else
        {
            Mimoto::service('log')->error("No list options set", "Please add options to the list '$sInputFieldId' in order to add items to it", true);
        }


        // validate
        if (empty($option)) Mimoto::service('log')->error("No options selected", "Please select a valid options for adding items to this list", true);


        // --- show form

        // read
        $form = $option->getValue('form');


        // 3. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 4. setup content
        $component->addForm(
            $form->getValue('name'),
            null,
            [
                //'onCreatedReturnToClient' => true,
                'onCreatedConnectTo' => $sPropertySelector,
                'response' => ['onSuccess' => ['closePopup' => true]]
            ]
        );

        // 5. connect
        $popup->addComponent('content', $component);

        // 6. render and send
        return $popup->render();
    }

//    public function formFieldItemEdit(Application $app, $nFormFieldTypeId, $nFormFieldId, $sPropertySelector, $sItemId = null)
//    {
//
//    }

    public function formFieldListItemEdit(Application $app, $sInputFieldType, $sInputFieldId, $sPropertySelector, $sInstanceType, $sInstanceId)
    {
        // 1. init page
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eInstance = Mimoto::service('data')->get($sInstanceType, $sInstanceId);

        // 3. load form field
        $formField = Mimoto::service('forms')->getFormFieldByFieldId($sInputFieldType, $sInputFieldId);

        // 4. validate
        if (empty($formField)) return $app->redirect("/mimoto.cms/forms");

        // 5. read options
        $aOptions = $formField->getValue('options');



        // 1. find best option


        // init
        $form = null;



        // 6. find best options
        $nOptionCount = count($aOptions);
        for ($nOptionIndex = 0; $nOptionIndex < $nOptionCount; $nOptionIndex++)
        {
            // register
            $option = $aOptions[$nOptionIndex];

            switch($option->getValue('type'))
            {
                case InputOption::VALUE:

                    // read
                    $form = Mimoto::service('forms')->getFormByName(CoreConfig::COREFORM_INPUTOPTION);
                    break;

                case InputOption::FORM:

                    // read
                    $form = $option->getValue('form');

                    if ($form->getValue('name') == $sInstanceType)
                    {
                        break 2;
                    }

                    break;

                case InputOption::SELECTION:

                    // 1. ??

                default:

                    return 'Something went wrong here';
            }
        }


        if (empty($form)) return 'Please select your edit strategy ... [finish this code!]';


        // 3. create content
        $component = Mimoto::service('aimless')->createComponent('MimotoCMS_layout_Form');

        // 4. setup content
        $component->addForm(
            $form->getValue('name'),
            $eInstance,
            [
                'response' => ['onSuccess' => ['loadPage' => '/mimoto.cms/formfield/'.$sInputFieldType.'/'.$sInputFieldId.'/edit']]
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

        // split
        $aParentParts = explode('.', $sPropertySelector);

        // load
        $eParent = Mimoto::service('data')->get($aParentParts[0], $aParentParts[1]);

        // remove
        $eParent->removeValue($aParentParts[2], $eListItem);

        // store
        Mimoto::service('data')->store($eParent);

        // output
        return Mimoto::service('messages')->response((object) array('result' => 'Item removed from list! '.date("Y.m.d H:i:s")), 200);
    }

}

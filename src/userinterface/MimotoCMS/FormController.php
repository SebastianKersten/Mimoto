<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
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

        // 3. render and send
        return $popup->render();
    }

    public function formView(Application $app, $nFormId)
    {
        // 1. init page
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eForm = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 3. validate data
        if ($eForm === false) return $app->redirect("/mimoto.cms/forms");

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
        if ($eForm === false) return $app->redirect("/mimoto.cms/forms");

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
        // 1. init page
        $page = Mimoto::service('aimless')->createPage(Mimoto::service('data')->get(CoreConfig::MIMOTO_ROOT, CoreConfig::MIMOTO_ROOT));

        // 2. load data
        $eFormField = Mimoto::service('data')->get($nFormFieldTypeId, $nFormFieldId);

        // 3. validate data
        if ($eFormField === false) return $app->redirect("/mimoto.cms/forms");

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

        // 8. setup page
        $page->setVar('pageTitle', array(
                (object)array(
                    "label" => 'todo',
                    "url" => '/mimoto.cms/todo'
                ),
                (object)array(
                    "label" => 'todo',
                    "url" => '/mimoto.cms/todo'
                )
            )
        );

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

    public function formFieldItemAddToList(Application $app, $nFormFieldTypeId, $nFormFieldId, $sPropertySelector, $sItemId = null)
    {
        // validate
        if (!MimotoDataUtils::validatePropertySelector($sPropertySelector)) die('Invalid property selector');

        // load
        $formField = Mimoto::service('forms')->getFormFieldByFieldId($nFormFieldId);

        // 2. validate
        if ($formField === false) return $app->redirect("/mimoto.cms/forms");

        // 1. welk formulierveld hort hierbij? get formid en formselector
        $aOptions = $formField->getValue('options');


        // ---

        // init
        $option = false;

        if (count($aOptions) == 1)
        {
            // register
            $option = $aOptions[0];
        }
        else if (count($aOptions) > 1 && !empty($sItemId))
        {
            // init
            $bOptionFound = false;

            $nOptionCount = count($aOptions);
            for ($nOptionIndex = 0; $nOptionIndex < $nOptionCount; $nOptionIndex++)
            {
                // register
                $option = $aOptions[$nOptionIndex];

                // verify
                if ($option->getId() == $sItemId)
                {
                    $bOptionFound = true;
                    break;
                }
            }

            if (!$bOptionFound)
            {
                Mimoto::service('log')->error("List option not found", "On adding a new item to a list, the requested list option '$sItemId' wasn't found", true);
            }
        }
        else if (count($aOptions) > 1 && empty($sItemId))
        {
            echo '1. load selector';
        }
        else
        {
            Mimoto::service('log')->error("No list options set", "Please add options to the list '$nFormFieldId' in order to add items to it", true);
        }


        // read
        $form = $option->getValue('form');

        // read
        $sFormName = $form->getValue('name');

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 5. setup
        $component->addForm($sFormName, null, [
            'onCreatedConnectTo' => $sPropertySelector,
            'response' => ['onSuccess' => ['closePopup' => true]]
            //'response' => ['onSuccess' => ['reloadPopup' => '/mimoto.cms/formfield/'.$nFormFieldTypeId.'/'.$nFormFieldId.'/edit']]
        ]);

        // 6. render and send
        return $component->render();
    }


    public function formFieldItemDelete(Application $app, $nFormFieldItemId)
    {
        // 1. load
        $eFormFieldItem = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM_INPUTOPTION, $nFormFieldItemId);

        // 2. delete
        Mimoto::service('data')->delete($eFormFieldItem);

        // 3. send
        return Mimoto::service('messages')->response((object) array('result' => 'FormFieldItem deleted! '.date("Y.m.d H:i:s")), 200);
    }

}

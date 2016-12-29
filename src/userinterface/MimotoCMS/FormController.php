<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
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

    public function viewFormOverview(Application $app)
    {
        // load
        $aEntities = $app['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_FORM]);

        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_forms_FormOverview');

        // setup
        $page->addSelection('forms', 'Mimoto.CMS_forms_FormOverview_ListItem', $aEntities);

        // setup page
        $page->setVar('pageTitle', array(
                (object)array(
                    "label" => 'Forms',
                    "url" => '/mimoto.cms/forms'
                )
            )
        );

        // output
        return $page->render();
    }

    public function formNew(Application $app)
    {
        // create dummy
        $entity = $app['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM);

        // 1. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_FORM_NEW, $entity);

        // 3. render and send
        return $component->render();
    }

    public function formView(Application $app, $nFormId)
    {
        // 1. load requested entity
        $form = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 2. check if entity exists
        if ($form === false) return $app->redirect("/mimoto.cms/forms");

        // 3. create component
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_forms_FormDetail', $form);

        // 4. setup component
        $page->setPropertyComponent('fields', 'Mimoto.CMS_forms_FormDetail-FormField');

        // setup page
        $page->setVar('pageTitle', array(
                (object)array(
                    "label" => 'Forms',
                    "url" => '/mimoto.cms/forms'
                ),
                (object)array(
                    "label" => '"<span mls_value="' . CoreConfig::MIMOTO_FORM . '.' . $form->getId() . '.name">' . $form->getValue('name') . '</span>"',
                    "url" => '/mimoto.cms/form/' . $form->getId() . '/view'
                )
            )
        );

        // 5. output
        return $page->render();
    }

    public function formEdit(Application $app, $nFormId)
    {
        // 1. load
        $form = $app['Mimoto.Data']->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 2. validate
        if ($form === false) return $app->redirect("/mimoto.cms/forms");

        // 3. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_FORM_EDIT, $form);

        // 5. render and send
        return $component->render();
    }

    public function formDelete(Application $app, Request $request, $nFormId)
    {
        // delete
//        $app['Mimoto.Config']->entityDelete($nEntityId);
//
//        // send
//        return new JsonResponse((object) array('result' => 'Entity deleted! '.date("Y.m.d H:i:s")), 200);
    }

    public function formFieldNew_fieldTypeSelector(Application $app, $nFormId)
    {
        // create
        $page = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_forms_FormDetail_TypeSelector');

        // load
        $aInputTypesAll = $app['Mimoto.Config']->find(['typeOf' => CoreConfig::MIMOTO_FORM_INPUT]);

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
        $aOutputTypes = $app['Mimoto.Config']->find(['typeOf' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE]);

        // load
        $aLayoutTypes = $app['Mimoto.Config']->find(['typeOf' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART]);

        $aMoreLayoutTypes = $app['Mimoto.Config']->find(['typeOf' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND]);
        $nLayoutCount = count($aMoreLayoutTypes);
        for($nLayoutIndex = 0; $nLayoutIndex < $nLayoutCount; $nLayoutIndex++)
        {
            $aLayoutTypes[] = $aMoreLayoutTypes[$nLayoutIndex];
        }

        $aMoreLayoutTypes = $app['Mimoto.Config']->find(['typeOf' => CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER]);
        $nLayoutCount = count($aMoreLayoutTypes);
        for($nLayoutIndex = 0; $nLayoutIndex < $nLayoutCount; $nLayoutIndex++)
        {
            $aLayoutTypes[] = $aMoreLayoutTypes[$nLayoutIndex];
        }


        // register
        $page->setVar('nFormId', $nFormId);
        $page->setVar('aInputTypes', $aInputTypes);
        $page->setVar('aLayoutTypes', $aLayoutTypes);
        $page->setVar('aOutputTypes', $aOutputTypes);



        // #todo
        // -----------------------------
        // 1. collect items (fixed set?)
        // 5. eigen entities
        // 6. setup item
        // 7. hardcoded (_MimotoAimless__interaction__form_input_textline -> textline-form)


        // output
        return $page->render();
    }

    public function formFieldNew_fieldForm(Application $app, $nFormId, $nFormFieldTypeId)
    {
        // 1. create dummy
        $entity = $app['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM);

        // 2. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');

        // 3. load form id
        $sFormConfigId = $app['Mimoto.Forms']->getCoreFormByEntityTypeId($nFormFieldTypeId);

        // 4. setup
        $component->addForm($sFormConfigId, $entity, ['onCreatedAddTo' => CoreConfig::MIMOTO_FORM . '.' . $nFormId . '.fields']);

        // 5. render and send
        return $component->render();
    }

    public function formFieldEdit(Application $app, $nFormFieldTypeId, $nFormFieldId)
    {
        // 1. load
        $entity = $app['Mimoto.Data']->get($nFormFieldTypeId, $nFormFieldId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/forms");

        // 3. create
        $component = $app['Mimoto.Aimless']->createComponent('Mimoto.CMS_form_Popup');


        // 1. translate $nFormFieldTypeId to formconfig


        // 4. setup
        $component->addForm(CoreConfig::COREFORM_INPUT_TEXTLINE_EDIT, $entity);

        // 5. render and send
        return $component->render();
    }

    public function formFieldDelete(Application $app, $nFormFieldTypeId, $nFormFieldId)
    {
        // #todo add transaction


        // 1. load
        $formField = $app['Mimoto.Data']->get($nFormFieldTypeId, $nFormFieldId);

        // 2. read
        $value = $formField->getValue('value');

        // 3. clear
        if (!empty($value))
        {
            $value->setValue('entityproperty', null);

            // 4. remove connections
            $app['Mimoto.Data']->store($value);

            // 5. clear
            $formField->setValue('value', null);

            // 6. remove connections
            $app['Mimoto.Data']->store($formField);

            // 7. remove value
            $app['Mimoto.Data']->delete($value);
        }

        // 8. load
        $parentForm = $app['Mimoto.Config']->getParent(CoreConfig::MIMOTO_FORM, CoreConfig::MIMOTO_FORM.'--fields', $formField);

        // 9. remove connection
        $parentForm->removeValue('fields', $formField);
        // 10. persist removed
        $app['Mimoto.Data']->store($parentForm);

        // 11. delete property
        $app['Mimoto.Data']->delete($formField);

        // 12. send
        return new JsonResponse((object) array('result' => 'FormField deleted! '.date("Y.m.d H:i:s")), 200);
    }

}

<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\UserInterface\MimotoCMS\utils\InterfaceUtils;

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
        // create dummy
        $entity = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM);

        // 1. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 2. setup
        $component->addForm(CoreConfig::COREFORM_FORM, $entity,
            [
                'onCreatedConnectTo' => CoreConfig::MIMOTO_ENTITY.'.'.$nEntityId.'.forms',
                'response' => [
                    'onSuccess' => [
                        'closePopup' => true
                    ]
                ]
            ]
        );

        // 3. render and send
        return $component->render();
    }

    public function formView(Application $app, $nFormId)
    {
        // 1. load requested entity
        $form = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 2. check if entity exists
        if ($form === false) return $app->redirect("/mimoto.cms/forms");

        // 3. create component
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_forms_FormDetail', $form);

        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // setup page
        $page->setVar('pageTitle', array(
                (object)array(
                    "label" => 'Forms',
                    "url" => '/mimoto.cms/forms'
                ),
                (object)array(
                    "label" => '"<span data-aimless-value="' . CoreConfig::MIMOTO_FORM . '.' . $form->getId() . '.name">' . $form->getValue('name') . '</span>"',
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
        $form = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 2. validate
        if ($form === false) return $app->redirect("/mimoto.cms/forms");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. setup
        $component->addForm(CoreConfig::COREFORM_FORM, $form, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 5. render and send
        return $component->render();
    }

    public function formDelete(Application $app, $nFormId)
    {
        // 1. load
        $form = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $nFormId);

        // 2. load
        $parentEntity = $app['Mimoto.Config']->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $form);

        // 3. remove connection
        $parentEntity->removeValue('forms', $form);

        // 4. persist removed
        Mimoto::service('data')->store($parentEntity);

        // 5. delete property
        Mimoto::service('data')->delete($form);

        // 6. send
        return new JsonResponse((object) array('result' => 'Form deleted! '.date("Y.m.d H:i:s")), 200);
    }

    public function formFieldNew_fieldTypeSelector(Application $app, $nFormId)
    {
        // create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_forms_FormDetail_TypeSelector');

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
        // 1. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. get form name
        $sFormName = Mimoto::service('forms')->getCoreFormByEntityTypeId($nFormFieldTypeId);

        // 3. setup
        $component->addForm($sFormName, null, ['onCreatedConnectTo' => CoreConfig::MIMOTO_FORM . '.' . $nFormId . '.fields', 'response' => ['onSuccess' => ['closePopup' => true]]]);

        // 4. render and send
        return $component->render();
    }

    public function formFieldEdit(Application $app, $nFormFieldTypeId, $nFormFieldId)
    {
        // 1. load
        $entity = Mimoto::service('data')->get($nFormFieldTypeId, $nFormFieldId);

        // 2. validate
        if ($entity === false) return $app->redirect("/mimoto.cms/forms");

        // 3. create
        $component = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Popup');

        // 4. get form name
        $sFormName = Mimoto::service('forms')->getCoreFormByEntityTypeId($entity->getEntityTypeName());

        // 5. setup
        $component->addForm($sFormName, $entity, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 6. render and send
        return $component->render();
    }

    public function formFieldValueEdit(Application $app, $nFormFieldValueId)
    {
        // 1. load
        $valueEntity = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM_INPUTVALUE, $nFormFieldValueId);

        // 2. validate
        if ($valueEntity === false) return $app->redirect("/mimoto.cms/forms");

        // 3. create
        $page = Mimoto::service('aimless')->createComponent('Mimoto.CMS_form_Page');


        // add content menu
        $page = InterfaceUtils::addMenuToComponent($page);

        // 1. translate $nFormFieldTypeId to formconfig

        $eFormField = Mimoto::service('config')->getParent(CoreConfig::Mimoto);



        // 4. setup
        $page->addForm(CoreConfig::COREFORM_FORM_INPUTVALUE, $valueEntity, ['response' => ['onSuccess' => ['closePopup' => true]]]);

        // 5. render and send
        return $page->render();
    }


    public function formFieldDelete(Application $app, $nFormFieldTypeId, $nFormFieldId)
    {
        // #todo add transaction


        // 1. load
        $formField = Mimoto::service('data')->get($nFormFieldTypeId, $nFormFieldId);

        if ($formField->hasProperty('value'))
        {
            // 2. read
            $value = $formField->getValue('value');

            // 3. clear
            if (!empty($value))
            {
                $value->setValue('entityProperty', null);

                // 4. remove connections
                Mimoto::service('data')->store($value);

                // 5. clear
                $formField->setValue('value', null);

                // 6. remove connections
                Mimoto::service('data')->store($formField);

                // 7. remove value
                Mimoto::service('data')->delete($value);
            }
        }

        // 8. load
        $parentForm = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_FORM, CoreConfig::MIMOTO_FORM.'--fields', $formField);

        // 9. remove connection
        $parentForm->removeValue('fields', $formField);

        // 10. persist removed
        Mimoto::service('data')->store($parentForm);

        // 11. delete property
        Mimoto::service('data')->delete($formField);

        // 12. send
        return new JsonResponse((object) array('result' => 'FormField deleted! '.date("Y.m.d H:i:s")), 200);
    }

}

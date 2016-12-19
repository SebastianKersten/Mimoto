<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Core\CoreConfig;

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
                (object) array(
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
                (object) array(
                    "label" => 'Forms',
                    "url" => '/mimoto.cms/forms'
                ),
                (object) array(
                    "label" => '"<span mls_value="'.CoreConfig::MIMOTO_FORM.'.'.$form->getId().'.name">'.$form->getValue('name').'</span>"',
                    "url" => '/mimoto.cms/form/'.$form->getId().'/view'
                )
            )
        );

        // 5. output
        return $page->render();
    }
    
}

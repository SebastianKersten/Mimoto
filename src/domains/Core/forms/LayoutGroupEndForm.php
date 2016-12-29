<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * LayoutGroupEndForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class LayoutGroupEndForm
{

    /**
     * Get NEW structure
     */
    public static function getStructureNew()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_LAYOUT_GROUPEND_NEW);

        // setup
        $form->addValue('fields', self::getField_title('Add new group end'));

        // send
        return $form;
    }

    /**
     * Get EDIT structure
     */
    public static function getStructureEdit()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_LAYOUT_GROUPEND_EDIT);

        // setup
        $form->addValue('fields', self::getField_title('Edit group end'));

        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Init structure
     */
    private static function initForm($sFormName)
    {
        // init
        $form = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM);

        // setup
        $form->setId($sFormName);
        $form->setValue('name', $sFormName);
        $form->setValue('realtimeCollaborationMode', false);

        // send
        return $form;
    }

    /**
     * Get field: title
     */
    private static function getField_title($sTitle)
    {
        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_LAYOUT_GROUPEND.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "Add groups in order to make a form more pleasant and scannable for the content editor");

        // send
        return $field;
    }

}

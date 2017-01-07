<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;


/**
 * LayoutDividerForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class LayoutDividerForm
{

    /**
     * Get NEW structure
     */
    public static function getStructureNew()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_LAYOUT_DIVIDER_NEW);

        // setup
        $form->addValue('fields', self::getField_title('Add new divider'));

        // send
        return $form;
    }

    /**
     * Get EDIT structure
     */
    public static function getStructureEdit()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_LAYOUT_DIVIDER_EDIT);

        // setup
        $form->addValue('fields', self::getField_title('Edit divider'));

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
        $form = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM);

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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_LAYOUT_DIVIDER.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "Add dividers to make a form more pleasant and scannable for the content editor");

        // send
        return $field;
    }

}

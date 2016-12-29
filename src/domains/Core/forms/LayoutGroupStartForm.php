<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * LayoutGroupStartForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class LayoutGroupStartForm
{

    /**
     * Get NEW structure
     */
    public static function getStructureNew()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_LAYOUT_GROUPSTART_NEW);

        // setup
        $form->addValue('fields', self::getField_title('Add new group'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_label());
        $form->addValue('fields', self::getField_groupEnd());

        // send
        return $form;
    }

    /**
     * Get EDIT structure
     */
    public static function getStructureEdit()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_LAYOUT_GROUPSTART_EDIT);

        // setup
        $form->addValue('fields', self::getField_title('Edit group'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_label());
        $form->addValue('fields', self::getField_groupEnd());

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
        $field->setValue('description', "Add groups in order to make a form more pleasant and scannable for the content editor. Use a 'group end' to close a previously started group of input fields.");

        // send
        return $field;
    }

    /**
     * Get field: groupStart
     */
    private static function getField_groupStart()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--groupstart');

        // send
        return $field;
    }

    /**
     * Get field: label
     */
    private static function getField_label()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_LAYOUT_GROUPSTART.'--label');
        $field->setValue('label', 'Title');
        $field->setValue('placeholder', "Enter the group's title");
        $field->setValue('description', "");

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_LAYOUT_GROUPSTART.'--title_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART.'--title');
                $value->setValue('entityproperty', $connectedEntityProperty);

            // add value to field
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: groupEnd
     */
    private static function getField_groupEnd()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--groupend');

        // send
        return $field;
    }

}

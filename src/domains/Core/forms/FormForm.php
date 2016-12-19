<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * FormForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormForm
{

    /**
     * Get NEW structure
     */
    public static function getStructureNew()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_FORM_NEW);

        // setup
        $form->addValue('fields', self::getField_title('Add new form'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
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
        $form = self::initForm(CoreConfig::COREFORM_FORM_EDIT);

        // setup
        $form->addValue('fields', self::getField_title('Edit form'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
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
        $field->setId(CoreConfig::COREFORM_FORM_EDIT.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "The core element of data is called an 'entity'. Entities are the data objects that contain a certain set of properties, for instance <i>Person</i> containing a <i>name</i> and a <i>date of birth</i>");

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
        $field->setId(CoreConfig::COREFORM_FORM.'--groupstart');

        // send
        return $field;
    }

    /**
     * Get field: name
     */
    private static function getField_name()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_FORM.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Enter the form name");
        $field->setValue('description', "Enter a unique form name");

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_FORM.'--name_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM.'--name');
                $value->setValue('entityproperty', $connectedEntityProperty);

                // validation rule #1
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_FORM.'--name_value_validation1');
                $validationRule->setValue('key', 'maxchars');
                $validationRule->setValue('value', 50);
                $validationRule->setValue('errorMessage', 'No more than 10 characters');
                $value->addValue('validation', $validationRule);

                // validation rule #2
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_FORM.'--name_value_validation2');
                $validationRule->setValue('key', 'minchars');
                $validationRule->setValue('value', 1);
                $validationRule->setValue('errorMessage', "Value can't be empty");
                $value->addValue('validation', $validationRule);

                // validation rule #3
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_FORM.'--name_value_validation3');
                $validationRule->setValue('key', 'regex_custom');
                $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
                $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
                $value->addValue('validation', $validationRule);

                // validation rule #4
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_FORM.'--name_value_validation4');
                $validationRule->setValue('key', 'api');
                $validationRule->setValue('value', '/mimoto.cms/entityproperty/validatename');
                $validationRule->setValue('errorMessage', 'The name needs to be unique');
                $value->addValue('validation', $validationRule);

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
        $field->setId(CoreConfig::COREFORM_FORM.'--groupend');

        // send
        return $field;
    }
}

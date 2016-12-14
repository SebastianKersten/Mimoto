<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * ComponentForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ComponentForm
{

    /**
     * Get NEW structure
     */
    public static function getStructureNew()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_COMPONENT_NEW);

        // setup
        $form->addValue('fields', self::getField_title('Add new component'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
        $form->addValue('fields', self::getField_file());
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
        $form = self::initForm(CoreConfig::COREFORM_COMPONENT_EDIT);

        // setup
        $form->addValue('fields', self::getField_title('Edit component'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
        $form->addValue('fields', self::getField_file());
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
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "The key element in presenting data is the 'component'. These are twig files that use the Aimless protocol to read and render the data, with the support of realtime updates to any client.");

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
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--groupstart');

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
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Component name");
        $field->setValue('description', "The component name could be unique, or used multiple times using conditionals");

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_COMPONENT.'--name_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_COMPONENT.'--name');
                $value->setValue('entityproperty', $connectedEntityProperty);

                // validation rule #1
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--name_value_validation1');
                $validationRule->setValue('key', 'maxchars');
                $validationRule->setValue('value', 50);
                $validationRule->setValue('errorMessage', 'No more than 10 characters');
                $value->addValue('validation', $validationRule);

                // validation rule #2
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--name_value_validation2');
                $validationRule->setValue('key', 'minchars');
                $validationRule->setValue('value', 1);
                $validationRule->setValue('errorMessage', "Value can't be empty");
                $value->addValue('validation', $validationRule);

                // validation rule #3
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--name_value_validation3');
                $validationRule->setValue('key', 'regex_custom');
                $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
                $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
                $value->addValue('validation', $validationRule);

                // validation rule #4
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--name_value_validation4');
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
     * Get field: name
     */
    private static function getField_file()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--file');
        $field->setValue('label', 'Twig file');
        $field->setValue('placeholder', "your_template_file.twig");
        $field->setValue('description', "");
        $field->setValue('prefix', "src/userinterface/");

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_COMPONENT.'--file_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_COMPONENT.'--file');
                $value->setValue('entityproperty', $connectedEntityProperty);

                // validation rule #1
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--file_value_validation1');
                $validationRule->setValue('key', 'maxchars');
                $validationRule->setValue('value', 50);
                $validationRule->setValue('errorMessage', 'No more than 10 characters');
                $value->addValue('validation', $validationRule);

                // validation rule #2
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--file_value_validation2');
                $validationRule->setValue('key', 'minchars');
                $validationRule->setValue('value', 1);
                $validationRule->setValue('errorMessage', "Value can't be empty");
                $value->addValue('validation', $validationRule);

                // validation rule #3
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--file_value_validation3');
                $validationRule->setValue('key', 'regex_custom');
                $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
                $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
                $value->addValue('validation', $validationRule);

                // validation rule #4
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--file_value_validation4');
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
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--groupend');

        // send
        return $field;
    }
}

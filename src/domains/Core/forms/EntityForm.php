<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * EntityForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityForm
{

    const DESCRIPTION = "The core element of data is called an 'entity'. Entities are the data objects that contain a certain set of properties, for instance <i>Person</i> containing a <i>name</i> and a <i>date of birth</i>";


    public static function getStructureNew()
    {
        // init
        $form = self::getStructureStart(CoreConfig::COREFORM_ENTITY_NEW);

        // --- title ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_ENTITY.'--title');
        $field->setValue('title', 'Add new entity');
        $field->setValue('description', self::DESCRIPTION);

        // add
        $form->addValue('fields', $field);

        // init
        $form = self::getStructureEnd($form);

        // send
        return $form;
    }

    public static function getStructureEdit()
    {
        // init
        $form = self::getStructureStart(CoreConfig::COREFORM_ENTITY_EDIT);

        // --- title ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_ENTITY.'--title');
        $field->setValue('title', 'Edit entity');
        $field->setValue('description', self::DESCRIPTION);

        // add
        $form->addValue('fields', $field);

        // init
        $form = self::getStructureEnd($form);

        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    private static function getStructureStart($sFormName)
    {
        // init
        $form = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM);

        // setup
        $form->setId($sFormName);
        $form->setValue('name', $sFormName);
        $form->setValue('realtimeCollaborationMode', true);


        // send
        return $form;
    }

    private static function getStructureEnd($form)
    {

        // --- group start ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITY.'--groupstart');

        // add
        $form->addValue('fields', $field);


        // --- input - entity name ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_ENTITY.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Entity name");
        $field->setValue('description', "The entity name should be unique");

        // value
        $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
        $value->setId(CoreConfig::COREFORM_ENTITY.'--name_value');
        $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITY.'--name');

        // validation rule #1
        $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
        $validationRule->setValue('key', 'maxchars');
        $validationRule->setValue('value', 50);
        $validationRule->setValue('errorMessage', 'No more than 10 characters');
        $value->addValue('validation', $validationRule);

        // validation rule #2
        $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
        $validationRule->setValue('key', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $value->addValue('validation', $validationRule);

        // validation rule #3
        $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
        $validationRule->setValue('key', 'regex_custom');
        $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
        $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
        $value->addValue('validation', $validationRule);

        // validation rule #4
        $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
        $validationRule->setValue('key', 'api');
        $validationRule->setValue('value', '/mimoto.cms/entityproperty/validatename');
        $validationRule->setValue('errorMessage', 'The name needs to be unique');
        $value->addValue('validation', $validationRule);


        // add
        $value->setValue('entityproperty', $connectedEntityProperty);
        $field->setValue('value', $value);
        $form->addValue('fields', $field);


        // --- group end ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITY.'--groupend');

        // add
        $form->addValue('fields', $field);


        // send
        return $form;
    }

}

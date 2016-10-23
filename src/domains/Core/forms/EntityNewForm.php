<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * EntityNewForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityNewForm
{

    public static function getStructure()
    {
        // init
        $form = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM);

        // setup
        $form->setId(CoreConfig::COREFORM_ENTITY_NEW);
        $form->setValue('name', CoreConfig::COREFORM_ENTITY_NEW);


        // --- title ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_ENTITY_NEW.'--title');
        $field->setValue('title', 'Add new entity');
        $field->setValue('description', "The core element of data is called an 'entity'. Entities are the data objects that contain a certain set of properties, for instance <i>Person</i> containing a <i>name</i> and a <i>date of birth</i>");

        // add
        $form->addValue('fields', $field);


        // --- group start ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITY_NEW.'--groupstart');

        // add
        $form->addValue('fields', $field);


        // --- input - entity name ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_ENTITY_NEW.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Entity name");
        $field->setValue('description', "The entity name should be unique");

        $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
        $value->setId(CoreConfig::COREFORM_ENTITY_NEW.'--name_value');
        $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITY.'--name');

        // add
        $value->setValue('entityproperty', $connectedEntityProperty);
        $field->setValue('value', $value);
        $form->addValue('fields', $field);


        // --- group end ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITY_NEW.'--groupend');

        // add
        $form->addValue('fields', $field);


        // send
        return $form;
    }

}

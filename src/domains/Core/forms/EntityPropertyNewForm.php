<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * EntityPropertyNewForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyNewForm
{

    public static function getStructure()
    {
        // init
        $form = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM);

        // setup
        $form->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW);
        $form->setValue('name', CoreConfig::COREFORM_ENTITYPROPERTY_NEW);
        $form->setValue('realtimeCollaborationMode', true);


        // --- title ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--title');
        $field->setValue('title', 'Add new property');
        $field->setValue('description', "Entities are composed of 'properties'. Add properties to your entity and decide what type they are. A property can have three types: <i>value</i>, <i>entity</i> or <i>collection</i>");

        // add
        $form->addValue('fields', $field);


        // --- group start ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--groupstart');

        // add
        $form->addValue('fields', $field);


        // --- input - entity property name ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Property name");
        $field->setValue('description', "The property name should be unique");

        $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
        $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--name_value');
        $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--name');

        // add
        $value->setValue('entityproperty', $connectedEntityProperty);
        $field->setValue('value', $value);
        $form->addValue('fields', $field);


        // --- input - entity property type ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--type');
        $field->setValue('label', 'Type');

        $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
        $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--type_value');
        $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--type_value_options-value');
        $option->setValue('key', 'value');
        $option->setValue('value', 'Value');
        $value->addValue('options', $option);

        $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--type_value_options-entity');
        $option->setValue('key', 'entity');
        $option->setValue('value', 'Entity');
        $value->addValue('options', $option);

        $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--type_value_options-collection');
        $option->setValue('key', 'collection');
        $option->setValue('value', 'Collection');
        $value->addValue('options', $option);

        $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--type');

        // add
        $value->setValue('entityproperty', $connectedEntityProperty);
        $field->setValue('value', $value);
        $form->addValue('fields', $field);


        // --- group end ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY_NEW.'--groupend');

        // add
        $form->addValue('fields', $field);


        // send
        return $form;
    }

}

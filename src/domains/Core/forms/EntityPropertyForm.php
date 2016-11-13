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
class EntityPropertyForm
{

    const DESCRIPTION = "Entities are composed of 'properties'. Add properties to your entity and decide what type they are. A property can have three types: <i>value</i>, <i>entity</i> or <i>collection</i>";


    public static function getStructureNew()
    {
        // init
        $form = self::getStructureStart(CoreConfig::COREFORM_ENTITYPROPERTY_NEW);

        // --- title ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--title');
        $field->setValue('title', 'Add new property');
        $field->setValue('description', self::DESCRIPTION);

        // add
        $form->addValue('fields', $field);

        // init
        $form = self::getStructureMiddle($form);
        $form = self::getStructureValue($form);
        $form = self::getStructureEnd($form);

        // send
        return $form;
    }

    public static function getStructureEdit()
    {
        // init
        $form = self::getStructureStart(CoreConfig::COREFORM_ENTITYPROPERTY_EDIT);

        // --- title ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--title');
        $field->setValue('title', 'Edit property');
        $field->setValue('description', self::DESCRIPTION);

        // add
        $form->addValue('fields', $field);

        // init
        $form = self::getStructureMiddle($form);
        $form = self::getStructureEnd($form);
        //$form = self::getStructureValueSettings($form);
        //$form = self::getStructureEntitySettings($form);
        $form = self::getStructureCollectionSettings($form);

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

    private static function getStructureMiddle($form)
    {
        // --- group start ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--groupstart');

        // add
        $form->addValue('fields', $field);


        // --- input - entity property name ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Property name");
        $field->setValue('description', "The property name should be unique");

        $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
        $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value');
        $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--name');

        // add
        $value->setValue('entityproperty', $connectedEntityProperty);
        $field->setValue('value', $value);
        $form->addValue('fields', $field);

        // send
        return $form;
    }

    private static function getStructureValue($form)
    {
        // --- input - entity property type ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type');
        $field->setValue('label', 'Type');

        $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
        $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value');
        $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-value');
        $option->setValue('key', 'value');
        $option->setValue('value', 'Value');
        $value->addValue('options', $option);

        $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-entity');
        $option->setValue('key', 'entity');
        $option->setValue('value', 'Entity');
        $value->addValue('options', $option);

        $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-collection');
        $option->setValue('key', 'collection');
        $option->setValue('value', 'Collection');
        $value->addValue('options', $option);

        $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--type');

        // add
        $value->setValue('entityproperty', $connectedEntityProperty);
        $field->setValue('value', $value);
        $form->addValue('fields', $field);


        // send
        return $form;
    }

    private static function getStructureEnd($form)
    {

        // --- group end ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--groupend');

        // add
        $form->addValue('fields', $field);

        // send
        return $form;
    }


    private static function getStructureValueSettings($form)
    {

        // --- group start ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--groupstart-valuesettings');
        $field->setValue('title', 'Value settings');

        // add
        $form->addValue('fields', $field);


        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type');
        $field->setValue('label', 'Type');

        $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
        $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value');
        $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-value');
        $option->setValue('key', 'value');
        $option->setValue('value', 'Value');
        $value->addValue('options', $option);

        $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-entity');
        $option->setValue('key', 'entity');
        $option->setValue('value', 'Entity');
        $value->addValue('options', $option);

        $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-collection');
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
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--groupend-valuesettings');

        // add
        $form->addValue('fields', $field);

        // send
        return $form;
    }

    private static function getStructureEntitySettings($form)
    {

        // --- group start ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--groupstart__valuesettings-entity');
        $field->setValue('title', 'Entity settings');

        // add
        $form->addValue('fields', $field);


        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type');
        $field->setValue('label', 'Allowed entity type');

        $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
        $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value');
        $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        // load
        $aEntities = $GLOBALS['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_ENTITY]);

        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
            $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-valuesettings-entity-'.$entity->getId());
            $option->setValue('key', $entity->getId());
            $option->setValue('value', $entity->getValue('name'));
            $value->addValue('options', $option);
        }

        $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--type');

        // add
        $value->setValue('entityproperty', $connectedEntityProperty);
        $field->setValue('value', $value);
        $form->addValue('fields', $field);


        // --- group end ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--groupend-valuesettings-entity');

        // add
        $form->addValue('fields', $field);

        // send
        return $form;
    }

    private static function getStructureCollectionSettings($form)
    {

        // --- group start ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--groupstart__valuesettings-collection');
        $field->setValue('title', 'Collection settings');

        // add
        $form->addValue('fields', $field);


        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityTypes');
        $field->setValue('label', 'Allowed entity type');

        $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
        $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityTypes_value');
        $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

        // load
        $aEntities = $GLOBALS['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_ENTITY]);

        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
            $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityTypes_value_options-valuesettings-collection-'.$entity->getId());
            $option->setValue('key', $entity->getId());
            $option->setValue('value', $entity->getValue('name'));
            $value->addValue('options', $option);
        }

        $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--type');

        // add
        $value->setValue('entityproperty', $connectedEntityProperty);
        $field->setValue('value', $value);
        $form->addValue('fields', $field);


        // #todo _MimotoAimless__coreform__entityproperty--allowduplicates</b> is missing it's value property</div>


        // --- checkbox allowDuplicates ---

        // create and setup
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowduplicates');
        $field->setValue('label', 'Allow duplicates');
        $form->addValue('fields', $field);


        // --- group end ---

        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--groupend-valuesettings-collection');

        // add
        $form->addValue('fields', $field);

        // send
        return $form;
    }

}

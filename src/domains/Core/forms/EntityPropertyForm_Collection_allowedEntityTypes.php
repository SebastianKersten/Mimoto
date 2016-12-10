<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * EntityPropertyForm_Collection_allowedEntityTypes
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyForm_Collection_allowedEntityTypes
{

    /**
     * Get NEW structure
     */
    public static function getStructure()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_ENTITYPROPERTY_NEW);

        // setup
        $form->addValue('fields', self::getField_title('Configure'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
        $form->addValue('fields', self::getField_type());
        $form->addValue('fields', self::getField_groupEnd());

//        // setup value
//        $form->addValue('fields', self::value_getField_groupStart());
//        $form->addValue('fields', self::value_getField_type());
//        $form->addValue('fields', self::value_getField_groupEnd());
//
//        // setup entity
//        $form->addValue('fields', self::entity_getField_groupStart());
//        $form->addValue('fields', self::entity_getField_allowedEntityType());
//        $form->addValue('fields', self::entity_getField_groupEnd());

        // setup collection
        $form->addValue('fields', self::collection_getField_groupStart());
        $form->addValue('fields', self::collection_getField_allowedEntityTypes());
        $form->addValue('fields', self::collection_getField_allowDuplicates());
        $form->addValue('fields', self::collection_getField_groupEnd());

        // send
        return $form;
    }

    /**
     * Get EDIT structure
     */
    public static function getStructureEdit()
    {
        // init
        $form = self::getStructureStart(CoreConfig::COREFORM_ENTITYPROPERTY_EDIT);

        // setup
        $form->addValue('fields', self::getField_title('Edit property'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
        $form->addValue('fields', self::getField_type());
        $form->addValue('fields', self::getField_groupEnd());

        // setup value
        $form->addValue('fields', self::value_getField_groupStart());
        $form->addValue('fields', self::value_getField_type());
        $form->addValue('fields', self::value_getField_groupEnd());

        // setup entity
        $form->addValue('fields', self::entity_getField_groupStart());
        $form->addValue('fields', self::entity_getField_allowedEntityType());
        $form->addValue('fields', self::entity_getField_groupEnd());

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
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "Entities are composed of 'properties'. Add properties to your entity and decide what type they are. A property can have three types: <i>value</i>, <i>entity</i> or <i>collection</i>");

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
        $field->setId(CoreConfig::COREFORM_ENTITY.'--groupstart');

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
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Property name");
        $field->setValue('description', "The property name should be unique");

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--name');
                $value->setValue('entityproperty', $connectedEntityProperty);

                // validation rule #1
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation1');
                $validationRule->setValue('key', 'maxchars');
                $validationRule->setValue('value', 50);
                $validationRule->setValue('errorMessage', 'No more than 10 characters');
                $value->addValue('validation', $validationRule);

                // validation rule #2
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation2');
                $validationRule->setValue('key', 'minchars');
                $validationRule->setValue('value', 1);
                $validationRule->setValue('errorMessage', "Value can't be empty");
                $value->addValue('validation', $validationRule);

                // validation rule #3
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation3');
                $validationRule->setValue('key', 'regex_custom');
                $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
                $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
                $value->addValue('validation', $validationRule);

                // validation rule #4
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--name_value_validation4');
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
     * Get field: type
     */
    private static function getField_type()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type');
        $field->setValue('label', 'Type');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--type');
                $value->setValue('entityproperty', $connectedEntityProperty);

                $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-value');
                $option->setValue('key', MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE);
                $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE);
                $value->addValue('options', $option);

                $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-entity');
                $option->setValue('key', MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
                $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY);
                $value->addValue('options', $option);

                $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-collection');
                $option->setValue('key', MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION);
                $option->setValue('value', MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION);
                $value->addValue('options', $option);

            // add
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
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--groupend');

        // send
        return $field;
    }


    // --- settings: value ---


    /**
     * Get field: valueSetting - groupStart
     */
    private static function value_getField_groupStart()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--valueSetting--groupstart');
        $field->setValue('title', 'Value settings');

        // send
        return $field;
    }

    /**
     * Get field: valueSetting - type
     */
    private static function value_getField_type()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--valueSetting--type');
        $field->setValue('label', 'Type');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--value');
                $value->setValue('entityproperty', $connectedEntityProperty);

                $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--valueSetting--type-value-options-'.CoreConfig::DATA_VALUE_TEXTLINE);
                $option->setValue('key', CoreConfig::DATA_VALUE_TEXTLINE);
                $option->setValue('value', CoreConfig::DATA_VALUE_TEXTLINE);
                $value->addValue('options', $option);

                $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--valueSetting--type-value-options-'.CoreConfig::DATA_VALUE_TEXTBLOCK);
                $option->setValue('key', CoreConfig::DATA_VALUE_TEXTBLOCK);
                $option->setValue('value', CoreConfig::DATA_VALUE_TEXTBLOCK);
                $value->addValue('options', $option);

            // add
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: valueSetting - groupEnd
     */
    private static function value_getField_groupEnd()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--valueSetting--groupend');

        // send
        return $field;
    }



    // --- settings: entity ---


    /**
     * Get field: entitySetting - groupStart
     */
    private static function entity_getField_groupStart()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--entitySetting--groupstart');
        $field->setValue('title', 'Entity settings');

        // send
        return $field;
    }

    /**
     * Get field: entitySetting - allowedEntityType
     */
    private static function entity_getField_allowedEntityType()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityType');
        $field->setValue('label', 'Allowed entity type');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityType');
                $value->setValue('entityproperty', $connectedEntityProperty);

                // load
                $aEntities = $GLOBALS['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_ENTITY]);

                $nEntityCount = count($aEntities);
                for ($i = 0; $i < $nEntityCount; $i++)
                {
                    // register
                    $entity = $aEntities[$i];

                    $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                    $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--entitySetting--allowedEntityType-value-options-'.$entity->getId());
                    $option->setValue('key', $entity->getId());
                    $option->setValue('value', $entity->getValue('name'));
                    $value->addValue('options', $option);
                }

            // add
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: entitySetting - groupEnd
     */
    private static function entity_getField_groupEnd()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--entitySetting--groupend');

        // send
        return $field;
    }



    // --- settings: collection ---


    /**
     * Get field: entitySetting - groupStart
     */
    private static function collection_getField_groupStart()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--collectionSetting--groupstart');
        $field->setValue('title', 'Collection settings');

        // send
        return $field;
    }

    /**
     * Get field: collectionSetting - allowedEntityTypes
     */
    private static function collection_getField_allowedEntityTypes()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityTypes');
        $field->setValue('label', 'Allowed entity types');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityTypes_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--type');
                $value->setValue('entityproperty', $connectedEntityProperty);

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

            // add
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: collectionSetting - allowDuplicates
     */
    private static function collection_getField_allowDuplicates()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowduplicates');
        $field->setValue('label', 'Configuration');
        $field->setValue('option', 'Allow duplicates');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowDuplicates');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--value');
                $value->setValue('entityproperty', $connectedEntityProperty);

            // add
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: collectionSetting - groupEnd
     */
    private static function collection_getField_groupEnd()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--collectionSetting--groupend');

        // send
        return $field;
    }

//
//    private static function getStructureCollectionSettings($form)
//    {
//
//
//
//
//

}

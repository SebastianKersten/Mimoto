<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputValue
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputValue
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUTVALUE,
            'extends' => null,
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--vartype',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'vartype',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--vartype-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--varname',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'varname',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--varname-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--entityproperty',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'entityproperty',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--entityproperty-allowedEntityType',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityType',
                            'type' => 'value', // #todo - fixme
                            'value' => CoreConfig::MIMOTO_ENTITYPROPERTY
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--options',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'options',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--options-allowedEntityTypes',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_FORM_INPUTVALUESETTING]
                        ),
                        'allowDuplicates' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--options-allowDuplicates',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--validation',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'validation',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--validation-allowedEntityTypes',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION]
                        ),
                        'allowDuplicates' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--validation-allowDuplicates',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--optional',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'optional',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUTVALUE.'--optional-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                )
            ]
        );
    }

    public static function getData()
    {
        // hierin komen de velden die nodig zijn voor entity-management etc
    }



    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_FORM_INPUTVALUE);

        // setup
        $form->addValue('fields', self::getField_title('Configure value'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_vartype());
        $form->addValue('fields', self::getField_entityProperty());
        //$form->addValue('fields', self::getField_varname());
        $form->addValue('fields', self::getField_isOptional());
        $form->addValue('fields', self::getField_groupEnd());

        // send
        return $form;
    }

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
        $field->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "The value of a field can be configured to either connect to an entity's property (with with the autosaving feature turns into action) or to hold a custom name.");

        // send
        return $field;
    }

    /**
     * Get field: groupStart
     */
    private static function getField_groupStart()
    {
        // create
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--groupstart');

        // send
        return $field;
    }

    /**
     * Get field: type
     */
    private static function getField_vartype()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON);
        $field->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--vartype');
        $field->setValue('label', 'Type');

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--vartype-value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUTVALUE.'--vartype');
                $value->setValue('entityproperty', $connectedEntityProperty);

                $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--vartype-options-'.CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);
                $option->setValue('key', CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);
                $option->setValue('value', 'Connect to an entity\'s property');
                $value->addValue('options', $option);

                $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--vartype-options-'.CoreConfig::INPUTVALUE_VARTYPE_VARNAME);
                $option->setValue('key', CoreConfig::INPUTVALUE_VARTYPE_VARNAME);
                $option->setValue('value', 'Custom field variable');
                $value->addValue('options', $option);

            // add
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: extends
     */
    private static function getField_entityProperty()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN);
        $field->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--entityproperty');
        $field->setValue('label', 'Connect to this entity\'s property');

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--entityproperty_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUTVALUE.'--entityproperty');
                $value->setValue('entityproperty', $connectedEntityProperty);

                // load
                $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_ENTITY]);

                $nEntityCount = count($aEntities);
                for ($nEntityIndex = 0; $nEntityIndex < $nEntityCount; $nEntityIndex++)
                {
                    // register
                    $entity = $aEntities[$nEntityIndex]; 

                    // read
                    $aEntityProperties = $entity->getValue('properties');

                    $nEntityPropertyCount = count($aEntityProperties);
                    for ($nEntityPropertyIndex = 0; $nEntityPropertyIndex < $nEntityPropertyCount; $nEntityPropertyIndex++)
                    {
                        $entityProperty = $aEntityProperties[$nEntityPropertyIndex];

                        $sLabel = $entity->getValue('name').'.'.$entityProperty->getValue('name');

                        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                        $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--entityproperty_value_options-valuesettings-collection-'.$entityProperty->getId());
                        $option->setValue('key', $entityProperty->getEntityTypeName().'.'.$entityProperty->getId());
                        $option->setValue('value', $sLabel);
                        $value->addValue('options', $option);
                    }
                }

            // add
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: name
     */
    private static function getField_varname()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--varname');
        $field->setValue('label', 'Field variable name');
        $field->setValue('placeholder', "Enter a name");
        $field->setValue('description', "The entity name should be unique");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--varname_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--varname');
                $value->setValue('entityproperty', $connectedEntityProperty);

            // add value to field
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: isAbstract
     */
    private static function getField_isOptional()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX);
        $field->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--optional');
        $field->setValue('label', 'Configuration');
        $field->setValue('option', 'This field is optional');

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--optional');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUTVALUE.'--optional');
                $value->setValue('entityproperty', $connectedEntityProperty);

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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_FORM_INPUTVALUE.'--groupend');

        // send
        return $field;
    }
}

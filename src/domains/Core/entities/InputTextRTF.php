<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputTextRTF
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputTextRTF
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF,
            'visualName' => 'Rich text field',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_TEXTRTF],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF.'--label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF.'--label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF.'--description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF.'--description-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF.'--placeholder',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'placeholder',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF.'--placeholder-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
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
        $form = self::initForm(CoreConfig::COREFORM_INPUT_TEXTRTF);

        // setup
        $form->addValue('fields', self::getField_title('Text RTF'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_label());
        $form->addValue('fields', self::getField_description());
        $form->addValue('fields', self::getField_placeholder());
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
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--title');
        $field->setValue('title', $sTitle);

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
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--groupstart');

        // send
        return $field;
    }

    /**
     * Get field: label
     */
    private static function getField_label()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--label');
        $field->setValue('label', 'Label');
        $field->setValue('placeholder', "Enter the input's label");
        $field->setValue('description', "Clarify what is required from the content editor");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--label_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF.'--label');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // validation rule #1
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--label_value_validation1');
                $validationRule->setValue('key', 'maxchars');
                $validationRule->setValue('value', 50);
                $validationRule->setValue('errorMessage', 'No more than 10 characters');
                $value->addValue('validation', $validationRule);

                // validation rule #2
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--label_value_validation2');
                $validationRule->setValue('key', 'minchars');
                $validationRule->setValue('value', 1);
                $validationRule->setValue('errorMessage', "Value can't be empty");
                $value->addValue('validation', $validationRule);

                // validation rule #3
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--label_value_validation3');
                $validationRule->setValue('key', 'regex_custom');
                $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
                $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
                $value->addValue('validation', $validationRule);

                // validation rule #4
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--label_value_validation4');
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
     * Get field: description
     */
    private static function getField_description()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--description');
        $field->setValue('label', 'Description');
        $field->setValue('placeholder', "Enter the input's description");
        $field->setValue('description', "Clarify what is required from the content editor");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--description_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF.'--description');
                $value->setValue('entityProperty', $connectedEntityProperty);

            // add value to field
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: placeholder
     */
    private static function getField_placeholder()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--placeholder');
        $field->setValue('label', 'Placeholder');
        $field->setValue('placeholder', "Enter the input's placeholder");
        $field->setValue('description', "Clarify what is required from the content editor");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--placeholder_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF.'--placeholder');
                $value->setValue('entityProperty', $connectedEntityProperty);

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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTRTF.'--groupend');

        // send
        return $field;
    }

}

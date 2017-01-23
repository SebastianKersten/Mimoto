<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * InputTextline
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class InputTextline
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
            'visualName' => 'Textline',
            'extends' => CoreConfig::MIMOTO_FORM_INPUT,
            'forms' => [CoreConfig::COREFORM_INPUT_TEXTLINE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--label',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'label',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--label-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => MimotoEntityConfig::SETTING_VALUE_TYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--description-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => MimotoEntityConfig::SETTING_VALUE_TYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--placeholder',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'placeholder',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--placeholder-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => MimotoEntityConfig::SETTING_VALUE_TYPE,
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--prefix',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'prefix',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--prefix-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => MimotoEntityConfig::SETTING_VALUE_TYPE,
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
        $form = self::initForm(CoreConfig::COREFORM_INPUT_TEXTLINE);

        // setup
        $form->addValue('fields', self::getField_title('Textline'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_label());
        $form->addValue('fields', self::getField_description());
        $form->addValue('fields', self::getField_placeholder());
        $form->addValue('fields', self::getField_prefix());
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
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--title');
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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--label');
        $field->setValue('label', 'Label');
        $field->setValue('placeholder', "Enter the input's label");
        $field->setValue('description', "Clarify what is required from the content editor");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--label_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--label');
                $value->setValue('entityProperty', $connectedEntityProperty);

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
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--description');
        $field->setValue('label', 'Description');
        $field->setValue('placeholder', "Enter the input's description");
        $field->setValue('description', "Clarify what is required from the content editor");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--description_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--description');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // 4. setup validation
                $value->setValue('optional', true);

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
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--placeholder');
        $field->setValue('label', 'Placeholder');
        $field->setValue('placeholder', "Enter the input's placeholder");
        $field->setValue('description', "Clarify what is required from the content editor");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--placeholder_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--placeholder');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // 4. setup validation
                $value->setValue('optional', true);

            // add value to field
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: prefix
     */
    private static function getField_prefix()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--prefix');
        $field->setValue('label', 'Prefix');
        $field->setValue('placeholder', "Enter the input's prefix");
        $field->setValue('description', "Clarify what is required from the content editor");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--prefix_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE.'--prefix');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // 4. setup validation
                $value->setValue('optional', true);

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
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--groupend');

        // send
        return $field;
    }

}

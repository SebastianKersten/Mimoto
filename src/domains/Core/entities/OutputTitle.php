<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * OutputTitle
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class OutputTitle
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
            'visualName' => 'Title',
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_OUTPUT_TITLE],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--title',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'title',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--title-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--subtitle',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'subtitle',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--subtitle-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--description',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'description',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--description-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTBLOCK
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
        $form = self::initForm(CoreConfig::COREFORM_OUTPUT_TITLE);

        // setup
        $form->addValue('fields', self::getField_formtitle('Add new title'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_title());
        $form->addValue('fields', self::getField_subtitle());
        $form->addValue('fields', self::getField_description());
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
    private static function getField_formtitle($sTitle)
    {
        // create and setup
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE);
        $field->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--formtitle');
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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--groupstart');

        // send
        return $field;
    }

    /**
     * Get field: label
     */
    private static function getField_title()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--title');
        $field->setValue('label', 'Title');
        $field->setValue('placeholder', "Enter the title");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--title_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--title');
                $value->setValue('entityProperty', $connectedEntityProperty);

            // add value to field
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: description
     */
    private static function getField_subtitle()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--subtitle');
        $field->setValue('label', 'Subtitle');
        $field->setValue('placeholder', "Enter a subtitle");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--subtitle_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--subtitle');
                $value->setValue('entityProperty', $connectedEntityProperty);

            // add value to field
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: placeholder
     */
    private static function getField_description()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK);
        $field->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--description');
        $field->setValue('label', 'Description');
        $field->setValue('placeholder', "Enter a description");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--description_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE.'--description');
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
        $field->setId(CoreConfig::COREFORM_OUTPUT_TITLE.'--groupend');

        // send
        return $field;
    }

}

<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * LayoutGroupStart
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class LayoutGroupStart
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART,
            'visualName' => 'Group start',
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_LAYOUT_GROUPSTART],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART.'--title',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'title',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART.'--title-type',
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
        $form = self::initForm(CoreConfig::COREFORM_LAYOUT_GROUPSTART);

        // setup
        $form->addValue('fields', self::getField_title('Group start'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_label());
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
        $field->setId(CoreConfig::COREFORM_LAYOUT_GROUPEND.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "Add groups in order to make a form more pleasant and scannable for the content editor. Use a 'group end' to close a previously started group of input fields.");

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
        $field->setId(CoreConfig::COREFORM_LAYOUT_GROUPSTART.'--label');
        $field->setValue('label', 'Title');
        $field->setValue('placeholder', "Enter the group's title");
        $field->setValue('description', "");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_LAYOUT_GROUPSTART.'--title_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART.'--title');
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
        $field->setId(CoreConfig::COREFORM_INPUT_TEXTLINE.'--groupend');

        // send
        return $field;
    }


}

<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * EntityPropertyForm_Value_type
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyForm_Value_type
{

    /**
     * Get structure
     */
    public static function getStructure()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE);

        // setup
        $form->addValue('fields', self::getField_title('Configure'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_type());
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
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--groupstart');
        $field->setValue('title', 'Value settings');

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
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--type');
        $field->setValue('label', 'Type');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--type-value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--value');
                $value->setValue('entityproperty', $connectedEntityProperty);

                $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.CoreConfig::DATA_VALUE_TEXTLINE);
                $option->setValue('key', CoreConfig::DATA_VALUE_TEXTLINE);
                $option->setValue('value', CoreConfig::DATA_VALUE_TEXTLINE);
                $value->addValue('options', $option);

                $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--value-options-'.CoreConfig::DATA_VALUE_TEXTBLOCK);
                $option->setValue('key', CoreConfig::DATA_VALUE_TEXTBLOCK);
                $option->setValue('value', CoreConfig::DATA_VALUE_TEXTBLOCK);
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
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE.'--groupend');

        // send
        return $field;
    }

}

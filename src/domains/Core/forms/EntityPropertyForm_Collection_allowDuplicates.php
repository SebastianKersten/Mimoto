<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * EntityPropertyForm_Collection_allowDuplicates
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyForm_Collection_allowDuplicates
{

    /**
     * Get structure
     */
    public static function getStructure()
    {

        // init
        $form = self::initForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES);

        // setup
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_allowDuplicates());
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
     * Get field: groupStart
     */
    private static function getField_groupStart()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES.'--groupstart');
        $field->setValue('title', 'Collection settings');

        // send
        return $field;
    }

    /**
     * Get field: allowDuplicates
     */
    private static function getField_allowDuplicates()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES.'--allowduplicates');
        $field->setValue('label', 'Configuration');
        $field->setValue('option', 'Allow duplicates');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES.'--allowDuplicates-value');
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
     * Get field: groupEnd
     */
    private static function getField_groupEnd()
    {
        // create
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES.'--groupend');

        // send
        return $field;
    }

}

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
        $form = self::initForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES);

        // setup
        $form->addValue('fields', self::getField_title('Configure'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_allowedEntityTypes());
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
     * Get field: allowedEntityTypes
     */
    private static function getField_allowedEntityTypes()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityTypes');
        $field->setValue('label', 'Allowed entity types');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityTypes_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityTypes');
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
                    $option->setValue('key', $entity->getEntityTypeName().'.'.$entity->getId());
                    $option->setValue('value', $entity->getValue('name'));
                    $value->addValue('options', $option);
                }

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

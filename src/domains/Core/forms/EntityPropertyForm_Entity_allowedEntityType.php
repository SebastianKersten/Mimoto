<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;


/**
 * EntityPropertyForm_Entity_allowedEntityType
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyForm_Entity_allowedEntityType
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
        $form->addValue('fields', self::getField_allowedEntityType());
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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE.'--groupstart');
        $field->setValue('title', 'Entity settings');

        // send
        return $field;
    }

    /**
     * Get field: allowedEntityType
     */
    private static function getField_allowedEntityType()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE.'--allowedEntityType');
        $field->setValue('label', 'Allowed entity type');

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE.'--type_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityType');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // load
                $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_ENTITY]);

                $nEntityCount = count($aEntities);
                for ($i = 0; $i < $nEntityCount; $i++)
                {
                    // register
                    $entity = $aEntities[$i];

                    $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                    $option->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE.'--value-options-'.$entity->getId());
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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE.'--groupend');

        // send
        return $field;
    }

}

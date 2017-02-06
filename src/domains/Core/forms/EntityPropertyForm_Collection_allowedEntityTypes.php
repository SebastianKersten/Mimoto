<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;


/**
 * EntityPropertyForm_Collection_allowedEntityTypes
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityPropertyForm_Collection_allowedEntityTypes
{

    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES,
            'name' => CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES, 'type')
            ]
        );
    }


    /**
     * Get NEW structure
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES);

        // setup
        CoreFormUtils::addField_title($form, 'Configure');
        CoreFormUtils::addField_groupStart($form);

        $form->addValue('fields', self::getField_allowedEntityTypes());

        CoreFormUtils::addField_groupEnd($form);

        // send
        return $form;
    }



    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get field: allowedEntityTypes
     */
    private static function getField_allowedEntityTypes()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT, CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES, 'type');
        $field->setValue('label', 'Allowed entity types');

        // 2. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'--allowedEntityTypes');
        $field->setValue('value', $connectedEntityProperty);

        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_ENTITY]);

        $nEntityCount = count($aEntities);
        for ($i = 0; $i < $nEntityCount; $i++)
        {
            // register
            $entity = $aEntities[$i];

            $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
            $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityTypes_value_options-valuesettings-collection-'.$entity->getId());
            $option->setValue('label', $entity->getValue('name'));
            $option->setValue('value', $entity->getEntityTypeName().'.'.$entity->getId());
            $field->addValue('options', $option);
        }

        // send
        return $field;
    }

}

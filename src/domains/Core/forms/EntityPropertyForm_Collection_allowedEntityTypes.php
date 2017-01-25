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
     * Get NEW structure
     */
    public static function getStructure()
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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT);
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--allowedEntityTypes');
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
            $option->setValue('key', $entity->getEntityTypeName().'.'.$entity->getId());
            $option->setValue('value', $entity->getValue('name'));
            $field->addValue('options', $option);
        }

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES.'--allowedEntityTypes_value_validation1');
        $validationRule->setValue('key', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\entities\InputOption;
use Mimoto\Data\MimotoEntity;


/**
 * CoreFormUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CoreFormUtils
{
    //
    const ID_DIVIDER = '--';


    /**
     * Init structure
     */
    public static function initForm($sFormName, $bRealtimeCollaborationMode = false)
    {
        // init
        $form = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM);

        // setup
        $form->setId($sFormName);
        $form->setValue('name', $sFormName);
        $form->setValue('realtimeCollaborationMode', $bRealtimeCollaborationMode);

        // send
        return $form;
    }

    /**
     * Get field: title
     */
    public static function addField_title(MimotoEntity $form, $sTitle, $sSubtitle = '', $sDescription = '')
    {
        // register
        $sFormId = $form->getId();

        // 1. create and setup
        $field = self::createField(CoreConfig::MIMOTO_FORM_OUTPUT_TITLE, $sFormId, 'formtitle');
        $field->setValue('title', $sTitle);
        $field->setValue('subtitle', $sSubtitle);
        $field->setValue('description', $sDescription);

        // store
        $form->addValue('fields', $field);
    }

    /**
     * Get value input
     */
    public static function addFieldsValueInput(MimotoEntity $form, $bShowOptions = false)
    {
        // register
        $sFormId = $form->getId();

        // load
        $sParentEntityId = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $form);


        // #todo

        // 1. get parent (pass from form to field to this form where it is needed!)
        // 2. get parent properties
        // 3. get property id's




        // --- group start

        // create
        $field = self::createField(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART, $sFormId, 'groupstart-value');
        $form->addValue('fields', $field);


        // --- value

        // 1. create and setup field
        $field = self::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, $sFormId, 'value');
        $field->setValue('label', 'Value');
        $field->setValue('description', 'Connect to this entity\'s property');

        // 2. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId($sParentEntityId.'--value');
        $field->setValue('value', $connectedEntityProperty);

        // load
        $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_ENTITY]);
        $nEntityCount = count($aEntities);
        for ($nEntityIndex = 0; $nEntityIndex < $nEntityCount; $nEntityIndex++)
        {
            // register
            $entity = $aEntities[$nEntityIndex];

            // read
            $aEntityProperties = $entity->getValue('properties');
            $nEntityPropertyCount = count($aEntityProperties);
            for ($nEntityPropertyIndex = 0; $nEntityPropertyIndex < $nEntityPropertyCount; $nEntityPropertyIndex++)
            {
                // register
                $entityProperty = $aEntityProperties[$nEntityPropertyIndex];

                // compose
                $sLabel = $entity->getValue('name').'.'.$entityProperty->getValue('name');


                $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--entityProperty_value_options-valuesettings-collection-'.$entityProperty->getId());
                $option->setValue('label', $sLabel);
                $option->setValue('value', $entityProperty->getEntityTypeName().'.'.$entityProperty->getId());

                $field->addValue('options', $option);
            }
        }
        $form->addValue('fields', $field);


        // verify
        if ($bShowOptions)
        {
            // 1. create and setup field
            $field = self::createField(CoreConfig::MIMOTO_FORM_INPUT_LIST, $sFormId, 'options');
            $field->setValue('label', 'Options');
            $field->setValue('description', 'Provide the options the user can pick from');

            // 2. connect to property
            $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
            $connectedEntityProperty->setId($sParentEntityId . '--options');
            $field->setValue('value', $connectedEntityProperty);


            $itemForm = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
            $itemForm->setId(CoreConfig::MIMOTO_FORM_INPUTOPTION.'--options-item1');
            $itemForm->setValue('label', 'Label');

            // connect form
            $connectedForm = Mimoto::service('forms')->getFormByName(CoreConfig::COREFORM_FORM_INPUTOPTION);
            $itemForm->setValue('form', $connectedForm);
            $field->addValue('options', $itemForm);


            // 1. settings
            // 2. add mapping as option
            // 3. set options (sortable |mapping | url | target (popup/page)


            $form->addValue('fields', $field);
        }

        // 1. create and setup field
        $field = self::createField(CoreConfig::MIMOTO_FORM_INPUT_LIST, $sFormId, 'validation');
        $field->setValue('label', 'Validation');
        $field->setValue('description', 'Add your validation rules');

        // 2. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId($sParentEntityId . '--validation');
        $field->setValue('value', $connectedEntityProperty);

        $itemForm = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $itemForm->setId(CoreConfig::MIMOTO_FORM_INPUTOPTION.'--validation-item1');
        $itemForm->setValue('label', 'Label');

        // connect form
        $connectedForm = Mimoto::service('forms')->getFormByName(CoreConfig::COREFORM_FORM_INPUTVALIDATION);
        $itemForm->setValue('form', $connectedForm);
        $field->addValue('options', $itemForm);

        // 1. add mapping as option
        // 2. set options (sortable |mapping | url | target (popup/page)

        $form->addValue('fields', $field);


        // --- group end

        // create
        $field = self::createField(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND, $sFormId, 'groupend-value');
        $form->addValue('fields', $field);
    }

    /**
     * Get field: groupStart
     */
    public static function addField_groupStart(MimotoEntity $form, $sTitle = null)
    {
        // register
        $sFormId = $form->getId();

        // 1. create
        $field = self::createField(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART, $sFormId, 'groupstart');

        // compose
        if (!empty($sTitle)) $field->setValue('title', $sTitle);

        // store
        $form->addValue('fields', $field);
    }

    /**
     * Get field: groupEnd
     */
    public static function addField_groupEnd(MimotoEntity $form)
    {
        // register
        $sFormId = $form->getId();

        // 1. create
        $field = self::createField(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND, $sFormId, 'groupend');

        // store
        $form->addValue('fields', $field);
    }


    /**
     * Get field: checkbox
     */
    public static function addField_checkbox(MimotoEntity $form, $sFieldId, $sEntityPropertyId, $sLabel, $sOption)
    {
        // register
        $sFormId = $form->getId();

        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX);
        $field->setId($sFormId.self::ID_DIVIDER.$sFieldId);



        $field->setValue('label', $sLabel);
        $field->setValue('option', $sOption);

        // 2. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId($sEntityPropertyId);
        $field->setValue('value', $connectedEntityProperty);

        // store
        $form->addValue('fields', $field);
    }

    /**
     * Get field: label
     */
    public static function addField_textline(MimotoEntity $form, $sFieldId, $sEntityPropertyId, $sLabel = '', $sPlaceholder = '', $sDescription = '', $sPrefix = '')
    {
        // register
        $sFormId = $form->getId();

        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId($sFormId.self::ID_DIVIDER.$sFieldId);
        $field->setValue('label', $sLabel);
        $field->setValue('placeholder', $sPlaceholder);
        $field->setValue('description', $sDescription);
        $field->setValue('prefix', $sPrefix);

        // 2. connect to property
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
        $connectedEntityProperty->setId($sEntityPropertyId);
        $field->setValue('value', $connectedEntityProperty);

        // store
        $form->addValue('fields', $field);

        // 3. send
        return $field;
    }

    /**
     * Set label validation
     */
    public static function setLabelValidation($field, $sFieldId)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId($sFieldId.'_value_validation1');
        $validationRule->setValue('value', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Please supply a label for the field");
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    public static function createField($sFieldType, $sFormId, $sFieldName)
    {
        // create
        $field = Mimoto::service('data')->create($sFieldType);

        // setup
        $field->setId(self::composeFieldName($sFormId, $sFieldName));

        // send
        return $field;
    }

    public static function composeFieldName($sFormId, $sFieldName)
    {
        // compose
        $sFieldName = $sFormId.self::ID_DIVIDER.$sFieldName;

        // send
        return $sFieldName;
    }

}

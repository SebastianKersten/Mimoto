<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\entities\Input;
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
    public static function addFieldsValueInput(MimotoEntity $form, $eInstance = null)
    {
        // register
        $sFormId = $form->getId();


        // load
        $sParentEntityId = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $form);


        // init
        $aParentEntities = [];


        // verify
        if (!empty($eInstance))
        {
            // collect
            $eParentForm = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_FORM, CoreConfig::MIMOTO_FORM.'--fields', $eInstance);
            $eParentEntity = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $eParentForm);

            // register
            $aParentEntities = array($eParentEntity);
        }
        else
        {
            // init
            $selection = Mimoto::service('selection')->create();

            // setup
            $selection->setType(CoreConfig::MIMOTO_ENTITY);

            // select
            $aParentEntities = Mimoto::service('data')->select($selection);
        }



        // --- group start

        // create
        $field = self::createField(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART, $sFormId, 'groupstart-value');
        $form->addValue('fields', $field);


        // --- value

        // 1. create and setup field
        $field = self::createField(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN, $sFormId, 'value');
        $field->setValue('label', 'Connect to property');
        $field->setValue('description', 'Connect to this entity\'s property');

        // 2. connect to property
        self::addValueToField($field, $sParentEntityId, 'value');


        // 1. loop all


        $nParentEntityCount = count($aParentEntities);
        for ($nParentEntityIndex = 0; $nParentEntityIndex < $nParentEntityCount; $nParentEntityIndex++)
        {
            // register
            $eParentEntity = $aParentEntities[$nParentEntityIndex];

            // read
            $aEntityProperties = $eParentEntity->getValue('properties');
            $nEntityPropertyCount = count($aEntityProperties);
            for ($nEntityPropertyIndex = 0; $nEntityPropertyIndex < $nEntityPropertyCount; $nEntityPropertyIndex++)
            {
                // register
                $entityProperty = $aEntityProperties[$nEntityPropertyIndex];

                // compose
                $sLabel = (!empty($eInstance)) ? $entityProperty->getValue('name') : $eParentEntity->getValue('name').'.'.$entityProperty->getValue('name');

                // create input options
                $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--entityProperty_value_options-valuesettings-collection-'.$entityProperty->getId());
                $option->setValue('label', $sLabel);
                $option->setValue('value', $entityProperty->getEntityTypeName().'.'.$entityProperty->getId());

                // store input option
                $field->addValue('options', $option);
            }
        }

        // store
        $form->addValue('fields', $field);

        // create
        $field = self::createField(CoreConfig::MIMOTO_FORM_INPUT_LIST, $sFormId, 'validation');

        // setup
        $field->setValue('label', 'Validation');
        $field->setValue('description', 'Add your validation rules');

        // connect
        self::addValueToField($field, $sParentEntityId, 'validation');

        // configure
        $itemForm = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $itemForm->setId(CoreConfig::MIMOTO_FORM_INPUTOPTION.'--validation-item1');
        $itemForm->setValue('label', 'Label');

        // connect form
        $connectedForm = Mimoto::service('input')->getFormByName(CoreConfig::COREFORM_FORM_INPUTVALIDATION);
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

    public static function addField_optionsForListConfig(MimotoEntity $form)
    {
        // register
        $sFormId = $form->getId();

        // load
        $sParentEntityId = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $form);

        // create
        $field = self::createField(CoreConfig::MIMOTO_FORM_INPUT_LIST, $sFormId, 'options');

        // setup
        $field->setValue('label', 'Options');
        $field->setValue('description', 'Provide the options the user can pick from');

        // connect
        self::addValueToField($field, $sParentEntityId, 'options');


        // configure
        $itemForm = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTOPTION);
        $itemForm->setId(CoreConfig::MIMOTO_FORM_INPUTOPTION.'--options-item1');
        $itemForm->setValue('label', 'Label');

        // connect form
        $connectedForm = Mimoto::service('input')->getFormByName(CoreConfig::COREFORM_INPUTOPTION);
        $itemForm->setValue('form', $connectedForm);
        $field->addValue('options', $itemForm);


        // 1. inputoption (hard value)
        // 2. selection

        // 1. settings
        // 2. add mapping as option
        // 3. set options (sortable |mapping | url | target (popup/page)

        $form->addValue('fields', $field);
    }

    /**
     * Get field: groupStart
     */
    public static function addField_groupStart(MimotoEntity $form, $sTitle = null, $sGroupId = '')
    {
        // register
        $sFormId = $form->getId();

        // 1. create
        $field = self::createField(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART, $sFormId, 'groupstart');
        $field->setId(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART.$sGroupId);

        // compose
        if (!empty($sTitle)) $field->setValue('title', $sTitle);

        // store
        $form->addValue('fields', $field);
    }

    /**
     * Get field: groupEnd
     */
    public static function addField_groupEnd(MimotoEntity $form, $sGroupId = '')
    {
        // register
        $sFormId = $form->getId();

        // 1. create
        $field = self::createField(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND, $sFormId, 'groupend');
        $field->setId(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND.$sGroupId);

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
     * Get field: label
     */
    public static function addField_textblock(MimotoEntity $form, $sFieldId, $sEntityPropertyId, $sLabel = '', $sPlaceholder = '', $sDescription = '', $sPrefix = '')
    {
        // register
        $sFormId = $form->getId();

        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK);
        $field->setId($sFormId.self::ID_DIVIDER.$sFieldId);
        $field->setValue('label', $sLabel);
        $field->setValue('placeholder', $sPlaceholder);
        $field->setValue('description', $sDescription);

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
     * Get field: label
     */
    public static function addField_image(MimotoEntity $form, $sFieldId, $sEntityPropertyId, $sLabel = '', $sDescription = '')
    {
        // register
        $sFormId = $form->getId();

        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_IMAGE);
        $field->setId($sFormId.self::ID_DIVIDER.$sFieldId);
        $field->setValue('label', $sLabel);
        $field->setValue('description', $sDescription);

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

    /**
     * Add the reference of a entity's property to the value of the input field
     * @param MimotoEntity $field
     * @param $sParentEntityId
     * @param $sPropertyName
     * @return MimotoEntity
     */
    public static function addValueToField(MimotoEntity $field, $sParentEntityId, $sPropertyName)
    {
        // 1. create
        $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);

        // 2. define
        $connectedEntityProperty->setId($sParentEntityId.self::ID_DIVIDER.$sPropertyName);

        // 3. connect
        $field->setValue('value', $connectedEntityProperty);

        // 4. send
        return $field;
    }

}

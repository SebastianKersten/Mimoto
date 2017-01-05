<?php

// classpath
namespace Mimoto\Core\forms;

// Mimoto classes
use Mimoto\Core\CoreConfig;


/**
 * ContentSectionForm
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ContentSectionForm
{

    /**
     * Get NEW structure
     */
    public static function getStructureNew()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_CONTENTSECTION_NEW);

        // setup
        $form->addValue('fields', self::getField_title('Add new content section'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
        //$form->addValue('fields', self::getField_type());
        $form->addValue('fields', self::getField_form());
        //$form->addValue('fields', self::getField_isHiddenFromMenu());
        $form->addValue('fields', self::getField_groupEnd());

        // send
        return $form;
    }

    /**
     * Get EDIT structure
     */
    public static function getStructureEdit()
    {
        // init
        $form = self::initForm(CoreConfig::COREFORM_CONTENTSECTION_EDIT);

        // setup
        $form->addValue('fields', self::getField_title('Edit content section'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
        //$form->addValue('fields', self::getField_type());
        $form->addValue('fields', self::getField_form());

        //$form->addValue('fields', self::getField_isHiddenFromMenu());
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
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--title');
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
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART);
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--groupstart');

        // send
        return $field;
    }

    /**
     * Get field: name
     */
    private static function getField_name()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Enter the name");
        $field->setValue('description', "The entity is preferably unique");

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_CONTENTSECTION.'--name_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3a. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--name');
                $value->setValue('entityproperty', $connectedEntityProperty);

                // 3b. validation rule #1
                $validationRule = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_CONTENTSECTION.'--name_value_validation1');
                $validationRule->setValue('key', 'maxchars');
                $validationRule->setValue('value', 25);
                $validationRule->setValue('errorMessage', 'No more than 25 characters');
                $value->addValue('validation', $validationRule);

            // add value to field
            $field->setValue('value', $value);

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
        $field->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type');
        $field->setValue('label', 'Type');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3a. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITYPROPERTY.'--type');
                $value->setValue('entityproperty', $connectedEntityProperty);

                // 3b. set options
                $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-value');
                $option->setValue('key', 'single');
                $option->setValue('value', 'Single');
                $value->addValue('options', $option);

                $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::COREFORM_ENTITYPROPERTY.'--type_value_options-entity');
                $option->setValue('key', 'group');
                $option->setValue('value', 'Group');
                $value->addValue('options', $option);

            // add
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: extends
     */
    private static function getField_form()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN);
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--form');
        $field->setValue('label', 'Form');
        $field->setValue('description', "What form would you like to use?");

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_CONTENTSECTION.'--form_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_ENTITY.'--form');
                $value->setValue('entityproperty', $connectedEntityProperty);

                // load
                $aEntities = $GLOBALS['Mimoto.Data']->find(['type' => CoreConfig::MIMOTO_FORM]);

                $nEntityCount = count($aEntities);
                for ($i = 0; $i < $nEntityCount; $i++)
                {
                    // register
                    $entity = $aEntities[$i];

                    //output('$entity->getValue(\'name\')', $entity->getValue('name'));
                    $option = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                    $option->setId(CoreConfig::COREFORM_CONTENTSECTIONP.'--extends_value_options-valuesettings-collection-'.$entity->getId());
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
     * Get field: isAbstract
     */
    private static function getField_isHidden()
    {
        // 1. create and setup field
        $field = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX);
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--isHidden');
        $field->setValue('label', 'Configuration');
        $field->setValue('option', 'Skip dedicated table for this entity');

            // 2. setup value
            $value = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_CONTENTSECTION.'--isHidden');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = $GLOBALS['Mimoto.Data']->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--isHidden');
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
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--groupend');

        // send
        return $field;
    }
}

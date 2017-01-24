<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * ContentSection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ContentSection
{
    const TYPE_ITEM = 'item';
    const TYPE_GROUP = 'group';


    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_CONTENTSECTION,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_CONTENTSECTION,
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_CONTENTSECTION],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--name',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'name',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--name-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--form',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'form',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'id' => CoreConfig::MIMOTO_FORM_INPUT.'--form-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityType',
                            'type' => 'value',
                            'value' => CoreConfig::MIMOTO_FORM
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--isHiddenFromMenu',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'isHiddenFromMenu',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--isHiddenFromMenu-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--type',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'type',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_CONTENTSECTION.'--type-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITY.'--contentItem',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'contentItem',
                    'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
                    'settings' => [
                        'allowedEntityType' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--contentItem-allowedEntityType',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityType',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => CoreConfig::WILDCARD
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_ENTITY.'--contentItems',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'contentItems',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--contentItems-allowedEntityTypes',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::WILDCARD]
                        ),
                        'allowDuplicates' => (object) array(
                            'id' => CoreConfig::MIMOTO_ENTITY.'--contentItems-allowDuplicates',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                )
            ]
        );
    }

    public static function getData()
    {
        // define
        $aCoreComponents = [

            // dashboard

            (object) array(
                'name' => 'Mimoto.CMS_dashboard_Overview',
                'file' => 'MimotoCMS/components/pages/dashboard/Overview.twig',
                'conditionals' => []
            ),


            // entities

            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityOverview',
                'file' => 'MimotoCMS/components/pages/entities/EntityOverview/EntityOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityOverview_ListItem',
                'file' => 'MimotoCMS/components/pages/entities/EntityOverview/ListItem/ListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityDetail.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-EntityProperty',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityProperty/EntityProperty.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-EntityPropertySetting',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertySetting/EntityPropertySetting.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-EntityPropertySettingAllowedEntityType',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertySettingAllowedEntityType/EntityPropertySettingAllowedEntityType.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail_EntityPropertyExample',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertyExample/EntityPropertyExample.twig',
                'conditionals' => []
            ),



            // components

            (object) array(
                'name' => 'Mimoto.CMS_components_ComponentOverview',
                'file' => 'MimotoCMS/components/pages/components/ComponentOverview/ComponentOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_components_ComponentOverview_ListItem',
                'file' => 'MimotoCMS/components/pages/components/ComponentOverview/ListItem/ListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_components_ComponentDetail',
                'file' => 'MimotoCMS/components/pages/components/ComponentDetail/ComponentDetail.twig',
                'conditionals' => []
            ),


            // content

            (object) array(
                'name' => 'Mimoto.CMS_content_ContentOverview',
                'file' => 'MimotoCMS/content/pages/content/Overview.twig',
                'conditionals' => []
            ),


            // actions

            (object) array(
                'name' => 'Mimoto.CMS_actions_ActionOverview',
                'file' => 'MimotoCMS/components/pages/actions/Overview.twig',
                'conditionals' => []
            ),


            // users

            (object) array(
                'name' => 'Mimoto.CMS_users_UserOverview',
                'file' => 'MimotoCMS/components/pages/users/Overview.twig',
                'conditionals' => []
            ),


            // forms

            (object) array(
                'name' => 'Mimoto.CMS_forms_FormOverview',
                'file' => 'MimotoCMS/components/pages/forms/FormOverview/FormOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormOverview_ListItem',
                'file' => 'MimotoCMS/components/pages/forms/FormOverview/ListItem/ListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail',
                'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormDetail.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail_TypeSelector',
                'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormFieldTypeSelector/FormFieldTypeSelector.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail_TypeSelector_ListItem',
                'file' => 'MimotoCMS/components/pages/forms/FormDetaiFormFieldTypeSelector/ListItem/ListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail-FormFieldWrapper',
                'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormFieldWrapper/FormFieldWrapper.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail-FormFieldValue',
                'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormField/FormFieldValue/FormFieldValue.twig',
                'conditionals' => []
            ),


            // forms - page and popup

            (object) array(
                'name' => 'Mimoto.CMS_form_Popup',
                'file' => 'MimotoCMS/components/forms/FormPopup.twig',
                'conditionals' => []
            ),(object) array(
                'name' => 'Mimoto.CMS_form_Page',
                'file' => 'MimotoCMS/components/forms/FormPage.twig',
                'conditionals' => []
            ),



            // inputs

            (object) array(
                'name' => '_MimotoAimless__interaction__form_output_title',
                'file' => 'MimotoCMS/components/forms/output/Title/Title.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_layout_groupstart',
                'file' => 'MimotoCMS/components/forms/layout/GroupStart/GroupStart.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_layout_groupend',
                'file' => 'MimotoCMS/components/forms/layout/GroupEnd/GroupEnd.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_input_textline',
                'file' => 'MimotoCMS/components/forms/input/Textline/Textline.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_input_checkbox',
                'file' => 'MimotoCMS/components/forms/input/Checkbox/Checkbox.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_input_multiselect',
                'file' => 'MimotoCMS/components/forms/input/MultiSelect/MultiSelect.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_input_radiobutton',
                'file' => 'MimotoCMS/components/forms/input/Radiobutton/Radiobutton.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_input_dropdown',
                'file' => 'MimotoCMS/components/forms/input/Dropdown/Dropdown.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_layout_divider',
                'file' => 'MimotoCMS/components/forms/layout/Divider/Divider.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_input_list',
                'file' => 'MimotoCMS/components/forms/input/List/List.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_input_listItem',
                'file' => 'MimotoCMS/components/forms/input/ListItem/ListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_input_image',
                'file' => 'MimotoCMS/components/forms/input/Image/Image.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => '_MimotoAimless__interaction__form_input_video',
                'file' => 'MimotoCMS/components/forms/input/Video/Video.twig',
                'conditionals' => []
            ),


            // notification center

            (object) array(
                'name' => 'Mimoto.CMS_notifications_NotificationOverview',
                'file' => 'MimotoCMS/components/pages/notifications/NotificationOverview/NotificationOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_notifications_NotificationOverviewSmall',
                'file' => 'MimotoCMS/components/pages/notifications/NotificationOverviewSmall/NotificationOverviewSmall.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_notifications_Notification',
                'file' => 'MimotoCMS/components/pages/notifications/Notification/Notification.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_notifications_NotificationSmall',
                'file' => 'MimotoCMS/components/pages/notifications/NotificationSmall/NotificationSmall.twig',
                'conditionals' => []
            ),


            // modules

            (object) array(
                'name' => 'Mimoto.CMS.ListItemModule',
                'file' => 'MimotoCMS/modules/ListItemModule/ListItemModule.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS.ButtonModule',
                'file' => 'MimotoCMS/modules/ButtonModule/ButtonModule.twig',
                'conditionals' => []
            ),

        ];

        // send
        return $aCoreComponents;
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
        $form = self::initForm(CoreConfig::COREFORM_CONTENTSECTION);

        // setup
        $form->addValue('fields', self::getField_title('Content section'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
        $form->addValue('fields', self::getField_type());
        $form->addValue('fields', self::getField_form());
        $form->addValue('fields', self::getField_isHiddenFromMenu());
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
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "With content sections you allow different groups of users to enter actual content via the CMS. Content sections are added to the side menu by default but can be hidden if their only purpose is to use them as centralized helper values.");

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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Enter the name");
        $field->setValue('description', "The content name is preferably unique");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_CONTENTSECTION.'--name_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3a. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--name');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // 3b. validation rule #1
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE_VALIDATION);
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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON);
        $field->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--type');
        $field->setValue('label', 'Type');

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--type_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3a. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--type');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // 3b. set options
                $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--type_value_options-value');
                $option->setValue('key', ContentSection::TYPE_ITEM);
                $option->setValue('value', 'Item');
                $value->addValue('options', $option);

                $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                $option->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--type_value_options-entity');
                $option->setValue('key', ContentSection::TYPE_GROUP);
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
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN);
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--form');
        $field->setValue('label', 'Form');
        $field->setValue('description', "What form would you like to use?");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_CONTENTSECTION.'--form_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--form');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // load
                $aEntities = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_FORM]);

                $nEntityCount = count($aEntities);
                for ($i = 0; $i < $nEntityCount; $i++)
                {
                    // register
                    $entity = $aEntities[$i];

                    //output('$entity->getValue(\'name\')', $entity->getValue('name'));
                    $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUESETTING);
                    $option->setId(CoreConfig::COREFORM_CONTENTSECTION.'--form_value_options-valuesettings-collection-'.$entity->getId());
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
     * Get field: isHiddenFromMenu
     */
    private static function getField_isHiddenFromMenu()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX);
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--isHiddenFromMenu');
        $field->setValue('label', 'Visibility');
        $field->setValue('option', 'Hide from menu');

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_CONTENTSECTION.'--isHiddenFromMenu');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_CONTENTSECTION.'--isHiddenFromMenu');
                $value->setValue('entityProperty', $connectedEntityProperty);

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
        $field->setId(CoreConfig::COREFORM_CONTENTSECTION.'--groupend');

        // send
        return $field;
    }

}

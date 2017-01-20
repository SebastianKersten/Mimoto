<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * Component
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class Component
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_COMPONENT,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_COMPONENT,
            'extends' => null,
            'forms' => [CoreConfig::COREFORM_COMPONENT],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT.'--name',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'name',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_COMPONENT.'--name-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT.'--file',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'file',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'id' => CoreConfig::MIMOTO_COMPONENT.'--file-type',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT.'--conditionals',
                    'created' => CoreConfig::EPOCH,
                    // ---
                    'name' => 'conditionals',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'id' => CoreConfig::MIMOTO_COMPONENT.'--conditionals-allowedEntityTypes',
                            'created' => CoreConfig::EPOCH,
                            // ---
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_COMPONENTCONDITIONAL]
                        ),
                        'allowDuplicates' => (object) array(
                            'id' => CoreConfig::MIMOTO_COMPONENT.'--conditionals-allowDuplicates',
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

            // interface

            (object) array(
                'name' => 'MimotoCMS_interface_Menu_MenuButton',
                'file' => 'MimotoCMS/components/interface/Menu/MenuButton/MenuButton.twig',
                'conditionals' => []
            ),


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
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-Component',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/Component/Component.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-Form',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/Form/Form.twig',
                'conditionals' => []
            ),



            // content sections

            (object) array(
                'name' => 'Mimoto.CMS_contentsections_ContentSectionOverview',
                'file' => 'MimotoCMS/components/pages/contentsections/ContentSectionOverview/ContentSectionOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_contentsections_ContentSectionOverview_ListItem',
                'file' => 'MimotoCMS/components/pages/contentsections/ContentSectionOverview/ListItem/ListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_contentsections_ContentSectionDetail',
                'file' => 'MimotoCMS/components/pages/contentsections/ContentSectionDetail/ContentSectionDetail.twig',
                'conditionals' => []
            ),


            // content

            (object) array(
                'name' => 'Mimoto.CMS_contents_ContentOverview',
                'file' => 'MimotoCMS/components/pages/content/ContentOverview/ContentOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_contents_ContentOverview_ListItem',
                'file' => 'MimotoCMS/components/pages/content/ContentOverview/ListItem/ListItem.twig',
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
                'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormFieldWrapper/FormFieldValue/FormFieldValue.twig',
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
                'name' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
                'file' => 'MimotoCMS/components/forms/output/Title/Title.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART,
                'file' => 'MimotoCMS/components/forms/layout/GroupStart/GroupStart.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND,
                'file' => 'MimotoCMS/components/forms/layout/GroupEnd/GroupEnd.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER,
                'file' => 'MimotoCMS/components/forms/layout/Divider/Divider.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
                'file' => 'MimotoCMS/components/forms/input/Textline/Textline.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK,
                'file' => 'MimotoCMS/components/forms/input/Textblock/Textblock.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF,
                'file' => 'MimotoCMS/components/forms/input/Textblock/Textblock.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX,
                'file' => 'MimotoCMS/components/forms/input/Checkbox/Checkbox.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT,
                'file' => 'MimotoCMS/components/forms/input/MultiSelect/MultiSelect.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON,
                'file' => 'MimotoCMS/components/forms/input/Radiobutton/Radiobutton.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN,
                'file' => 'MimotoCMS/components/forms/input/Dropdown/Dropdown.twig',
                'conditionals' => []
            ),

            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_LIST,
                'file' => 'MimotoCMS/components/forms/input/List/List.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_LISTITEM,
                'file' => 'MimotoCMS/components/forms/input/ListItem/ListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_IMAGE,
                'file' => 'MimotoCMS/components/forms/input/Image/Image.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_VIDEO,
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
            (object) array(
                'name' => 'Mimoto.CMS.TabmenuModule',
                'file' => 'MimotoCMS/modules/TabmenuModule/TabmenuModule.twig',
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
        $form = self::initForm(CoreConfig::COREFORM_COMPONENT);

        // setup
        $form->addValue('fields', self::getField_title('Component'));
        $form->addValue('fields', self::getField_groupStart());
        $form->addValue('fields', self::getField_name());
        $form->addValue('fields', self::getField_file());
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
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--title');
        $field->setValue('title', $sTitle);
        $field->setValue('description', "The key element in presenting data is the 'component'. These are twig files that use the Aimless protocol to read and render the data, with the support of realtime updates to any client.");

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
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--groupstart');

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
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--name');
        $field->setValue('label', 'Name');
        $field->setValue('placeholder', "Component name");
        $field->setValue('description', "The component name could be unique, or used multiple times using conditionals");

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_COMPONENT.'--name_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_COMPONENT.'--name');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // validation rule #1
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--name_value_validation1');
                $validationRule->setValue('key', 'maxchars');
                $validationRule->setValue('value', 50);
                $validationRule->setValue('errorMessage', 'No more than 10 characters');
                $value->addValue('validation', $validationRule);

                // validation rule #2
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--name_value_validation2');
                $validationRule->setValue('key', 'minchars');
                $validationRule->setValue('value', 1);
                $validationRule->setValue('errorMessage', "Value can't be empty");
                $value->addValue('validation', $validationRule);

                // validation rule #3
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--name_value_validation3');
                $validationRule->setValue('key', 'regex_custom');
                $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
                $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
                $value->addValue('validation', $validationRule);

                // validation rule #4
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--name_value_validation4');
                $validationRule->setValue('key', 'api');
                $validationRule->setValue('value', '/mimoto.cms/entityproperty/validatename');
                $validationRule->setValue('errorMessage', 'The name needs to be unique');
                $value->addValue('validation', $validationRule);

            // add value to field
            $field->setValue('value', $value);

        // send
        return $field;
    }

    /**
     * Get field: name
     */
    private static function getField_file()
    {
        // 1. create and setup field
        $field = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE);
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--file');
        $field->setValue('label', 'Twig file');
        $field->setValue('placeholder', "your_template_file.twig");
        $field->setValue('description', "");
        $field->setValue('prefix', Mimoto::value('ProjectConfig.twigroot'));

            // 2. setup value
            $value = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUE);
            $value->setId(CoreConfig::COREFORM_COMPONENT.'--file_value');
            $value->setValue(CoreConfig::INPUTVALUE_VARTYPE, CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY);

                // 3. connect to property
                $connectedEntityProperty = Mimoto::service('data')->create(CoreConfig::MIMOTO_ENTITYPROPERTY);
                $connectedEntityProperty->setId(CoreConfig::MIMOTO_COMPONENT.'--file');
                $value->setValue('entityProperty', $connectedEntityProperty);

                // validation rule #1
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--file_value_validation1');
                $validationRule->setValue('key', 'maxchars');
                $validationRule->setValue('value', 50);
                $validationRule->setValue('errorMessage', 'No more than 10 characters');
                $value->addValue('validation', $validationRule);

                // validation rule #2
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--file_value_validation2');
                $validationRule->setValue('key', 'minchars');
                $validationRule->setValue('value', 1);
                $validationRule->setValue('errorMessage', "Value can't be empty");
                $value->addValue('validation', $validationRule);

                // validation rule #3
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--file_value_validation3');
                $validationRule->setValue('key', 'regex_custom');
                $validationRule->setValue('value', '^[a-zA-Z0-9][a-zA-Z0-9_-]*$');
                $validationRule->setValue('errorMessage', 'No characters other than a-z, A-Z and 0-9 allowed');
                $value->addValue('validation', $validationRule);

                // validation rule #4
                $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALUEVALIDATION);
                $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--file_value_validation4');
                $validationRule->setValue('key', 'api');
                $validationRule->setValue('value', '/mimoto.cms/entityproperty/validatename');
                $validationRule->setValue('errorMessage', 'The name needs to be unique');
                $value->addValue('validation', $validationRule);

            // add value to field
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
        $field->setId(CoreConfig::COREFORM_COMPONENT.'--groupend');

        // send
        return $field;
    }
}

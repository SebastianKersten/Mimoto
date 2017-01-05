<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


/**
 * ContentSection
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ContentSection
{

    public static function getStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_CONTENTSECTION,
            'created' => CoreConfig::EPOCH,
            // ---
            'name' => CoreConfig::MIMOTO_CONTENTSECTION,
            'extends' => null,
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

}

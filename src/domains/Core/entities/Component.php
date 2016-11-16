<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\CoreConfig;


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
                            'type' => CoreConfig::DATA_TYPE_VALUE,
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
                            'type' => CoreConfig::DATA_TYPE_VALUE,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
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



            // components

            (object) array(
                'name' => 'Mimoto.CMS_components_ComponentOverview',
                'file' => 'MimotoCMS/components/pages/components/ComponentOverview/ComponentOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_components_ComponentListItem',
                'file' => 'MimotoCMS/components/pages/components/ComponentListItem/ComponentListItem.twig',
                'conditionals' => []
            ),


            // components

            (object) array(
                'name' => 'Mimoto.CMS_content_ContentOverview',
                'file' => 'MimotoCMS/components/pages/content/Overview.twig',
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
                'name' => 'Mimoto.CMS_forms_FormListItem',
                'file' => 'MimotoCMS/components/pages/forms/FormListItem/FormListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail',
                'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormDetail.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FieldListItem',
                'file' => 'MimotoCMS/components/pages/forms/FieldListItem/FieldListItem.twig',
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

        ];

        // send
        return $aCoreComponents;
    }

}

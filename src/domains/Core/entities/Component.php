<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
use Mimoto\Core\Validation;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Core\CoreFormUtils;
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
            // ---
            'name' => CoreConfig::MIMOTO_COMPONENT,
            'extends' => null,
            'forms' => [CoreConfig::MIMOTO_COMPONENT],
            'properties' => [
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT.'--name',
                    // ---
                    'name' => 'name',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        ),
                        'validation' => (object) array(
                            'type' => Validation::UNIQUE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT.'--type',
                    // ---
                    'name' => 'type',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        ),
                        'allowedValues' => array(
                            (object) array(
                                'label' => 'Component', // replace by translation
                                'value' => 'component',
                                'default' => true
                            ),
                            (object) array(
                                'label' => 'Layout', // replace by translation
                                'value' => 'layout'
                            ),
                            (object) array(
                                'label' => 'Input field', // replace by translation
                                'value' => 'input'
                            )
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT.'--templates',
                    // ---
                    'name' => 'templates',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_COMPONENTTEMPLATE]
                        ),
                        'allowDuplicates' => (object) array(
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
                'name' => 'MimotoCMS_layout_Login',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/base_login.twig',
                        'conditionals' => []
                    )
                ]

            ),
            (object) array(
                'name' => 'MimotoCMS_layout_Page',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/base_page.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_layout_Popup',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/base_popup.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_layout_Form',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/Form.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_layout_Selection',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/layouts/selection/Selection.twig',
                        'conditionals' => []
                    )
                ]
            ),


            (object) array(
                'name' => 'MimotoCMS_interface_Menu_MenuButton',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/interface/Menu/MenuButton/MenuButton.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // dashboard

            (object) array(
                'name' => 'Mimoto.CMS_dashboard_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/dashboard/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // heartbeat

            (object) array(
                'name' => 'Mimoto.CMS_heartbeat_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/heartbeat/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // entities

            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/Overview/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityOverview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/Overview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-EntityProperty',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityProperty/EntityProperty.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-EntityPropertySetting',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertySetting/EntityPropertySetting.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-EntityPropertySettingAllowedEntityType',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertySettingAllowedEntityType/EntityPropertySettingAllowedEntityType.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-EntityPropertySettingFormattingOption',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertySettingFormattingOption/EntityPropertySettingFormattingOption.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_entities_EntityDetail_EntityInstance',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityInstance/EntityInstance.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail_EntityPropertyExample',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertyExample/EntityPropertyExample.twig',
                        'conditionals' => []
                    )
                ]
            ),
//            (object) array(
//                'name' => 'Mimoto.CMS_entities_EntityDetail-ComponentListItem',
//                'templates' => [
//                    (object) array(
//                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/ComponentListItem/ComponentListItem.twig',
//                        'conditionals' => []
//                    )
//                ]
//            ),
//            (object) array(
//                'name' => 'Mimoto.CMS_entities_EntityDetail-ComponentDetail',
//                'templates' => [
//                    (object) array(
//                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/ComponentDetail/ComponentDetail.twig',
//                        'conditionals' => []
//                    )
//                ]
//            ),
//            (object) array(
//                'name' => 'Mimoto.CMS_entities_EntityDetail-ComponentConditional',
//                'templates' => [
//                    (object) array(
//                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/ComponentDetail/ComponentConditional/ComponentConditional.twig',
//                        'conditionals' => []
//                    )
//                ]
//            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-Form',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/Form/Form.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // selections

            (object) array(
                'name' => 'Mimoto.CMS_selections_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/selections/Overview/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_selections_Overview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/selections/Overview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_selections_Detail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/selections/Detail/Detail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_selections_Detail-Rule',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/selections/Detail/Rule/Rule.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // configuration
            (object) array(
                'name' => 'Mimoto.CMS_configuration_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/Configuration.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // formatting options

            (object) array(
                'name' => 'Mimoto.CMS_formattingoptions_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/formattingoptions/Overview/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_formattingoptions_Overview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/formattingoptions/Overview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_configuration_formattingoptions_Detail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/formattingoptions/Detail/Detail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_configuration_formattingoptions_Detail-Attribute',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/formattingoptions/Detail/Attribute/Attribute.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // user roles

            (object) array(
                'name' => 'Mimoto.CMS_configuration_userroles_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/userroles/Overview/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_configuration_userroles_Overview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/userroles/Overview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_configuration_userroles_Detail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/userroles/Detail/Detail.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // components

            (object) array(
                'name' => 'MimotoCMS_components_ComponentOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/ComponentOverview/ComponentOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_components_ComponentOverview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/ComponentOverview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_components_ComponentOverview_ListItemLayout',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/ComponentOverview/ListItemLayout/ListItemLayout.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_components_ComponentDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/ComponentDetail/ComponentDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_components_ComponentDetail-Template',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/ComponentDetail/ComponentTemplate/ComponentTemplate.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_components_ComponentDetail-Conditional',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/ComponentDetail/ComponentConditional/ComponentConditional.twig',
                        'conditionals' => []
                    )
                ]
            ),

            (object) array(
                'name' => 'Mimoto.CMS_components_LayoutDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/LayoutDetail/LayoutDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),

            (object) array(
                'name' => 'MimotoCMS_components_LayoutDetail-Container',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/LayoutDetail/LayoutContainer/LayoutContainer.twig',
                        'conditionals' => []
                    )
                ]
            ),


            (object) array(
                'name' => 'MimotoCMS_components_selection_SelectableItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/selection/SelectableItem/SelectableItem.twig',
                        'conditionals' => []
                    )
                ]
            ),





            // api

//            (object) array(
//                'name' => 'Mimoto.CMS_api_APIOverview',
//                'file' => 'MimotoCMS/components/pages/api/APIOverview/APIOverview.twig',
//                'conditionals' => []
//            ),
//            (object) array(
//                'name' => 'Mimoto.CMS_api_APIOverview_ListItem',
//                'file' => 'MimotoCMS/components/pages/api/APIOverview/ListItem/ListItem.twig',
//                'conditionals' => []
//            ),
//            (object) array(
//                'name' => 'Mimoto.CMS_api_APIDetail',
//                'file' => 'MimotoCMS/components/pages/api/APIDetail/APIDetail.twig',
//                'conditionals' => []
//            ),
//            (object) array(
//                'name' => 'Mimoto.CMS_api_APIDetail-APIContainer',
//                'file' => 'MimotoCMS/components/pages/api/APIDetail/APIContainer/APIContainer.twig',
//                'conditionals' => []
//            ),


            // pages

            (object) array(
                'name' => 'MimotoCMS_pages_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/pages/Overview/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_pages_Overview-ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/pages/Overview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_pages_pages_Detail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/pages/Detail/Detail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_pages_pages_Detail-AllowedUserRole',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/pages/Detail/AllowedUserRole/AllowedUserRole.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_pages_pages_Detail-PathElement',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/pages/Detail/PathElement/PathElement.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_pages_pages_Detail-Output',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/pages/Detail/Output/Output.twig',
                        'conditionals' => []
                    )
                ]
            ),

            (object) array(
                'name' => 'MimotoCMS_pages_pages_Detail-Output-container',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/pages/Detail/OutputContainer/OutputContainer.twig',
                        'conditionals' => []
                    )
                ]
            ),



            // content sections

            (object) array(
                'name' => 'Mimoto.CMS_contentsections_ContentSectionOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/contentsections/ContentSectionOverview/ContentSectionOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_contentsections_ContentSectionOverview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/contentsections/ContentSectionOverview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_contentsections_ContentSectionDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/contentsections/ContentSectionDetail/ContentSectionDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // content

            (object) array(
                'name' => 'Mimoto.CMS_content_ContentOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/content/ContentOverview/ContentOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_content_ContentOverview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/content/ContentOverview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),



            // actions

            (object) array(
                'name' => 'Mimoto.CMS_actions_ActionOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/actions/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // users

            (object) array(
                'name' => 'MimotoCMS_users_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/users/Overview/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_users_Overview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/users/Overview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_users_Detail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/users/Detail/Detail.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // forms

            (object) array(
                'name' => 'Mimoto.CMS_forms_FormOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormOverview/FormOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormOverview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormOverview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail_TypeSelector',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormFieldTypeSelector/FormFieldTypeSelector.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail_TypeSelector_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetaiFormFieldTypeSelector/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail-FormField',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormField/FormField.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS_forms_FormDetail-FormFieldValue',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormField/FormFieldValue/FormFieldValue.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // forms - page and popup


//            (object) array(
//                'name' => 'Mimoto.CMS_form_Popup',
//                'file' => 'MimotoCMS/components/forms/FormPopup.twig',
//                'conditionals' => []
//            ),
//            (object) array(
//                'name' => 'Mimoto.CMS_form_Page',
//                'file' => 'MimotoCMS/components/forms/FormPage.twig',
//                'conditionals' => []
//            ),



            // inputs

            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/output/Title/Title.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/layout/GroupStart/GroupStart.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/layout/GroupEnd/GroupEnd.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/layout/Divider/Divider.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Textline/Textline.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Textblock/Textblock.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Checkbox/Checkbox.twig',
                        'conditionals' => []
                    )
                ]
            ),


            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/MultiSelect/MultiSelect.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT.'--option',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/MultiSelect/MultiSelectOption/MultiSelectOption.twig',
                        'conditionals' => []
                    )
                ]
            ),


            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Radiobutton/Radiobutton.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'--option',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Radiobutton/RadiobuttonOption/RadiobuttonOption.twig',
                        'conditionals' => []
                    )
                ]
            ),


            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Dropdown/Dropdown.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--option',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Dropdown/DropdownOption/DropdownOption.twig',
                        'conditionals' => []
                    )
                ]
            ),

            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_LIST,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/List/List.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_LIST.'-item',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/List/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),


            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_IMAGE,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Image/Image.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_VIDEO,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Video/Video.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/ColorPicker/ColorPicker.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_DATEPICKER,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/DatePicker/DatePicker.twig',
                        'conditionals' => []
                    )
                ]
            ),



            // notification center

            (object) array(
                'name' => 'MimotoCMS_notifications_NotificationOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/notifications/NotificationOverview/NotificationOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_notifications_NotificationOverviewSmall',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/notifications/NotificationOverviewSmall/NotificationOverviewSmall.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_notifications_Notification',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/notifications/Notification/Notification.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_notifications_NotificationSmall',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/notifications/NotificationSmall/NotificationSmall.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // modules

            (object) array(
                'name' => 'Mimoto.CMS.ListModule',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/ListModule/ListModule.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS.ListItemModule',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/ListItemModule/ListItemModule.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS.ButtonModule',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/ButtonModule/ButtonModule.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS.GroupButtonModule',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/GroupButtonModule/GroupButtonModule.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'Mimoto.CMS.TabmenuModule',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/TabmenuModule/TabmenuModule.twig',
                        'conditionals' => []
                    )
                ]
            )

        ];

        // send
        return $aCoreComponents;
    }




    // ----------------------------------------------------------------------------
    // --- Form -------------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::MIMOTO_COMPONENT,
            'name' => CoreConfig::MIMOTO_COMPONENT,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::MIMOTO_COMPONENT, 'name')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_COMPONENT);

        // setup
        CoreFormUtils::addField_title($form, 'Component', '', "The key element in presenting data is the 'component'. These are twig files that use Mimoto`s protocol to read and render the data, with the support of realtime updates to any client.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_COMPONENT.'--name',
            'Name', 'Component name', 'The component name could be unique, or used multiple times using conditionals'
        );
        self::setNameValidation($field);

        // send
        return $form;


    }


    // ----------------------------------------------------------------------------
    // --- private methods---------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Set name validation
     */
    private static function setNameValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_COMPONENT.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

//    /**
//     * Set file validation
//     */
//    private static function setFileValidation($field)
//    {
//        // validation rule #1
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
//        $validationRule->setId(CoreConfig::MIMOTO_COMPONENT.'--file_value_validation1');
//        $validationRule->setValue('type', 'minchars');
//        $validationRule->setValue('value', 1);
//        $validationRule->setValue('errorMessage', "Value can't be empty");
//        $field->addValue('validation', $validationRule);
//
//        // send
//        return $field;
//    }

}

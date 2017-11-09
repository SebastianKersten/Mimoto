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
                        //'defaultValue' =>
                        'allowedValues' => array(
                            (object) array(
                                'label' => 'Component', // replace by translation
                                'value' => CoreConfig::OUTPUT_TYPE_COMPONENT,
                                'default' => true
                            ),
                            (object) array(
                                'label' => 'Layout', // replace by translation
                                'value' => CoreConfig::OUTPUT_TYPE_LAYOUT
                            ),
                            (object) array(
                                'label' => 'Input field', // replace by translation
                                'value' => CoreConfig::OUTPUT_TYPE_INPUT
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
                            'value' => [CoreConfig::MIMOTO_COMPONENT_TEMPLATE]
                        ),
                        'allowDuplicates' => (object) array(
                            'key' => 'allowDuplicates',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN,
                            'value' => CoreConfig::DATA_VALUE_FALSE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT.'--containers',
                    // ---
                    'name' => 'containers',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_COMPONENT_CONTAINER]
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
                'name' => 'MimotoCMS_layout_Setup',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/base_setup.twig',
                        'conditionals' => []
                    )
                ]

            ),
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
                'name' => 'MimotoCMS_layout_PopupForm',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/PopupForm.twig',
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
                'name' => 'MimotoCMS_dashboard_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/dashboard/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // heartbeat

            (object) array(
                'name' => 'MimotoCMS_heartbeat_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/heartbeat/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // entities

            (object) array(
                'name' => 'MimotoCMS_entities_EntityOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/Overview/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_entities_EntityOverview_Entity',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/Overview/Entity/Entity.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_entities_EntityOverview_EntityProperty',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/Overview/EntityProperty/EntityProperty.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_entities_EntityDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_entities_EntityDetail-EntityProperty',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityProperty/EntityProperty.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_entities_EntityDetail-EntityPropertySetting',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertySetting/EntityPropertySetting.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_entities_EntityDetail-EntityPropertySettingAllowedEntityType',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertySettingAllowedEntityType/EntityPropertySettingAllowedEntityType.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_entities_EntityDetail-EntityPropertySettingFormattingOption',
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
                'name' => 'MimotoCMS_entities_EntityDetail_EntityPropertyExample',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/EntityPropertyExample/EntityPropertyExample.twig',
                        'conditionals' => []
                    )
                ]
            ),
//            (object) array(
//                'name' => 'MimotoCMS_entities_EntityDetail-ComponentListItem',
//                'templates' => [
//                    (object) array(
//                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/ComponentListItem/ComponentListItem.twig',
//                        'conditionals' => []
//                    )
//                ]
//            ),
//            (object) array(
//                'name' => 'MimotoCMS_entities_EntityDetail-ComponentDetail',
//                'templates' => [
//                    (object) array(
//                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/ComponentDetail/ComponentDetail.twig',
//                        'conditionals' => []
//                    )
//                ]
//            ),
//            (object) array(
//                'name' => 'MimotoCMS_entities_EntityDetail-ComponentConditional',
//                'templates' => [
//                    (object) array(
//                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/ComponentDetail/ComponentConditional/ComponentConditional.twig',
//                        'conditionals' => []
//                    )
//                ]
//            ),
            (object) array(
                'name' => 'MimotoCMS_entities_EntityDetail-Form',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/entities/EntityDetail/Form/Form.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // selections

            (object) array(
                'name' => 'MimotoCMS_selections_Overview',
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
                'name' => 'MimotoCMS_selections_Detail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/selections/Detail/Detail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_selections_Detail-Rule',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/selections/Detail/Rule/Rule.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // configuration
            (object) array(
                'name' => 'MimotoCMS_configuration_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/Configuration.twig',
                        'conditionals' => []
                    )
                ]
            ),

            (object) array(
                'name' => 'MimotoCMS_configuration_Overview_Section',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/section/Section.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // formatting options

            (object) array(
                'name' => 'MimotoCMS_formattingoptions_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/formattingoptions/Overview/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_formattingoptions_Overview_ListItem',
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
                'name' => 'MimotoCMS_configuration_userroles_Overview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/configuration/userroles/Overview/Overview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_configuration_userroles_Overview_ListItem',
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
                'name' => 'MimotoCMS_components_ComponentDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/ComponentDetail/ComponentDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_components_ComponentDetail-Template',
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
                'name' => 'MimotoCMS_components_LayoutDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/LayoutDetail/LayoutDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),

            (object) array(
                'name' => 'MimotoCMS_components_ComponentDetail-Container',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/components/ComponentDetail/ComponentContainer/ComponentContainer.twig',
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
//                'name' => 'MimotoCMS_api_APIOverview',
//                'file' => 'MimotoCMS/components/pages/api/APIOverview/APIOverview.twig',
//                'conditionals' => []
//            ),
//            (object) array(
//                'name' => 'MimotoCMS_api_APIOverview_ListItem',
//                'file' => 'MimotoCMS/components/pages/api/APIOverview/ListItem/ListItem.twig',
//                'conditionals' => []
//            ),
//            (object) array(
//                'name' => 'MimotoCMS_api_APIDetail',
//                'file' => 'MimotoCMS/components/pages/api/APIDetail/APIDetail.twig',
//                'conditionals' => []
//            ),
//            (object) array(
//                'name' => 'MimotoCMS_api_APIDetail-APIContainer',
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



            // datasets

            (object) array(
                'name' => 'MimotoCMS_datasets_DatasetOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/datasets/DatasetOverview/DatasetOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_datasets_DatasetOverview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/datasets/DatasetOverview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_datasets_DatasetDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/datasets/DatasetDetail/DatasetDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // content

            (object) array(
                'name' => 'MimotoCMS_content_ContentOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/content/ContentOverview/ContentOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_content_ContentOverview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/content/ContentOverview/ListItem/ListItem.twig',
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
                'name' => 'MimotoCMS_users_Overview_UserPreview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/users/Overview/UserPreview/UserPreview.twig',
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

            (object) array(
                'name' => 'MimotoCMS_pages_users_Detail_UserRole',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/users/Detail/UserRole/UserRole.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // forms

            (object) array(
                'name' => 'MimotoCMS_forms_FormOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormOverview/FormOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_forms_FormOverview_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormOverview/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_forms_FormDetail',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormDetail.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_forms_FormDetail_TypeSelector',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormFieldTypeSelector/FormFieldTypeSelector.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_forms_FormDetail_TypeSelector_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetaiFormFieldTypeSelector/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_forms_FormDetail-FormField',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormField/FormField.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_forms_FormDetail-FormFieldValue',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/forms/FormDetail/FormField/FormFieldValue/FormFieldValue.twig',
                        'conditionals' => []
                    )
                ]
            ),


            // forms - page and popup


//            (object) array(
//                'name' => 'MimotoCMS_form_Popup',
//                'file' => 'MimotoCMS/components/forms/FormPopup.twig',
//                'conditionals' => []
//            ),
//            (object) array(
//                'name' => 'MimotoCMS_form_Page',
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
                'name' => CoreConfig::MIMOTO_FORM_INPUT_PASSWORD,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Password/Password.twig',
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
                'name' => CoreConfig::MIMOTO_FORM_INPUT_ENTITY,
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/forms/input/Entity/Entity.twig',
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
                'name' => 'MimotoCMS_modules_List',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/List/List.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_modules_ListItem',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/ListItem/ListItem.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_modules_Button',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/Button/Button.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_modules_DataSelectButton',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/DataSelectButton/DataSelectButton.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_modules_EditableField',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/EditableField/EditableField.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_modules_Tabmenu',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/modules/Tabmenu/Tabmenu.twig',
                        'conditionals' => []
                    )
                ]
            ),



            // --- services


            (object) array(
                'name' => 'MimotoCMS_services_ServiceOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/services/ServiceOverview/ServiceOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_services_ServiceOverview_Service',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/services/ServiceOverview/Service/Service.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_services_ServiceOverview_ServiceFunction',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/services/ServiceOverview/ServiceFunction/ServiceFunction.twig',
                        'conditionals' => []
                    )
                ]
            ),




            // --- actions


            (object) array(
                'name' => 'MimotoCMS_actions_ActionOverview',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/actions/ActionOverview/ActionOverview.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_actions_ActionOverview_Action',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/actions/ActionOverview/Action/Action.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_actions_ActionOverview_ActionSetting',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/actions/ActionOverview/ActionSetting/ActionSetting.twig',
                        'conditionals' => []
                    )
                ]
            ),
            (object) array(
                'name' => 'MimotoCMS_actions_ActionOverview_ActionConditional',
                'templates' => [
                    (object) array(
                        'file' => 'MimotoCMS/components/pages/actions/ActionOverview/ActionConditional/ActionConditional.twig',
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
        $form = CoreFormUtils::initForm(CoreConfig::MIMOTO_COMPONENT, true);

        // setup
        CoreFormUtils::addField_title($form, 'Component', '', "The key element in presenting data is the 'component'. These are twig files that use Mimoto`s protocol to read and render the data, with the support of realtime updates to any client.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_COMPONENT.'--name',
            'Name', 'Component name', 'The component name could be unique, or used multiple times using conditionals'
        );
        self::setNameValidation($field);

        $form->addValue('fields', self::getField_type());

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
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
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
//        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
//        $validationRule->setId(CoreConfig::MIMOTO_COMPONENT.'--file_value_validation1');
//        $validationRule->setValue('type', 'minchars');
//        $validationRule->setValue('value', 1);
//        $validationRule->setValue('errorMessage', "Value can't be empty");
//        $field->addValue('validation', $validationRule);
//
//        // send
//        return $field;
//    }


    /**
     * Get field: type
     */
    private static function getField_type()
    {
        // 1. create and setup field
        $field = CoreFormUtils::createField(CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON, CoreConfig::MIMOTO_COMPONENT, 'type');
        $field->setValue('label', 'Type');

        // 2. connect value
        $field = CoreFormUtils::addValueToField($field, CoreConfig::MIMOTO_COMPONENT, 'type');


        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_COMPONENT.'--type_value_options-value');
        $option->setValue('label', 'Component');
        $option->setValue('value', CoreConfig::OUTPUT_TYPE_COMPONENT);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_COMPONENT.'--type_value_options-entity');
        $option->setValue('label', 'Layout');
        $option->setValue('value', CoreConfig::OUTPUT_TYPE_LAYOUT);
        $field->addValue('options', $option);

        $option = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_OPTION);
        $option->setId(CoreConfig::MIMOTO_COMPONENT.'--type_value_options-collection');
        $option->setValue('label', 'Input field');
        $option->setValue('value', CoreConfig::OUTPUT_TYPE_INPUT);
        $field->addValue('options', $option);

        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_FIELD_VALIDATION);
        $validationRule->setId(CoreConfig::MIMOTO_COMPONENT.'--type_value_validation1');
        $validationRule->setValue('type', 'regex_custom');
        $validationRule->setValue('value', '^('.CoreConfig::OUTPUT_TYPE_COMPONENT.'|'.CoreConfig::OUTPUT_TYPE_LAYOUT.'|'.CoreConfig::OUTPUT_TYPE_INPUT.')$');
        $validationRule->setValue('errorMessage', 'Select one of the above types');
        $validationRule->setValue('trigger', 'submit');
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

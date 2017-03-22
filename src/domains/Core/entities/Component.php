<?php

// classpath
namespace Mimoto\Core\entities;

// Mimoto classes
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
            'forms' => [CoreConfig::COREFORM_COMPONENT],
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
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT.'--file',
                    // ---
                    'name' => 'file',
                    'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                    'settings' => [
                        'type' => (object) array(
                            'key' => 'type',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_TEXT,
                            'value' => CoreConfig::DATA_VALUE_TEXTLINE
                        )
                    ]
                ),
                (object) array(
                    'id' => CoreConfig::MIMOTO_COMPONENT.'--conditionals',
                    // ---
                    'name' => 'conditionals',
                    'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                    'settings' => [
                        'allowedEntityTypes' => (object) array(
                            'key' => 'allowedEntityTypes',
                            'type' => MimotoEntityPropertyValueTypes::VALUETYPE_ARRAY,
                            'value' => [CoreConfig::MIMOTO_COMPONENTCONDITIONAL]
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
                'name' => 'MimotoCMS_layout_Page',
                'file' => 'MimotoCMS/components/base_page.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'MimotoCMS_layout_Popup',
                'file' => 'MimotoCMS/components/base_popup.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'MimotoCMS_layout_Form',
                'file' => 'MimotoCMS/components/forms/Form.twig',
                'conditionals' => []
            ),


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
                'name' => 'Mimoto.CMS_entities_EntityDetail-ComponentListItem',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/ComponentListItem/ComponentListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-ComponentDetail',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/ComponentDetail/ComponentDetail.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-ComponentConditional',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/ComponentDetail/ComponentConditional/ComponentConditional.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_entities_EntityDetail-Form',
                'file' => 'MimotoCMS/components/pages/entities/EntityDetail/Form/Form.twig',
                'conditionals' => []
            ),


            // selections

            (object) array(
                'name' => 'Mimoto.CMS_selections_SelectionOverview',
                'file' => 'MimotoCMS/components/pages/selections/SelectionOverview/SelectionOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_selections_SelectionOverview_ListItem',
                'file' => 'MimotoCMS/components/pages/selections/SelectionOverview/ListItem/ListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_selections_SelectionDetail',
                'file' => 'MimotoCMS/components/pages/selections/SelectionDetail/SelectionDetail.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_selections_SelectionDetail-Rule',
                'file' => 'MimotoCMS/components/pages/selections/SelectionDetail/SelectionRule/SelectionRule.twig',
                'conditionals' => []
            ),



            // layouts

            (object) array(
                'name' => 'Mimoto.CMS_layouts_LayoutOverview',
                'file' => 'MimotoCMS/components/pages/layouts/LayoutOverview/LayoutOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_layouts_LayoutOverview_ListItem',
                'file' => 'MimotoCMS/components/pages/layouts/LayoutOverview/ListItem/ListItem.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_layouts_LayoutDetail',
                'file' => 'MimotoCMS/components/pages/layouts/LayoutDetail/LayoutDetail.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_layouts_LayoutDetail-LayoutContainer',
                'file' => 'MimotoCMS/components/pages/layouts/LayoutDetail/LayoutContainer/LayoutContainer.twig',
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
                'name' => 'Mimoto.CMS_content_ContentOverview',
                'file' => 'MimotoCMS/components/pages/content/ContentOverview/ContentOverview.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => 'Mimoto.CMS_content_ContentOverview_ListItem',
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
                'file' => 'MimotoCMS/components/forms/input/TextRTF/TextRTF.twig',
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
                'name' => CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT.'--option',
                'file' => 'MimotoCMS/components/forms/input/MultiSelect/MultiSelectOption/MultiSelectOption.twig',
                'conditionals' => []
            ),


            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON,
                'file' => 'MimotoCMS/components/forms/input/Radiobutton/Radiobutton.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON.'--option',
                'file' => 'MimotoCMS/components/forms/input/Radiobutton/RadiobuttonOption/RadiobuttonOption.twig',
                'conditionals' => []
            ),


            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN,
                'file' => 'MimotoCMS/components/forms/input/Dropdown/Dropdown.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN.'--option',
                'file' => 'MimotoCMS/components/forms/input/Dropdown/DropdownOption/DropdownOption.twig',
                'conditionals' => []
            ),

            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_LIST,
                'file' => 'MimotoCMS/components/forms/input/List/List.twig',
                'conditionals' => []
            ),
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_LIST.'-item',
                'file' => 'MimotoCMS/components/forms/input/List/ListItem/ListItem.twig',
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
            (object) array(
                'name' => CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER,
                'file' => 'MimotoCMS/components/forms/input/ColorPicker/ColorPicker.twig',
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
     * Get form structure
     */
    public static function getFormStructure()
    {
        return (object) array(
            'id' => CoreConfig::COREFORM_COMPONENT,
            'name' => CoreConfig::COREFORM_COMPONENT,
            'class' => get_class(),
            'inputFieldIds' => [
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_COMPONENT, 'name'),
                CoreFormUtils::composeFieldName(CoreConfig::COREFORM_COMPONENT, 'file')
            ]
        );
    }

    /**
     * Get form
     */
    public static function getForm()
    {
        // init
        $form = CoreFormUtils::initForm(CoreConfig::COREFORM_COMPONENT);

        // setup
        CoreFormUtils::addField_title($form, 'Component', '', "The key element in presenting data is the 'component'. These are twig files that use the Aimless protocol to read and render the data, with the support of realtime updates to any client.");
        CoreFormUtils::addField_groupStart($form);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'name', CoreConfig::MIMOTO_COMPONENT.'--name',
            'Name', 'Component name', 'The component name could be unique, or used multiple times using conditionals'
        );
        self::setNameValidation($field);

        $field = CoreFormUtils::addField_textline
        (
            $form, 'file', CoreConfig::MIMOTO_COMPONENT.'--file',
            'Twig file', 'your_template_file.twig', '', Mimoto::value('ProjectConfig.twigroot')
        );
        self::setFileValidation($field);

        CoreFormUtils::addField_groupEnd($form);

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
        $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--name_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

    /**
     * Set file validation
     */
    private static function setFileValidation($field)
    {
        // validation rule #1
        $validationRule = Mimoto::service('data')->create(CoreConfig::MIMOTO_FORM_INPUTVALIDATION);
        $validationRule->setId(CoreConfig::COREFORM_COMPONENT.'--file_value_validation1');
        $validationRule->setValue('type', 'minchars');
        $validationRule->setValue('value', 1);
        $validationRule->setValue('errorMessage', "Value can't be empty");
        $field->addValue('validation', $validationRule);

        // send
        return $field;
    }

}

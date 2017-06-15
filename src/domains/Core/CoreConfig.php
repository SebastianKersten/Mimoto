<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Core\entities\Root;
use Mimoto\Core\entities\Entity;
use Mimoto\Core\entities\EntityProperty;
use Mimoto\Core\entities\EntityPropertySetting;
use Mimoto\Core\entities\User;
use Mimoto\Core\entities\UserRole;
use Mimoto\Core\entities\FormattingOption;
use Mimoto\Core\entities\FormattingOptionAttribute;
use Mimoto\Core\entities\Component;
use Mimoto\Core\entities\ComponentConditional;
use Mimoto\Core\entities\Layout;
use Mimoto\Core\entities\LayoutContainer;
use Mimoto\Core\entities\File;
use Mimoto\Core\entities\Selection;
use Mimoto\Core\entities\SelectionRule;
use Mimoto\Core\entities\ContentSection;
use Mimoto\Core\entities\Page;
use Mimoto\Core\entities\Form;
use Mimoto\Core\entities\Input;
use Mimoto\Core\entities\InputOption;
use Mimoto\Core\entities\InputValidation;
use Mimoto\Core\entities\OutputTitle;
use Mimoto\Core\entities\LayoutGroupStart;
use Mimoto\Core\entities\LayoutGroupEnd;
use Mimoto\Core\entities\LayoutDivider;
use Mimoto\Core\entities\InputCheckbox;
use Mimoto\Core\entities\InputDropdown;
use Mimoto\Core\entities\InputRadiobutton;
use Mimoto\Core\entities\InputTextline;
use Mimoto\Core\entities\InputMultiSelect;
use Mimoto\Core\entities\InputTextblock;
use Mimoto\Core\entities\InputList;
use Mimoto\Core\entities\InputImage;
use Mimoto\Core\entities\InputVideo;
use Mimoto\Core\entities\InputColorPicker;
use Mimoto\Core\entities\InputDatePicker;
use Mimoto\Core\entities\Notification;

use Mimoto\Core\forms\EntityPropertyForm_Value_type;
use Mimoto\Core\forms\EntityPropertyForm_Value_formattingOptions;
use Mimoto\Core\forms\EntityPropertyForm_Entity_allowedEntityType;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowedEntityTypes;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowDuplicates;
use Mimoto\Selection\SelectionRuleTypes;


/**
 * CoreConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CoreConfig
{

    // settings
    const EPOCH = '1976-10-19 23:15:00';


    const CORE_PREFIX                           = '_Mimoto_';
    const ENTITY_NEW                            = 'TheCakeIsALie';

    // root
    const MIMOTO_ROOT                           = '_Mimoto_root';

    // core
    const MIMOTO_ENTITY                         = '_Mimoto_entity';
    const MIMOTO_ENTITYPROPERTY                 = '_Mimoto_entityproperty';
    const MIMOTO_ENTITYPROPERTYSETTING          = '_Mimoto_entitypropertysetting';

    // connections
    const MIMOTO_CONNECTION                     = '_Mimoto_connection';

    // views
    const MIMOTO_COMPONENT                      = '_Mimoto_component';
    const MIMOTO_COMPONENTCONDITIONAL           = '_Mimoto_componentconditional';
    const MIMOTO_DATASET                        = '_Mimoto_dataset';
    const MIMOTO_LAYOUT                         = '_Mimoto_layout';
    const MIMOTO_LAYOUTCONTAINER                = '_Mimoto_layoutcontainer';

    // text
    const MIMOTO_FORMATTINGOPTION               = '_Mimoto_formattingoption';
    const MIMOTO_FORMATTINGOPTIONATTRIBUTE      = '_Mimoto_formattingoptionattribute';

    // functionality
    const MIMOTO_ACTION                         = '_Mimoto_action';
    const MIMOTO_NOTIFICATION                   = '_Mimoto_notification';

    const MIMOTO_USER                           = '_Mimoto_user';
    const MIMOTO_USER_GROUP                     = '_Mimoto_user_group';
    const MIMOTO_USER_ROLE                      = '_Mimoto_user_role';

    // search
    const MIMOTO_SELECTION                      = '_Mimoto_selection';
    const MIMOTO_SELECTIONRULE                  = '_Mimoto_selectionrule';

    // media
    const MIMOTO_FILE                           = '_Mimoto_file';

    // content
    const MIMOTO_CONTENTSECTION                 = '_Mimoto_contentsection';

    const MIMOTO_PAGE                           = '_Mimoto_page';
    const MIMOTO_ROUTE                          = '_Mimoto_coreform_route';
    const MIMOTO_ROUTE_ELEMENT                  = '_Mimoto_coreform_route_element';

    // forms
    const MIMOTO_FORM                           = '_Mimoto_form';
    const MIMOTO_FORM_INPUT                     = '_Mimoto_form_input';
    const MIMOTO_FORM_INPUTOPTION               = '_Mimoto_form_inputoption';
    const MIMOTO_FORM_INPUTVALIDATION           = '_Mimoto_form_inputvalidation';

    // input
    const MIMOTO_FORM_INPUT_TEXTLINE            = '_Mimoto_form_input_textline';
    const MIMOTO_FORM_INPUT_TEXTBLOCK           = '_Mimoto_form_input_textblock';
    const MIMOTO_FORM_INPUT_CHECKBOX            = '_Mimoto_form_input_checkbox';
    const MIMOTO_FORM_INPUT_MULTISELECT         = '_Mimoto_form_input_multiselect';
    const MIMOTO_FORM_INPUT_RADIOBUTTON         = '_Mimoto_form_input_radiobutton';
    const MIMOTO_FORM_INPUT_DROPDOWN            = '_Mimoto_form_input_dropdown';
    const MIMOTO_FORM_INPUT_LIST                = '_Mimoto_form_input_list';
    const MIMOTO_FORM_INPUT_IMAGE               = '_Mimoto_form_input_image';
    const MIMOTO_FORM_INPUT_VIDEO               = '_Mimoto_form_input_video';
    const MIMOTO_FORM_INPUT_COLORPICKER         = '_Mimoto_form_input_colorpicker';
    const MIMOTO_FORM_INPUT_DATEPICKER          = '_Mimoto_form_input_datepicker';

    // output
    const MIMOTO_FORM_OUTPUT_TITLE              = '_Mimoto_form_output_title';

    // layout
    const MIMOTO_FORM_LAYOUT_GROUPSTART         = '_Mimoto_form_layout_groupstart';
    const MIMOTO_FORM_LAYOUT_GROUPEND           = '_Mimoto_form_layout_groupend';
    const MIMOTO_FORM_LAYOUT_DIVIDER            = '_Mimoto_form_layout_divider';


    // property types
    const PROPERTY_TYPE_VALUE       = 'value';
    const PROPERTY_TYPE_ENTITY      = 'entity';
    const PROPERTY_TYPE_COLLECTION  = 'collection';

    // data types
    const DATA_TYPE_VALUE           = 'value';
    const DATA_TYPE_BOOLEAN         = 'boolean';

    // data values
    const DATA_VALUE_TEXTLINE       = 'textline';
    const DATA_VALUE_TEXTBLOCK      = 'textblock';
    const DATA_VALUE_BOOLEAN        = 'boolean';
    const DATA_VALUE_TRUE           = 'true';
    const DATA_VALUE_FALSE          = 'false';

    // inputvalue vartypes
    const INPUTVALUE_VARTYPE                = 'vartype';
    const INPUTVALUE_VARTYPE_VARNAME        = 'varname';
    const INPUTVALUE_VARTYPE_ENTITYPROPERTY = 'entityproperty';


    // core forms
    const COREFORM_ENTITY               = '_Mimoto_coreform__entity';
    const COREFORM_ENTITYPROPERTY       = '_Mimoto_coreform__entityProperty';

    const COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE                     = '_Mimoto_coreform__entityPropertySetting_value_type';
    const COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS        = '_Mimoto_coreform__entityPropertySetting_value_formattingoptions';
    const COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE       = '_Mimoto_coreform__entityPropertySetting_entity_allowedEntityType';
    const COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES  = '_Mimoto_coreform__entityPropertySetting_value_allowedEntityTypes';
    const COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES     = '_Mimoto_coreform__entityPropertySetting_collection_allowDuplicates';

    const COREFORM_PAGE                         = '_Mimoto_coreform_page';
    const COREFORM_ROUTE                        = '_Mimoto_coreform_route';
    const COREFORM_ROUTE_ELEMENT                = '_Mimoto_coreform_route_element';

    const COREFORM_USER                         = '_Mimoto_coreform_user';
    const COREFORM_USER_ROLE                    = '_Mimoto_coreform_user_role';
    const COREFORM_USER_GROUP                   = '_Mimoto_coreform_user_group';

    const COREFORM_CONTENTSECTION               = '_Mimoto_coreform__contentSection';
    const COREFORM_LAYOUT                       = '_Mimoto_coreform__layout';
    const COREFORM_LAYOUTCONTAINER              = '_Mimoto_coreform__layoutContainer';

    const COREFORM_COMPONENT                    = '_Mimoto_coreform__component';
    const COREFORM_COMPONENTCONDITIONAL         = '_Mimoto_coreform__componentConditional';
    const COREFORM_FORM                         = '_Mimoto_coreform__form';
    const COREFORM_INPUTOPTION                  = '_Mimoto_coreform_form_inputoption';
    const COREFORM_FORM_INPUTVALIDATION         = '_Mimoto_coreform_form_inputValidation';

    const COREFORM_FORMATTINGOPTION             = '_Mimoto_coreform_formattingoption';
    const COREFORM_FORMATTINGOPTIONATTRIBUTE    = '_Mimoto_coreform_formattingoptionattribute';

    const COREFORM_FILE                         = '_Mimoto_coreform_file';

    const COREFORM_SELECTION                    = '_Mimoto_coreform_selection';
    const COREFORM_SELECTIONRULE                = '_Mimoto_coreform_selectionRule';


    // input
    const COREFORM_INPUT_TEXTLINE       = '_Mimoto_coreform_input_textline';
    const COREFORM_INPUT_TEXTBLOCK      = '_Mimoto_coreform_input_textblock';
    const COREFORM_INPUT_CHECKBOX       = '_Mimoto_coreform_input_checkbox';
    const COREFORM_INPUT_MULTISELECT    = '_Mimoto_coreform_input_multiselect';
    const COREFORM_INPUT_RADIOBUTTON    = '_Mimoto_coreform_input_radiobutton';
    const COREFORM_INPUT_DROPDOWN       = '_Mimoto_coreform_input_dropdown';
    const COREFORM_INPUT_LIST           = '_Mimoto_coreform_input_list';

    const COREFORM_INPUT_IMAGE          = '_Mimoto_coreform_input_image';
    const COREFORM_INPUT_VIDEO          = '_Mimoto_coreform_input_video';
    const COREFORM_INPUT_COLORPICKER    = '_Mimoto_coreform_input_colorpicker';
    const COREFORM_INPUT_DATEPICKER     = '_Mimoto_coreform_input_datepicker';

    // output
    const COREFORM_OUTPUT_TITLE         = '_Mimoto_coreform_output_title';

    // layout
    const COREFORM_LAYOUT_GROUPSTART    = '_Mimoto_coreform_layout_groupstart';
    const COREFORM_LAYOUT_GROUPEND      = '_Mimoto_coreform_layout_groupend';
    const COREFORM_LAYOUT_DIVIDER       = '_Mimoto_coreform_layout_divider';



    // #todo
    // 1. noteer hier ook de tables en tableconfigs for installatie
    // 2. id en created in meta? Gelijk aan Aimless-component
    // 3. meta en data -> AimlessComponent maakt beschikbaar en vult aan met andere features



    public static function getCoreEntityConfigs()
    {

        // 1. load into memory in "EntityConfigRepository"


        // setup
        $aEntities = [

            // root
            Root::getStructure(),

            // core
            Entity::getStructure(),
            EntityProperty::getStructure(),
            EntityPropertySetting::getStructure(),

            // users
            User::getStructure(),
            UserRole::getStructure(),

            // search
            Selection::getStructure(),
            SelectionRule::getStructure(),

            // views
            Component::getStructure(),
            ComponentConditional::getStructure(),

            // views
            Layout::getStructure(),
            LayoutContainer::getStructure(),

            // formatting
            FormattingOption::getStructure(),
            FormattingOptionAttribute::getStructure(),

            // content
            File::getStructure(),
            Page::getStructure(),
            ContentSection::getStructure(),

            // forms
            Form::getStructure(),
            Input::getStructure(),
            InputOption::getStructure(),
            InputValidation::getStructure(),

            // output
            OutputTitle::getStructure(),

            // layout
            LayoutGroupStart::getStructure(),
            LayoutGroupEnd::getStructure(),
            LayoutDivider::getStructure(),

            // input
            InputTextline::getStructure(),
            InputList::getStructure(),
            InputTextblock::getStructure(),
            InputCheckbox::getStructure(),
            InputMultiSelect::getStructure(),
            InputRadiobutton::getStructure(),
            InputDropdown::getStructure(),
            InputImage::getStructure(),
            InputVideo::getStructure(),
            InputColorPicker::getStructure(),
            InputDatePicker::getStructure(),

            // devtools
            Notification::getStructure()
        ];

        // send
        return $aEntities;
    }

    public static function getCoreForms()
    {
        // setup
        $aForms = [

            // core
            Entity::getFormStructure(),
            EntityProperty::getFormStructure(),
            EntityPropertyForm_Value_type::getFormStructure(),
            EntityPropertyForm_Value_formattingOptions::getFormStructure(),
            EntityPropertyForm_Entity_allowedEntityType::getFormStructure(),
            EntityPropertyForm_Collection_allowedEntityTypes::getFormStructure(),
            EntityPropertyForm_Collection_allowDuplicates::getFormStructure(),

            // users
            User::getFormStructure(),
            UserRole::getFormStructure(),

            // search
            Selection::getFormStructure(),
            SelectionRule::getFormStructure(),

            // views
            Component::getFormStructure(),
            ComponentConditional::getFormStructure(),

            // views
            Layout::getFormStructure(),
            LayoutContainer::getFormStructure(),

            // formatting
            FormattingOption::getFormStructure(),
            //FormattingOptionAttribute::getFormStructure(),

            // content
            Page::getFormStructure(),
            ContentSection::getFormStructure(),

            // forms
            Form::getFormStructure(),
            InputOption::getFormStructure(),
            InputValidation::getFormStructure(),

            // output
            OutputTitle::getFormStructure(),

            // layout
            LayoutDivider::getFormStructure(),
            LayoutGroupStart::getFormStructure(),
            LayoutGroupEnd::getFormStructure(),

            // input
            InputCheckbox::getFormStructure(),
            InputDropdown::getFormStructure(),
            InputImage::getFormStructure(),
            InputList::getFormStructure(),
            InputMultiSelect::getFormStructure(),
            InputRadiobutton::getFormStructure(),
            InputTextBlock::getFormStructure(),
            InputTextline::getFormStructure(),
            InputVideo::getFormStructure(),
            InputColorPicker::getFormStructure(),
            InputDatePicker::getFormStructure()
        ];

        // send
        return $aForms;
    }

    public static function getCoreActions()
    {
        // setup
        $aActions = [
            (object) array(
                'trigger' => '*.created',
                'service' => 'Aimless',
                'request' => 'dataCreate',
                'type' => 'async'
            ),
            (object) array(
                'trigger' => CoreConfig::MIMOTO_ENTITY.'.created', // #todo - move 'created' etc to const class
                'service' => 'Aimless',
                'request' => 'createEntityTable',
                'type' => 'sync'
            ),
            (object) array(
                'trigger' => CoreConfig::MIMOTO_ENTITY.'.updated',
                'service' => 'Aimless',
                'request' => 'updateEntityTable',
                'type' => 'sync'
            ),
            (object) array(
                'trigger' => CoreConfig::MIMOTO_ENTITYPROPERTY.'.created',
                'service' => 'Aimless',
                'request' => 'onEntityPropertyCreated',
                'type' => 'sync'
            ),
            (object) array(
                'trigger' => CoreConfig::MIMOTO_ENTITYPROPERTY.'.updated',
                'service' => 'Aimless',
                'request' => 'onEntityPropertyUpdated',
                'type' => 'sync'
            ),
            (object) array(
                'trigger' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'.updated',
                'service' => 'Aimless',
                'request' => 'onEntityPropertySettingUpdated',
                'type' => 'sync'
            ),
            (object) array(
                'trigger' => CoreConfig::MIMOTO_NOTIFICATION.'.created',
                'service' => 'Aimless',
                'request' => 'sendSlackNotification',
                'type' => 'async',
                'config' => (object) array(
                    'channel' => 'mimoto_notifications'
                )
            ),
            (object) array(
                'trigger' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING.'.updated',
                'service' => 'Aimless',
                'request' => 'onFormattingChanged',
                'type' => 'sync'
            ),
            (object) array(
                'trigger' => '*.updated',
                'service' => 'Aimless',
                'request' => 'dataUpdate',
                'type' => 'async',
                'config' => (object) array(
                    'properties' => array(
                        'state',
                        'name',
                        'type',

                        'description',

                        'client.name',
                        'agency.name',
                        'projectManager',
                        'projectManager.name',

                        'subprojects',
                        'properties',
                        'fields',
                        'value',
                        'allowedEntityType',
                        'allowedEntityTypes',

                        'file',
                        'label',

                        'placeholder',
                        'prefix',

                        'form',
                        'forms',
                        'components',
                        'title',

                        'options',
                        'validation',

                        'rules',
                        'notifications',
                        'entities',
                        'users',
                        'contentSections',
                        'selections',

                        'contentItem',
                        'contentItems',
                        'conditionals'
                    )
                ),
                'notes' => array(
                    "voor admin user, send all. Add 'except'. Wildcard"
                )
            )
        ];

        // send
        return $aActions;
    }

    public static function getCoreSelections()
    {
        // setup
        $aSelections = [
//            (object)array(
//                'name' => CoreConfig::MIMOTO_FORM_INPUT_LIST.'options',
//                'Mimoto list input options',
//                'rules' => [
//                    (object)array(
//                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_ENTITY
//                    )
//                ]
//            ),
            (object)array(
                'id' => CoreConfig::CORE_PREFIX . 'all_entities', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_entities', // internal of external?
                'label' => 'xxx',
                'rules' => [
                    (object)array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_ENTITY
                    )
                ]
            )
        ];

        // send
        return $aSelections;
    }

    public static function getCoreData($sEntityTypeName, $sItemId)
    {
        // #todo - make generic

        switch($sEntityTypeName)
        {
            case CoreConfig::MIMOTO_FORMATTINGOPTION: return FormattingOption::getData($sItemId); break;
            case CoreConfig::MIMOTO_USER_ROLE: return UserRole::getData($sItemId); break;
        }

        return false;
    }

}

<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Core\entities\Root;
use Mimoto\Core\entities\CoreDataKeyValue;
use Mimoto\Core\entities\Entity;
use Mimoto\Core\entities\EntityProperty;
use Mimoto\Core\entities\EntityPropertySetting;
use Mimoto\Core\entities\User;
use Mimoto\Core\entities\UserRole;
use Mimoto\Core\entities\FormattingOption;
use Mimoto\Core\entities\FormattingOptionAttribute;
use Mimoto\Core\entities\Component;
use Mimoto\Core\entities\ComponentTemplate;
use Mimoto\Core\entities\ComponentConditional;
use Mimoto\Core\entities\ComponentContainer;
use Mimoto\Core\entities\File;
use Mimoto\Core\entities\Selection;
use Mimoto\Core\entities\SelectionRule;
use Mimoto\Core\entities\SelectionRuleValue;
use Mimoto\Core\entities\Dataset;
use Mimoto\Core\entities\API;
use Mimoto\Core\entities\Route;
use Mimoto\Core\entities\PathElement;
use Mimoto\Core\entities\Output;
use Mimoto\Core\entities\OutputContainer;
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
use Mimoto\Core\entities\InputPassword;
use Mimoto\Core\entities\InputMultiSelect;
use Mimoto\Core\entities\InputTextblock;
use Mimoto\Core\entities\InputList;
use Mimoto\Core\entities\InputEntity;
use Mimoto\Core\entities\InputImage;
use Mimoto\Core\entities\InputVideo;
use Mimoto\Core\entities\InputColorPicker;
use Mimoto\Core\entities\InputDatePicker;
use Mimoto\Core\entities\Notification;
use Mimoto\Core\entities\Service;
use Mimoto\Core\entities\ServiceFunction;
use Mimoto\Core\entities\Action;
use Mimoto\Core\entities\ActionSetting;
use Mimoto\Core\entities\ActionConditional;

use Mimoto\Core\forms\EntityPropertyForm_Value_type;
use Mimoto\Core\forms\EntityPropertyForm_Value_formattingOptions;
use Mimoto\Core\forms\EntityPropertyForm_Value_defaultValue;
use Mimoto\Core\forms\EntityPropertyForm_Entity_allowedEntityType;
use Mimoto\Core\forms\EntityPropertyForm_Entity_defaultValue;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowedEntityTypes;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowDuplicates;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Event\ConditionalTypes;
use Mimoto\Event\EventService;
use Mimoto\Mimoto;
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

    // apps
    const MIMOTO_APP                            = '_Mimoto_app';

    // views
    const MIMOTO_COMPONENT                      = '_Mimoto_component';
    const MIMOTO_COMPONENT_CONDITIONAL          = '_Mimoto_component_conditional';
    const MIMOTO_COMPONENT_CONTAINER            = '_Mimoto_component_container';
    const MIMOTO_COMPONENT_TEMPLATE             = '_Mimoto_component_template';

    // text
    const MIMOTO_FORMATTINGOPTION               = '_Mimoto_formattingoption';
    const MIMOTO_FORMATTINGOPTION_ATTRIBUTE     = '_Mimoto_formattingoption_attribute';

    // functionality
    const MIMOTO_SERVICE                        = '_Mimoto_service';
    const MIMOTO_SERVICE_FUNCTION               = '_Mimoto_service_function';
    const MIMOTO_ACTION                         = '_Mimoto_action';
    const MIMOTO_ACTION_SETTING                 = '_Mimoto_action_setting';
    const MIMOTO_ACTION_CONDITIONAL             = '_Mimoto_action_conditional';

    // developers
    const MIMOTO_NOTIFICATION                   = '_Mimoto_notification';

    // access
    const MIMOTO_MAGICLINK                      = '_Mimoto_magiclink';

    // users
    const MIMOTO_USER                           = '_Mimoto_user';
    const MIMOTO_USER_GROUP                     = '_Mimoto_user_group';
    const MIMOTO_USER_ROLE                      = '_Mimoto_user_role';

    // search
    const MIMOTO_SELECTION                      = '_Mimoto_selection';
    const MIMOTO_SELECTION_RULE                 = '_Mimoto_selection_rule';
    const MIMOTO_SELECTION_RULE_VALUE           = '_Mimoto_selection_rule_value';

    // routes
    const MIMOTO_API                            = '_Mimoto_api';
    const MIMOTO_PAGE                           = '_Mimoto_page';
    const MIMOTO_PATH_ELEMENT                   = '_Mimoto_path_element';
    const MIMOTO_OUTPUT                         = '_Mimoto_output';
    const MIMOTO_OUTPUT_CONTAINER               = '_Mimoto_output_container';

    // media
    const MIMOTO_FILE                           = '_Mimoto_file';

    // content
    const MIMOTO_DATASET                        = '_Mimoto_dataset';

    // core data
    const MIMOTO_COREDATA_KEYVALUE              = '_Mimoto_coredata_keyvalue';

    // forms
    const MIMOTO_FORM                           = '_Mimoto_form';
    const MIMOTO_FORM_FIELD                     = '_Mimoto_form_field';
    const MIMOTO_FORM_FIELD_OPTION              = '_Mimoto_form_field_option';
    const MIMOTO_FORM_FIELD_OPTION_MAP          = '_Mimoto_form_field_option_map';
    const MIMOTO_FORM_FIELD_RULES               = '_Mimoto_form_field_rules';
    const MIMOTO_FORM_FIELD_VALIDATION          = '_Mimoto_form_field_validation';

    const MIMOTO_FORM_INPUT                     = '_Mimoto_form_input';


    // input
    const MIMOTO_FORM_INPUT_TEXTLINE            = '_Mimoto_form_input_textline';
    const MIMOTO_FORM_INPUT_PASSWORD            = '_Mimoto_form_input_password';
    const MIMOTO_FORM_INPUT_TEXTBLOCK           = '_Mimoto_form_input_textblock';
    const MIMOTO_FORM_INPUT_CHECKBOX            = '_Mimoto_form_input_checkbox';
    const MIMOTO_FORM_INPUT_MULTISELECT         = '_Mimoto_form_input_multiselect';
    const MIMOTO_FORM_INPUT_RADIOBUTTON         = '_Mimoto_form_input_radiobutton';
    const MIMOTO_FORM_INPUT_DROPDOWN            = '_Mimoto_form_input_dropdown';
    const MIMOTO_FORM_INPUT_LIST                = '_Mimoto_form_input_list';
    const MIMOTO_FORM_INPUT_ENTITY              = '_Mimoto_form_input_entity';
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
    const DATA_VALUE_TRUE           = 'true';
    const DATA_VALUE_FALSE          = 'false';

    // inputvalue vartypes
    const INPUTVALUE_VARTYPE                = 'vartype';
    const INPUTVALUE_VARTYPE_VARNAME        = 'varname';
    const INPUTVALUE_VARTYPE_ENTITYPROPERTY = 'entityproperty';

    const OUTPUT_TYPE_COMPONENT = 'component';
    const OUTPUT_TYPE_LAYOUT    = 'layout';
    const OUTPUT_TYPE_INPUT     = 'input';

    // core forms
    const COREFORM_ENTITY               = '_Mimoto_coreform__entity';
    const COREFORM_ENTITYPROPERTY       = '_Mimoto_coreform__entityProperty';

    const COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE                     = '_Mimoto_coreform__entityPropertySetting_value_type';
    const COREFORM_ENTITYPROPERTYSETTING_VALUE_FORMATTINGOPTIONS        = '_Mimoto_coreform__entityPropertySetting_value_formattingoptions';
    const COREFORM_ENTITYPROPERTYSETTING_VALUE_DEFAULTVALUE             = '_Mimoto_coreform__entityPropertySetting_value_defaultvalue';
    const COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE       = '_Mimoto_coreform__entityPropertySetting_entity_allowedEntityType';
    const COREFORM_ENTITYPROPERTYSETTING_ENTITY_DEFAULTVALUE            = '_Mimoto_coreform__entityPropertySetting_entity_defaultvalue';
    const COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES  = '_Mimoto_coreform__entityPropertySetting_value_allowedEntityTypes';
    const COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES     = '_Mimoto_coreform__entityPropertySetting_collection_allowDuplicates';


    const COREFORM_FORM                         = '_Mimoto_coreform__form';
    const COREFORM_INPUTOPTION                  = '_Mimoto_coreform_form_inputoption';
    const COREFORM_FORM_INPUTVALIDATION         = '_Mimoto_coreform_form_inputValidation';

    const COREFORM_FILE                         = '_Mimoto_coreform_file';

    const COREFORM_SELECTION                    = '_Mimoto_coreform__selection';
    const COREFORM_SELECTIONRULE                = '_Mimoto_coreform__selectionRule';


    // input
    const COREFORM_INPUT_TEXTLINE       = '_Mimoto_coreform_input_textline';
    const COREFORM_INPUT_TEXTBLOCK      = '_Mimoto_coreform_input_textblock';
    const COREFORM_INPUT_CHECKBOX       = '_Mimoto_coreform_input_checkbox';
    const COREFORM_INPUT_MULTISELECT    = '_Mimoto_coreform_input_multiselect';
    const COREFORM_INPUT_RADIOBUTTON    = '_Mimoto_coreform_input_radiobutton';
    const COREFORM_INPUT_DROPDOWN       = '_Mimoto_coreform_input_dropdown';
    const COREFORM_INPUT_LIST           = '_Mimoto_coreform_input_list';
    const COREFORM_INPUT_ENTITY         = '_Mimoto_coreform_input_entity';

    const COREFORM_INPUT_IMAGE          = '_Mimoto_coreform_input_image';
    const COREFORM_INPUT_VIDEO          = '_Mimoto_coreform_input_video';
    const COREFORM_INPUT_DATEPICKER     = '_Mimoto_coreform_input_datepicker';

    // output
    const COREFORM_OUTPUT_TITLE         = '_Mimoto_coreform_output_title';

    // layout
    const COREFORM_LAYOUT_GROUPSTART    = '_Mimoto_coreform_layout_groupstart';
    const COREFORM_LAYOUT_GROUPEND      = '_Mimoto_coreform_layout_groupend';
    const COREFORM_LAYOUT_DIVIDER       = '_Mimoto_coreform_layout_divider';


    const DATA_EVENT_CREATED = 'created';
    const DATA_EVENT_UPDATED = 'updated';
    const DATA_EVENT_DELETED = 'deleted';



    // #todo
    // 1. noteer hier ook de tables en tableconfigs for installatie
    // 2. id en created in meta? Gelijk aan Aimless-component
    // 3. meta en data -> AimlessComponent maakt beschikbaar en vult aan met andere features



    public static function getCoreEntityConfigs()
    {

        // 1. load into memory in "EntityConfigRepository"


        // setup
        $aEntities = [

            // users
            User::getStructure(),
            UserRole::getStructure(),

            // root
            Root::getStructure(),

            // core
            Entity::getStructure(),
            EntityProperty::getStructure(),
            EntityPropertySetting::getStructure(),

            // search
            Selection::getStructure(),
            SelectionRule::getStructure(),
            SelectionRuleValue::getStructure(),

            // views
            Component::getStructure(),
            ComponentConditional::getStructure(),
            ComponentContainer::getStructure(),
            ComponentTemplate::getStructure(),

            // automation
            Service::getStructure(),
            ServiceFunction::getStructure(),
            Action::getStructure(),
            ActionSetting::getStructure(),
            ActionConditional::getStructure(),

            // formatting
            FormattingOption::getStructure(),
            FormattingOptionAttribute::getStructure(),

            // content
            File::getStructure(),
            API::getStructure(),
            Route::getStructure(),
            PathElement::getStructure(),
            Output::getStructure(),
            OutputContainer::getStructure(),
            Dataset::getStructure(),
            CoreDataKeyValue::getStructure(),

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
            InputPassword::getStructure(),
            InputList::getStructure(),
            InputEntity::getStructure(),
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
            EntityPropertyForm_Value_defaultValue::getFormStructure(),
            EntityPropertyForm_Entity_allowedEntityType::getFormStructure(),
            EntityPropertyForm_Entity_defaultValue::getFormStructure(),
            EntityPropertyForm_Collection_allowedEntityTypes::getFormStructure(),
            EntityPropertyForm_Collection_allowDuplicates::getFormStructure(),

            // users
            User::getFormStructure(),
            UserRole::getFormStructure(),

            // search
            Selection::getFormStructure(),
            SelectionRuleValue::getFormStructure(),

            // views
            Component::getFormStructure(),
            ComponentConditional::getFormStructure(),
            ComponentContainer::getFormStructure(),
            ComponentTemplate::getFormStructure(),

            // automation
            Service::getFormStructure(),
            ServiceFunction::getFormStructure(),
            Action::getFormStructure(),
            ActionSetting::getFormStructure(),
            ActionConditional::getFormStructure(),

            // formatting
            FormattingOption::getFormStructure(),
            //FormattingOptionAttribute::getFormStructure(),

            // content
            API::getFormStructure(),
            Route::getFormStructure(),
            PathElement::getFormStructure(),
            Output::getFormStructure(),
            OutputContainer::getFormStructure(),
            Dataset::getFormStructure(),

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
            InputEntity::getFormStructure(),
            InputMultiSelect::getFormStructure(),
            InputRadiobutton::getFormStructure(),
            InputTextBlock::getFormStructure(),
            InputTextline::getFormStructure(),
            InputPassword::getFormStructure(),
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
                'trigger' => CoreConfig::MIMOTO_NOTIFICATION.'.created',
                'service' => 'Aimless',
                'request' => 'sendSlackNotification',
                'type' => 'async',
                'config' => (object) array(
                    'channel' => 'mimoto_notifications'
                )
            ),
            (object) array(
                'trigger' => '*.updated',
                'service' => 'Aimless',
                'request' => 'dataUpdate',
                'type' => 'async',
                'config' => (object) array(
                    'properties' => array('state', 'name', 'type', 'description', 'client.name')
                ),
                'notes' => array(
                    "voor admin user, send all. Add 'except'. Wildcard"
                )
            ),


            // ----------


            (object) array(
                'owner' => Mimoto::MIMOTO,
                'trigger' => [MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITY, CoreConfig::DATA_EVENT_CREATED), MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_COMPONENT, CoreConfig::DATA_EVENT_CREATED)],
                'conditionals' => [],
                'service' => (object) array(
                    'name' => 'CoreData',
                    'file' => 'CoreData/CoreData.php',
                ),
                'function' => 'createEntityTable',
                'type' => 'sync',
                'settings' => (object) array()
            ),

            (object) array(
                'owner' => Mimoto::MIMOTO,
                'trigger' => [MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITY, CoreConfig::DATA_EVENT_UPDATED), MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_COMPONENT, CoreConfig::DATA_EVENT_UPDATED)],
                'conditionals' => [
                    (object) array('propertyName' => 'name', 'type' => 'changed')
                ],
                'service' => (object) array(
                    'name' => 'CoreData',
                    'file' => 'CoreData/CoreData.php',
                ),
                'function' => 'renameEntityTable',
                'type' => 'sync',
                'settings' => (object) array()
            ),

            (object) array(
                'owner' => Mimoto::MIMOTO,
                'trigger' => [MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITY, CoreConfig::DATA_EVENT_DELETED), MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_COMPONENT, CoreConfig::DATA_EVENT_DELETED)],
                'conditionals' => [],
                'service' => (object) array(
                    'name' => 'CoreData',
                    'file' => 'CoreData/CoreData.php',
                ),
                'function' => 'deleteEntityTable',
                'type' => 'sync',
                'settings' => (object) array()
            ),


            (object) array(
                'owner' => Mimoto::MIMOTO,
                'trigger' => [MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITY, CoreConfig::DATA_EVENT_UPDATED)],
                'conditionals' => [
                    //(object) array('propertyName' => 'properties', 'type' => 'changed') -----> changes check on collecion not supported yet
                ],
                'service' => (object) array(
                    'name' => 'CoreData',
                    'file' => 'CoreData/CoreData.php',
                ),
                'function' => 'addEntityPropertyColumn',
                'type' => 'sync',
                'settings' => (object) array()
            ),

            (object) array(
                'owner' => Mimoto::MIMOTO,
                'trigger' => [MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITYPROPERTY, CoreConfig::DATA_EVENT_UPDATED)],
                'conditionals' => [],
                'service' => (object) array(
                    'name' => 'CoreData',
                    'file' => 'CoreData/CoreData.php',
                ),
                'function' => 'updateEntityPropertyColumn',
                'type' => 'sync',
                'settings' => (object) array()
            ),

            (object) array(
                'owner' => Mimoto::MIMOTO,
                'trigger' => [MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITYPROPERTY, CoreConfig::DATA_EVENT_DELETED)],
                'conditionals' => [],
                'service' => (object) array(
                    'name' => 'CoreData',
                    'file' => 'CoreData/CoreData.php',
                ),
                'function' => 'removeEntityPropertyColumn',
                'type' => 'sync',
                'settings' => (object) array()
            ),

            (object) array(
                'owner' => Mimoto::MIMOTO,
                'trigger' => [MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING, CoreConfig::DATA_EVENT_UPDATED)],
                'conditionals' => [],
                'service' => (object) array(
                    'name' => 'CoreData',
                    'file' => 'CoreData/CoreData.php',
                ),
                'function' => 'onEntityPropertySettingUpdated',
                'type' => 'sync',
                'settings' => (object) array()
            ),

            (object) array(
                'owner' => Mimoto::MIMOTO,
                'trigger' => [MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITYPROPERTYSETTING, CoreConfig::DATA_EVENT_UPDATED)],
                'conditionals' => [],
                'service' => (object) array(
                    'name' => 'CoreRealtime',
                    'file' => 'CoreRealtime/CoreRealtime.php',
                ),
                'function' => 'onFormattingChanged',
                'type' => 'sync',
                'settings' => (object) array()
            ),




//            (object) array(
//                'owner' => Mimoto::MIMOTO,
//                'trigger' => [MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITY, CoreConfig::DATA_EVENT_CREATED), MimotoDataUtils::buildSelector(CoreConfig::MIMOTO_ENTITY, CoreConfig::DATA_EVENT_UPDATED)],
//                'conditionals' => [
//                    (object) array('propertyName' => 'isUserExtension', 'type' => 'changed')
//                ],
//                'service' => (object) array(
//                    'name' => 'CoreData',
//                    'file' => 'CoreData/CoreData.php',
//                ),
//                'function' => 'markTableAsUserExtension',
//                'type' => 'sync',
//                'settings' => (object) array()
//            )

            // send Slack notification when critic notification was created

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
            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_entities', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_entities', // internal of external?
                'label' => 'xxx',
                'rules' => [
                    (object)array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_ENTITY
                    )
                ]
            ),
            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_layouts', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_layouts', // internal of external?
                'label' => 'xxx',
                'rules' => [
                    (object)array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_COMPONENT,
                        // values
                    )
                ]
            ),
            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_components', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_components', // internal of external?
                'label' => 'xxx',
                'rules' => [
                    (object)array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_COMPONENT
                    )
                ]
            ),
            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_selections', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_selections', // internal of external?
                'label' => 'xxx',
                'rules' => [
                    (object)array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_SELECTION
                    )
                ]
            ),
            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_datasets', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_datasets', // internal of external?
                'label' => 'All datasets',
                'rules' => [
                    (object)array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_DATASET
                    )
                ]
            ),
            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_instances_of_entity', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_instances_of_entity', // internal of external?
                'label' => 'All instances of entity',
                'rules' => [
                    (object)array(
                        SelectionRuleTypes::TYPE_AS_VAR => true,
                        SelectionRuleTypes::TYPE_VARNAME => 'typeVarName'
                    )
                ]
            ),
            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_properties_of_entity', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_properties_of_entity', // internal of external?
                'label' => 'All properties of entity',
                'rules' => [
                    (object) array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_ENTITY,
                        SelectionRuleTypes::ID_AS_VAR => true,
                        SelectionRuleTypes::ID_VARNAME => 'idVarName',
                        SelectionRuleTypes::PROPERTY => 'properties'
//                        SelectionRuleTypes::VALUES => [
//                            (object) array(
//                                'propertyName' => 'type',
//                                'value' => 'collection'
//                            )
//                        ]
                    )
                ]
            ),
            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_services', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_services', // internal of external?
                'label' => 'All services',
                'rules' => [
                    (object) array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_SERVICE
                    )
                ]
            ),


            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_public_services', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_public_services', // internal of external?
                'label' => 'All services',
                'rules' => [
                    (object) array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_SERVICE
                    )
                ],
                'data' => [
                    Service::getData(CoreConfig::MIMOTO_SERVICE.'-Data'),
                    Service::getData(CoreConfig::MIMOTO_SERVICE.'-Slack'),
                    Service::getData(CoreConfig::MIMOTO_SERVICE.'-SendGridService')
                ]
            ),


            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_functions_of_service', // internal of external?
                'name' => CoreConfig::CORE_PREFIX . 'all_functions_of_service', // internal of external?
                'label' => 'All functions of a service',
                'rules' => [
                    (object) array(
                        SelectionRuleTypes::TYPE => CoreConfig::MIMOTO_SERVICE,
                        SelectionRuleTypes::ID_AS_VAR => true,
                        SelectionRuleTypes::ID_VARNAME => 'idVarName',
                        SelectionRuleTypes::PROPERTY => 'functions'
                    )
                ]
            ),


            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_core_events',
                'name' => CoreConfig::CORE_PREFIX . 'all_core_events',
                'label' => 'All core data manipulation events',
                'rules' => [],
                'data' => [
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-event-CREATED'),
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-event-UPDATED'),
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-event-DELETED')
                ]
            ),

            (object) array(
                'id' => CoreConfig::CORE_PREFIX . 'all_conditionaltypes',
                'name' => CoreConfig::CORE_PREFIX . 'all_conditionaltypes',
                'label' => 'All core conditional types',
                'rules' => [],
                'data' => [
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED),
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::DID_NOT_CHANGE),
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED_INTO),
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED_FROM),
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CHANGED_FROM_INTO),
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::EQUALS),
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::CONTAINS),
                    CoreDataKeyValue::getData(CoreConfig::MIMOTO_COREDATA_KEYVALUE.'-conditionaltype-'.ConditionalTypes::DOES_NOT_EQUAL)
                ]
            )

        ];

        // send
        return $aSelections;
    }

    public static function getCoreData($sEntityTypeName, $sItemId)
    {
        // #todo - make generic

        //Mimoto::output($sEntityTypeName);

        switch($sEntityTypeName)
        {
            case CoreConfig::MIMOTO_FORMATTINGOPTION: return FormattingOption::getData($sItemId); break;
            case CoreConfig::MIMOTO_USER_ROLE: return UserRole::getData($sItemId); break;
            case CoreConfig::MIMOTO_COREDATA_KEYVALUE: return CoreDataKeyValue::getData($sItemId); break;
            case CoreConfig::MIMOTO_SERVICE: return Service::getData($sItemId); break;
            case CoreConfig::MIMOTO_SERVICE_FUNCTION: return ServiceFunction::getData($sItemId); break;
        }

        return false;
    }

}

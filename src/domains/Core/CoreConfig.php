<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Core\entities\Entity;
use Mimoto\Core\entities\EntityProperty;
use Mimoto\Core\entities\EntityPropertySetting;
use Mimoto\Core\entities\Component;
use Mimoto\Core\entities\ContentSection;
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
use Mimoto\Core\entities\InputRadioButton;
use Mimoto\Core\entities\InputTextline;
use Mimoto\Core\entities\InputMultiSelect;
use Mimoto\Core\entities\InputTextblock;
use Mimoto\Core\entities\InputTextRTF;
use Mimoto\Core\entities\InputList;
use Mimoto\Core\entities\InputImage;
use Mimoto\Core\entities\InputVideo;
use Mimoto\Core\entities\Notification;

use Mimoto\Core\forms\EntityPropertyForm_Value_type;
use Mimoto\Core\forms\EntityPropertyForm_Entity_allowedEntityType;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowedEntityTypes;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowDuplicates;


/**
 * CoreConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CoreConfig
{

    // settings
    const EPOCH = '1976-10-19 23:15:00';


    const CORE_PREFIX                           = '_MimotoAimless__';
    const WILDCARD                              = '*';
    const ENTITY_NEW                            = 'TheCakeIsALie';

    // core
    const MIMOTO_ENTITY                         = '_MimotoAimless__core__entity';
    const MIMOTO_ENTITYPROPERTY                 = '_MimotoAimless__core__entityproperty';
    const MIMOTO_ENTITYPROPERTYSETTING          = '_MimotoAimless__core__entitypropertysetting';

    // connections
    const MIMOTO_CONNECTIONS_CORE               = '_MimotoAimless__connections__core';
    const MIMOTO_CONNECTIONS_PROJECT            = '_MimotoAimless__connections__project';

    // views
    //const MIMOTO_TEMPLATE                     = '_mimoto_template';
    const MIMOTO_COMPONENT                      = '_MimotoAimless__view__component';
    const MIMOTO_COMPONENTCONDITIONAL           = '_MimotoAimless__view__componentconditional';
    //const MIMOTO_PAGE                         = '_MimotoAimless__view__page';

    // content
    const MIMOTO_CONTENTSECTION                 = '_MimotoAimless__core__contentsection';

    // forms
    const MIMOTO_FORM                           = '_MimotoAimless__interaction__form';
    const MIMOTO_FORM_INPUT                     = '_MimotoAimless__interaction__form_input';
    const MIMOTO_FORM_INPUTOPTION               = '_MimotoAimless__interaction__form_inputoption';
    const MIMOTO_FORM_INPUTVALIDATION           = '_MimotoAimless__interaction__form_inputvalidation';

    // input
    const MIMOTO_FORM_INPUT_TEXTLINE            = '_MimotoAimless__interaction__form_input_textline';
    const MIMOTO_FORM_INPUT_TEXTBLOCK           = '_MimotoAimless__interaction__form_input_textblock';
    const MIMOTO_FORM_INPUT_TEXTRTF             = '_MimotoAimless__interaction__form_input_textrtf';
    const MIMOTO_FORM_INPUT_CHECKBOX            = '_MimotoAimless__interaction__form_input_checkbox';
    const MIMOTO_FORM_INPUT_MULTISELECT         = '_MimotoAimless__interaction__form_input_multiselect';
    const MIMOTO_FORM_INPUT_RADIOBUTTON         = '_MimotoAimless__interaction__form_input_radiobutton';
    const MIMOTO_FORM_INPUT_DROPDOWN            = '_MimotoAimless__interaction__form_input_dropdown';
    const MIMOTO_FORM_INPUT_LIST                = '_MimotoAimless__interaction__form_input_list';
    const MIMOTO_FORM_INPUT_IMAGE               = '_MimotoAimless__interaction__form_input_image';
    const MIMOTO_FORM_INPUT_VIDEO               = '_MimotoAimless__interaction__form_input_video';

    // output
    const MIMOTO_FORM_OUTPUT_TITLE              = '_MimotoAimless__interaction__form_output_title';

    // layout
    const MIMOTO_FORM_LAYOUT_GROUPSTART         = '_MimotoAimless__interaction__form_layout_groupstart';
    const MIMOTO_FORM_LAYOUT_GROUPEND           = '_MimotoAimless__interaction__form_layout_groupend';
    const MIMOTO_FORM_LAYOUT_DIVIDER            = '_MimotoAimless__interaction__form_layout_divider';



    // functionality
    const MIMOTO_ACTION                         = '_MimotoAimless__config__action';


    const MIMOTO_NOTIFICATION                   = '_MimotoAimless__devtools__notification';


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
    const COREFORM_ENTITY               = '_MimotoAimless__coreform__entity';
    const COREFORM_ENTITYPROPERTY       = '_MimotoAimless__coreform__entityproperty';

    const COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE                     = '_MimotoAimless__coreform__entitypropertysetting_value_type';
    const COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE       = '_MimotoAimless__coreform__entitypropertysetting_entity_allowedEntityType';
    const COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES  = '_MimotoAimless__coreform__entitypropertysetting_value_allowedEntityTypes';
    const COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES     = '_MimotoAimless__coreform__entitypropertysetting_collection_allowDuplicates';

    const COREFORM_CONTENTSECTION               = '_MimotoAimless__coreform__contentsection';

    const COREFORM_COMPONENT                    = '_MimotoAimless__coreform__component';
    const COREFORM_FORM                         = '_MimotoAimless__coreform__form';
    const COREFORM_FORM_INPUTOPTION             = '_MimotoAimless__coreform__form_inputoption';
    const COREFORM_FORM_INPUTVALIDATION         = '_MimotoAimless__coreform__form_inputvalidation';


    // input
    const COREFORM_INPUT_TEXTLINE       = '_MimotoAimless__coreform__input_textline';
    const COREFORM_INPUT_TEXTBLOCK      = '_MimotoAimless__coreform_input_textblock';
    const COREFORM_INPUT_TEXTRTF        = '_MimotoAimless__coreform_input_textrtf';
    const COREFORM_INPUT_CHECKBOX       = '_MimotoAimless__coreform_input_checkbox';
    const COREFORM_INPUT_MULTISELECT    = '_MimotoAimless__coreform_input_multiselect';
    const COREFORM_INPUT_RADIOBUTTON    = '_MimotoAimless__coreform_input_radiobutton';
    const COREFORM_INPUT_DROPDOWN       = '_MimotoAimless__coreform_input_dropdown';
    const COREFORM_INPUT_LIST           = '_MimotoAimless__coreform_input_list';
    const COREFORM_INPUT_LIST_ITEM      = '_MimotoAimless__coreform_input_list_item';
    const COREFORM_INPUT_IMAGE          = '_MimotoAimless__coreform_input_image';
    const COREFORM_INPUT_VIDEO          = '_MimotoAimless__coreform_input_video';

    // output
    const COREFORM_OUTPUT_TITLE         = '_MimotoAimless__coreform_output_title';

    // layout
    const COREFORM_LAYOUT_GROUPSTART    = '_MimotoAimless__coreform_layout_groupstart';
    const COREFORM_LAYOUT_GROUPEND      = '_MimotoAimless__coreform_layout_groupend';
    const COREFORM_LAYOUT_DIVIDER       = '_MimotoAimless__coreform_layout_divider';



    // #todo
    // 1. noteer hier ook de tables en tableconfigs for installatie
    // 2. id en created in meta? Gelijk aan Aimless-component
    // 3. meta en data -> AimlessComponent maakt beschikbaar en vult aan met andere features



    public static function getCoreEntityConfigs()
    {

        // 1. load into memory in "EntityConfigRepository"


        // setup
        $aEntities = [

            // core
            Entity::getStructure(),
            EntityProperty::getStructure(),
            EntityPropertySetting::getStructure(),

            // views
            Component::getStructure(),

            // content
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
            InputTextblock::getStructure(),
            InputTextRTF::getStructure(),
            InputCheckbox::getStructure(),
            InputMultiSelect::getStructure(),
            InputRadioButton::getStructure(),
            InputDropdown::getStructure(),
            InputList::getStructure(),
            InputImage::getStructure(),
            InputVideo::getStructure(),

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
            EntityPropertyForm_Entity_allowedEntityType::getFormStructure(),
            EntityPropertyForm_Collection_allowedEntityTypes::getFormStructure(),
            EntityPropertyForm_Collection_allowDuplicates::getFormStructure(),

            // views
            Component::getFormStructure(),

            // content
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
//            //CoreConfig::COREFORM_INPUT_IMAGE => InputImage::getForm(),
//            //CoreConfig::COREFORM_INPUT_LIST => InputList::getForm(),
            InputMultiSelect::getFormStructure(),
            InputRadioButton::getFormStructure(),
//            CoreConfig::COREFORM_INPUT_TEXTBLOCK => InputTextBlock::getForm(),
            InputTextline::getFormStructure()
//            CoreConfig::COREFORM_INPUT_TEXTRTF => InputTextRTF::getForm(),
//            //CoreConfig::COREFORM_INPUT_VIDEO => InputVideo::getForm()
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
                        'title'
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

}

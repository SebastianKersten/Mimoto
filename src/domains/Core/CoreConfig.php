<?php

// classpath
namespace Mimoto\Core;

// Mimoto classes
use Mimoto\Core\config\Entity;
use Mimoto\Core\config\EntityProperty;
use Mimoto\Core\config\EntityPropertySetting;
use Mimoto\Core\config\Form;
use Mimoto\Core\config\Input;
use Mimoto\Core\config\InputValue;
use Mimoto\Core\config\OutputTitle;
use Mimoto\Core\config\LayoutGroupStart;
use Mimoto\Core\config\LayoutGroupEnd;
use Mimoto\Core\config\LayoutDivider;
use Mimoto\Core\config\InputCheckbox;
use Mimoto\Core\config\InputDropdown;
use Mimoto\Core\config\InputRadioButton;
use Mimoto\Core\config\InputTextline;
use Mimoto\Core\config\InputTextblock;
use Mimoto\Core\config\InputTextRTF;
use Mimoto\Core\config\InputList;
use Mimoto\Core\config\InputImage;
use Mimoto\Core\config\InputVideo;


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

    // forms
    const MIMOTO_FORM                           = '_MimotoAimless__interaction__form';
    const MIMOTO_FORM_INPUT                     = '_MimotoAimless__interaction__forminput';
    const MIMOTO_FORM_INPUTVALUE                = '_MimotoAimless__interaction__forminputvalue';
    const MIMOTO_FORM_INPUTVALUESETTING         = '_MimotoAimless__interaction__forminputvaluesetting';
    const MIMOTO_FORM_INPUTVALUEVALIDATION      = '_MimotoAimless__interaction__forminputvaluevalidation';

    // output
    const MIMOTO_FORM_OUTPUT_TITLE              = '_MimotoAimless__interaction__form_output_title';

    // layout
    const MIMOTO_FORM_LAYOUT_GROUPSTART         = '_MimotoAimless__interaction__form_layout_groupstart';
    const MIMOTO_FORM_LAYOUT_GROUPEND           = '_MimotoAimless__interaction__form_layout_groupend';
    const MIMOTO_FORM_LAYOUT_DIVIDER            = '_MimotoAimless__interaction__form_layout_divider';

    // intput
    const MIMOTO_FORM_INPUT_TEXTLINE            = '_MimotoAimless__interaction__form_input_textline';
    const MIMOTO_FORM_INPUT_TEXTBLOCK           = '_MimotoAimless__interaction__form_input_textblock';
    const MIMOTO_FORM_INPUT_TEXTRTF             = '_MimotoAimless__interaction__form_input_textrtf';
    const MIMOTO_FORM_INPUT_CHECKBOX            = '_MimotoAimless__interaction__form_input_checkbox';
    const MIMOTO_FORM_INPUT_RADIOBUTTON         = '_MimotoAimless__interaction__form_input_radiobutton';
    const MIMOTO_FORM_INPUT_DROPDOWN            = '_MimotoAimless__interaction__form_input_dropdown';
    const MIMOTO_FORM_INPUT_LIST                = '_MimotoAimless__interaction__form_input_list';
    const MIMOTO_FORM_INPUT_IMAGE               = '_MimotoAimless__interaction__form_input_image';
    const MIMOTO_FORM_INPUT_VIDEO               = '_MimotoAimless__interaction__form_input_video';

    // functionality
    const MIMOTO_ACTION                         = '_MimotoAimless__config__action';



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
            // ...

            // forms
            Form::getStructure(),
            Input::getStructure(),
            InputValue::getStructure(),

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
            InputRadiobutton::getStructure(),
            InputDropdown::getStructure(),
            InputList::getStructure(),
            InputImage::getStructure(),
            InputVideo::getStructure()
        ];

        // send
        return $aEntities;
    }

}

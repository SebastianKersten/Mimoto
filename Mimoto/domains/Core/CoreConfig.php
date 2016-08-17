<?php

// classpath
namespace Mimoto\Core;


/**
 * CoreConfig
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CoreConfig
{

    // settings
    const EPOCH = '1976-10-19 23:15:00';


    // core
    const MIMOTO_ENTITY = '_mimoto_entity';
    const MIMOTO_ENTITY_ID = 1;
    const MIMOTO_ENTITY_PREFIX = 'eid';
    
    const MIMOTO_ENTITYPROPERTY = '_mimoto_entityproperty';
    const MIMOTO_ENTITYPROPERTY_ID = 2;
    const MIMOTO_ENTITYPROPERTY_PREFIX = 'epid';

    const MIMOTO_ENTITYPROPERTYSETTING = '_mimoto_entitypropertysetting';
    const MIMOTO_ENTITYPROPERTYSETTING_ID = 3;
    const MIMOTO_ENTITYPROPERTYSETTING_PREFIX = 'pesid';

    // views
    const MIMOTO_TEMPLATE = '_mimoto_template';
    const MIMOTO_TEMPLATE_ID = 4;
    
    const MIMOTO_COMPONENT = '_mimoto_component';
    const MIMOTO_COMPONENT_ID = 5;

    const MIMOTO_PAGE = '_mimoto_page';
    const MIMOTO_PAGE_ID = 6;

    // forms
    const MIMOTO_FORM = '_mimoto_form';
    const MIMOTO_FORM_ID = 7;


    const MIMOTO_FORM_OUTPUT_TITLE = '_mimoto_form_output_title';
    const MIMOTO_FORM_OUTPUT_TITLE_ID = 100;

    const MIMOTO_FORM_LAYOUT_GROUPSTART = '_mimoto_form_layout_groupstart';
    const MIMOTO_FORM_LAYOUT_GROUPSTART_ID = 101;

    const MIMOTO_FORM_LAYOUT_GROUPEND = '_mimoto_form_layout_groupend';
    const MIMOTO_FORM_LAYOUT_GROUPEND_ID = 102;

    const MIMOTO_FORM_LAYOUT_DIVIDER = '_mimoto_form_layout_divider';
    const MIMOTO_FORM_LAYOUT_DIVIDER_ID = 103;

    const MIMOTO_FORM_INPUT_TEXTLINE = '_mimoto_form_input_textline';
    const MIMOTO_FORM_INPUT_TEXTLINE_ID = 200;

    const MIMOTO_FORM_INPUT_CHECKBOX = '_mimoto_form_input_checkbox';
    const MIMOTO_FORM_INPUT_CHECKBOX_ID = 201;

    const MIMOTO_FORM_INPUT_RADIOBUTTON = '_mimoto_form_input_radiobutton';
    const MIMOTO_FORM_INPUT_RADIOBUTTON_ID = 202;

    const MIMOTO_FORM_INPUT_DROPDOWN = '_mimoto_form_input_dropdown';
    const MIMOTO_FORM_INPUT_DROPDOWN_ID = 203;


    // functionality
    const MIMOTO_ACTION = '_mimoto_action';
    const MIMOTO_ACTION_ID = 20;



    // property types
    const PROPERTY_TYPE_VALUE = 'value';
    const PROPERTY_TYPE_ENTITY = 'entity';
    const PROPERTY_TYPE_COLLECTION = 'collection';

    // data types
    const DATA_TYPE_VALUE = 'value';
    const DATA_TYPE_BOOLEAN = 'boolean';

    // data values
    const DATA_VALUE_TEXTLINE = 'textline';
    const DATA_VALUE_TEXTBLOCK = 'textblock';
    const DATA_VALUE_TRUE = 'true';
    const DATA_VALUE_FALSE = 'false';



    const GROUP_MIMOTO_CORE = 'Group:Mimoto.Core';
    const GROUP_MIMOTO_FORM_INPUT = 'Group:Mimoto.Form.Input';
    const GROUP_MIMOTO_FORM_OUTPUT = 'Group:Mimoto.Form.Output';
    const GROUP_MIMOTO_FORM_LAYOUT = 'Group:Mimoto.Form.Layout';



    // #todo
    // 1. noteer hier ook de tables en tableconfigs for installatie
    // 2. id en created in meta? Gelijk aan Aimless-component
    // 3. meta en data -> AimlessComponent maakt beschikbaar en vult aan met andere features



    static function getCoreEntityConfigs()
    {

        // --------------------------------------------------------------------------------
        // --- _mimoto_entity, _mimoto_entityproperty and _mimoto_entitypropertysetting ---
        // --------------------------------------------------------------------------------

        // setup
        $aEntities = [
            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_ENTITY_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_ENTITY,
                'group' => CoreConfig::GROUP_MIMOTO_CORE,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'1',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'name',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'1',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'1000',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'group',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'_group',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'2',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'properties',
                        'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                        'settings' => [
                            'allowedEntityTypes' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'2',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'allowedEntityTypes',
                                'type' => 'array',
                                'value' => '["'.CoreConfig::MIMOTO_ENTITY_PREFIX.'2"]'
                            ),
                            'allowDuplicates' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'3',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'allowDuplicates',
                                'type' => CoreConfig::DATA_TYPE_BOOLEAN,
                                'value' => CoreConfig::DATA_VALUE_FALSE
                            )
                        ]
                    )
                ]
            ),
            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_ENTITYPROPERTY_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_ENTITYPROPERTY,
                'group' => CoreConfig::GROUP_MIMOTO_CORE,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'3',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'name',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'4',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'4',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'type',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'5',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'5',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'settings',
                        'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                        'settings' => [
                            'allowedEntityTypes' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'6',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'allowedEntityTypes',
                                'type' => 'array',
                                'value' => '["'.CoreConfig::MIMOTO_ENTITY_PREFIX.'3"]'

                            ),
                            'allowDuplicates' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'7',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'allowDuplicates',
                                'type' => CoreConfig::DATA_TYPE_BOOLEAN,
                                'value' => CoreConfig::DATA_VALUE_FALSE
                            )
                        ]
                    )
                ]
            ),
            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING,
                'group' => CoreConfig::GROUP_MIMOTO_CORE,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'6',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'key',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'8',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'7',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'type',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'9',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'8',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'value',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'10',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    )
                ]
            ),



            // --------------------------------------------------------------------------------
            // --- _mimoto_form ---------------------------------------------------------------
            // --------------------------------------------------------------------------------


            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM,
                'group' => CoreConfig::GROUP_MIMOTO_CORE,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'9',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'name',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'11',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => 'epid_fields', //CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'10',
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'fields',
                        'type' => CoreConfig::PROPERTY_TYPE_COLLECTION,
                        'settings' => [
                            'allowedEntityTypes' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'12',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'allowedEntityTypes',
                                'type' => 'array',
                                'value' => '[
                                    "'.CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_OUTPUT_TITLE_ID.'"
                                ]'
                            ),
                            'allowDuplicates' => (object) array(
                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'13',
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'allowDuplicates',
                                'type' => CoreConfig::DATA_TYPE_BOOLEAN,
                                'value' => CoreConfig::DATA_VALUE_TRUE
                            )
                        ]
                    )
                ]
            ),




            // --------------------------------------------------------------------------------
            // --- Form output ----------------------------------------------------------------
            // --------------------------------------------------------------------------------


            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_OUTPUT_TITLE_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
                'group' => CoreConfig::GROUP_MIMOTO_FORM_OUTPUT,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'title',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'subtitle',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'description',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTBLOCK
                            )
                        ]
                    )
                ]
            ),



            // --------------------------------------------------------------------------------
            // --- Form layout ----------------------------------------------------------------
            // --------------------------------------------------------------------------------


            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART,
                'group' => CoreConfig::GROUP_MIMOTO_FORM_LAYOUT,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'title',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    )
                ]
            ),

            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND,
                'group' => CoreConfig::GROUP_MIMOTO_FORM_LAYOUT,
                'properties' => []
            ),

            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER,
                'group' => CoreConfig::GROUP_MIMOTO_FORM_LAYOUT,
                'properties' => []
            ),



            // --------------------------------------------------------------------------------
            // --- Form input -----------------------------------------------------------------
            // --------------------------------------------------------------------------------


            // ==> Textline

            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
                'group' => CoreConfig::GROUP_MIMOTO_FORM_INPUT,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'label',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'regexp',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'maxchars',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    )
                ]
            ),


            // ==> Checkbox

            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX,
                'group' => CoreConfig::GROUP_MIMOTO_FORM_INPUT,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'label',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'description',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    )
                ]
            ),


            // ==> Radiobutton

            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON,
                'group' => CoreConfig::GROUP_MIMOTO_FORM_INPUT,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'label',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'options',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE, // #todo ---> kan Selection worden
                                'value' => CoreConfig::DATA_VALUE_TEXTBLOCK
                            )
                        ]
                    )
                ]
            ),

            // ==> Dropdown

            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN,
                'group' => CoreConfig::GROUP_MIMOTO_FORM_INPUT,
                'properties' => [
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'label',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE,
                                'value' => CoreConfig::DATA_VALUE_TEXTLINE
                            )
                        ]
                    ),
                    (object) array(
                        'id' => CoreConfig::getUniqueEntityPropertyId(),
                        'created' => CoreConfig::EPOCH,
                        // ---
                        'name' => 'options',
                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
                        'settings' => [
                            'type' => (object) array(
                                'id' => CoreConfig::getUniqueEntityPropertySettingId(),
                                'created' => CoreConfig::EPOCH,
                                // ---
                                'key' => 'type',
                                'type' => CoreConfig::DATA_TYPE_VALUE, // #todo ---> kan Selection worden
                                'value' => CoreConfig::DATA_VALUE_TEXTBLOCK
                            )
                        ]
                    )
                ]
            ),

        ];

        // send
        return $aEntities;
    }


    static function getCoreEntities()
    {
        
    }


    static function getUniqueEntityPropertyId()
    {
        return CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'_uniqueToDo';
    }

    static function getUniqueEntityPropertySettingId()
    {
        return CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'_uniqueToDo';
    }
}
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

    const MIMOTO_FORM_INPUT = '_mimoto_form_input';
    const MIMOTO_FORM_INPUT_ID = 8;

    const MIMOTO_FORM_OUTPUT_TITLE = '_mimoto_form_output_title';
    const MIMOTO_FORM_OUTPUT_TITLE_ID = 100;

    const MIMOTO_FORM_OUTPUT_GROUP_START = '_mimoto_form_output_group_start';
    const MIMOTO_FORM_OUTPUT_GROUP_START_ID = 101;

    const MIMOTO_FORM_OUTPUT_GROUP_END = '_mimoto_form_output_group_end';
    const MIMOTO_FORM_OUTPUT_GROUP_END_ID = 102;

    const MIMOTO_FORM_INPUT_textline = '_mimoto_form_input_textline';
    const MIMOTO_FORM_INPUT_textline_id = 200;

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
            // --- _mimoto_form_input ---------------------------------------------------------
            // --------------------------------------------------------------------------------


            // name
            // entity-selector "query?" of id
            //



//            (object) array(
//                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_INPUT_ID,
//                'created' => CoreConfig::EPOCH,
//                // ---
//                'name' => CoreConfig::MIMOTO_FORM_INPUT,
//                'properties' => [
//                    (object) array(
//                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'9',
//                        'name' => 'name',
//                        'type' => CoreConfig::PROPERTY_TYPE_VALUE,
//                        'created' => CoreConfig::EPOCH,
//                        'settings' => [
//                            'type' => (object) array(
//                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'11',
//                                'key' => 'type',
//                                'type' => CoreConfig::DATA_TYPE_VALUE,
//                                'value' => CoreConfig::DATA_VALUE_TEXTLINE,
//                                'created' => CoreConfig::EPOCH
//                            )
//                        ]
//                    ),
//                    (object) array(
//                        'id' => CoreConfig::MIMOTO_ENTITYPROPERTY_PREFIX.'10',
//                        'name' => 'value',
//                        'type' => CoreConfig::PROPERTY_TYPE_ENTITY,
//                        'created' => CoreConfig::EPOCH,
//                        'settings' => [
//                            'allowedEntityTypes' => (object) array(
//                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'12',
//                                'key' => 'allowedEntityTypes',
//                                'type' => 'array',
//                                'value' => '["'.CoreConfig::MIMOTO_ENTITY_PREFIX.'3"]',
//                                'created' => CoreConfig::EPOCH
//                            ),
//                            'allowDuplicates' => (object) array(
//                                'id' => CoreConfig::MIMOTO_ENTITYPROPERTYSETTING_PREFIX.'13',
//                                'key' => 'allowDuplicates',
//                                'type' => CoreConfig::DATA_TYPE_BOOLEAN,
//                                'value' => CoreConfig::DATA_VALUE_TRUE,
//                                'created' => CoreConfig::EPOCH
//                            )
//                        ]
//                    )
//                ]
//            ),





            // --------------------------------------------------------------------------------
            // --- Form output ----------------------------------------------------------------
            // --------------------------------------------------------------------------------




            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_OUTPUT_TITLE_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,
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

            (object) array(
                'id' => CoreConfig::MIMOTO_ENTITY_PREFIX.CoreConfig::MIMOTO_FORM_OUTPUT_GROUP_START_ID,
                'created' => CoreConfig::EPOCH,
                // ---
                'name' => CoreConfig::MIMOTO_FORM_OUTPUT_GROUP_START,
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
            )


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
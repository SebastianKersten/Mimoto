<?php

// classpath
namespace Mimoto\EntityConfig;


/**
 * MimotoEntityPropertyValueTypes
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityPropertyValueTypes
{
    // value types
    const VALUETYPE_TEXT        = 'text';
    const VALUETYPE_BOOLEAN     = 'boolean';
    const VALUETYPE_ARRAY       = 'array';
    const VALUETYPE_INTEGER     = 'integer';
    const VALUETYPE_FLOAT       = 'float';
    const VALUETYPE_DATETIME    = 'datetime';

    // connection related value types
    const VALUETYPE_ID          = 'valuetype_id';
    const VALUETYPE_CONNECTION  = 'valuetype_connection';
    const VALUETYPE_ENTITY      = 'valuetype_entity';
    const VALUETYPE_EMPTY       = 'valuetype_empty';
}

<?php

// classpath
namespace Mimoto\EntityConfig;


/**
 * MimotoEntityPropertyTypes
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityPropertyTypes
{
    // property types
    const PROPERTY_TYPE_VALUE = 'value';
    const PROPERTY_TYPE_ENTITY = 'entity';
    const PROPERTY_TYPE_COLLECTION = 'collection';

    // propery subtypes
    const PROPERTY_SUBTYPE_IMAGE = 'image';
    const PROPERTY_SUBTYPE_VIDEO = 'video';
    const PROPERTY_SUBTYPE_AUDIO = 'audio';
    const PROPERTY_SUBTYPE_FILE = 'file';

    // property setting default value types
    const PROPERTY_SETTING_DEFAULTVALUE_TYPE_NONE = '';
    const PROPERTY_SETTING_DEFAULTVALUE_TYPE_CURRENTTIMESTAMP = 'currentTimestamp';
    const PROPERTY_SETTING_DEFAULTVALUE_TYPE_CURRENTUSER = 'currentUser';
    const PROPERTY_SETTING_DEFAULTVALUE_TYPE_NEWENTITYINSTANCE = 'newEntityInstance';

}

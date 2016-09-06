<?php

// classpath
namespace Mimoto\Aimless;


/**
 * MimotoAimlessUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoAimlessUtils
{
    
    public static function formatAimlessValue($sEntityType, $nId, $sPropertyName)
    {
        return $sEntityType.'.'.$nId.'.'.$sPropertyName;
    }
    
    public static function formatAimlessSubvalue($sEntityType, $nId, $sPropertyName)
    {
        return '['.$sEntityType.'.'.$nId.'.'.$sPropertyName.']';
    }
    
    public static function formatAimlessSubvalueWithoutId($sEntityType, $sPropertyName)
    {
        return '['.$sEntityType.'.'.$sPropertyName.']';
    }
    
}

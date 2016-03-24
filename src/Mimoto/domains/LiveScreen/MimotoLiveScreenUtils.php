<?php

// classpath
namespace Mimoto\LiveScreen;


/**
 * MimotoLiveScreenUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoLiveScreenUtils
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
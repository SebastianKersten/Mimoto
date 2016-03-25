<?php

// classpath
namespace Mimoto\library\data;


/**
 * MimotoDataUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoDataUtils
{
    
    public static function getPropertyFromPropertySelector($sPropertySelector)
    {
        // find
        $nSeperatorPos = strpos($sPropertySelector, '.');
        
        // separate
        $sPropertyName = ($nSeperatorPos !== false) ? substr($sPropertySelector, 0, $nSeperatorPos) : $sPropertySelector;
        
        // send
        return $sPropertyName;
    }
    
    public static function getSubselectorFromPropertySelector($sPropertySelector, $sPropertyName)
    {
        // send subselector or false is none present
        return ($sPropertySelector === $sPropertyName) ? false : substr($sPropertySelector, strlen($sPropertyName) + 1);
    }
    
    public static function validatePropertySelector($sPropertySelector)
    {
        // 1. Toegestaan: a-zA-Z0-9._[]{}*=
    }
    
    public static function isEntity($value)
    {
        return ($value instanceof MimotoEntity);
    }
    
    public static function isValidEntityId($value)
    {
        return (!is_nan(intval($value)) && $value > 0);
    }
    
}
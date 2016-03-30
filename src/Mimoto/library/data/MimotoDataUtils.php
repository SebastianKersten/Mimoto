<?php

// classpath
namespace Mimoto\library\data;

// Mimoto classes
use Mimoto\Data\MimotoEntity;


/**
 * MimotoDataUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoDataUtils
{
        
    public static function validatePropertyName($sPropertyName)
    {
        return preg_match("/^[a-zA-Z][a-zA-Z0-9-_]*(\.[a-zA-Z][a-zA-Z0-9]*)*$/", $sPropertyName);
    }
    
    public static function validatePropertySelector($sPropertySelector)
    {
        // 1. Toegestaan: a-zA-Z0-9._[]{}*=
        // 2. preg_math op juiste '[a-zA-Z0-9]' // start met a-zA-Z
        // 3. {xxx='xxx'} of {xxx="xxx"}
        // 4. [[0-9]] of ["[a-zA-Z0-9]"]
        
        return true;
        
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
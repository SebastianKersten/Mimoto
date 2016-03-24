<?php

// classpath
namespace Mimoto\library\entities;


/**
 * MimotoEntityUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityUtils
{
    
    public static function isEntity($value)
    {
        return ($value instanceof MimotoEntity);
    }
    
    public static function isValidEntityId($value)
    {
        return (!is_nan($value) && $value > 0);
    }
    
}
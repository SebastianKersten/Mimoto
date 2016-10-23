<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityConnection;


/**
 * MimotoDataUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoDataUtils
{

    // const ENT

//    public static function getValueType($xValue)
//    {
//
//    }



    public static function validatePropertyName($sPropertyName)
    {
        // check _MimotoAimless__ CoreConfig::CORE_PREFIX

        return preg_match("/^[a-zA-Z-_][a-zA-Z0-9-_]*(\.[a-zA-Z-_][a-zA-Z0-9_-]*)*$/", $sPropertyName);
        //return preg_match("/^[a-zA-Z][a-zA-Z0-9-_]*(\.[a-zA-Z][a-zA-Z0-9_-]*)*$/", $sPropertyName);
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
        if (is_object($value)) return false;

        return (preg_match("/^[a-zA-Z0-9_-]*?$/", $value)) ? true : false;
    }
    
    public static function hasExpression($sPropertySelector)
    {
        return (preg_match("/^{[a-zA-Z0-9=\"']*?}$/", $sPropertySelector));
    }
    
    public static function getConditionals($sPropertySelector)
    {
        // init
        $aConditionals = [];
        
        // verify
        if (MimotoDataUtils::hasExpression($sPropertySelector))
        {
            
            // 1. query, with && en || support, comma separated
            // 2. Example: {phase="archived"}
            
            // register
            $sExpression = substr($sPropertySelector, 1, strlen($sPropertySelector) - 2);
            $aExpressionElements = explode('=', $sExpression);
            
            
            // update
            $sExpressionKey = trim($aExpressionElements[0]);
            $sExpressionValue = trim($aExpressionElements[1]);
            
            // register
            $sFirstChar = $sExpressionValue[0];
            $sLastChar = $sExpressionValue[strlen($sExpressionValue) - 1];
            
            // cleanup
            if (($sFirstChar === "'" && $sLastChar === "'") || ($sFirstChar == '"' && $sLastChar == '"'))
            {
                $sExpressionValue = substr($sExpressionValue, 1, strlen($sExpressionValue) - 2);
            }
            
            // store
            $aConditionals[$sExpressionKey] = $sExpressionValue;
        }
        
        // send
        return $aConditionals;
    }


    public static function connectionsAreSimilar(MimotoEntityConnection $connection1, MimotoEntityConnection $connection2)
    {
        return
        (
            $connection1->getId() == $connection2->getId() || empty($connection1->getId() || empty($connection2->getId())) &&
            $connection1->getParentEntityTypeId() == $connection2->getParentEntityTypeId() &&
            $connection1->getParentPropertyId() == $connection2->getParentPropertyId() &&
            $connection1->getParentId() == $connection2->getParentId() &&
            $connection1->getChildEntityTypeId() == $connection2->getChildEntityTypeId() &&
            $connection1->getChildId() == $connection2->getChildId() &&
            $connection1->getSortIndex() == $connection2->getSortIndex()
        ) ? true : false;
    }

}

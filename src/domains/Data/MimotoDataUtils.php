<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoEntityConnection;
use Mimoto\EntityConfig\MimotoEntityPropertyValueTypes;


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

    /**
     * Get value type
     * @param $xValue Mixed value
     * @return null|string
     */
    public static function getValueType($xValue)
    {
        // 1. check if value is a connection
        if ($xValue instanceof MimotoEntityConnection) return MimotoEntityPropertyValueTypes::VALUETYPE_CONNECTION;

        // 2. check if value is an entity
        if (MimotoDataUtils::isEntity($xValue)) return MimotoEntityPropertyValueTypes::VALUETYPE_ENTITY;

        // 3. check if value is a valid entity
        if (MimotoDataUtils::isValidEntityId($xValue)) return MimotoEntityPropertyValueTypes::VALUETYPE_ID;

        // 4. check if value is empty
        if (empty($xValue)) return MimotoEntityPropertyValueTypes::VALUETYPE_EMPTY;

        // 5. no known type found
        return null;
    }
    
    public static function hasExpression($sPropertySelector)
    {
        return (preg_match("/^{[a-zA-Z0-9=\"']*?}$/", $sPropertySelector));
    }
    
    public static function getConditionalsAndSubselector($sPropertySelector)
    {
        // init
        $selector = (object) array(
            'conditionals' => [],
            'subpropertyselector' => null
        );

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
            $selector->conditionals[$sExpressionKey] = $sExpressionValue;
        }
        
        // send
        return $selector;
    }


    public static function connectionsAreSimilar(MimotoEntityConnection $connection1, MimotoEntityConnection $connection2)
    {
        return
        (
            ($connection1->getId() == $connection2->getId() || empty($connection1->getId()) || empty($connection2->getId())) &&
            $connection1->getParentEntityTypeId() == $connection2->getParentEntityTypeId() &&
            $connection1->getParentPropertyId() == $connection2->getParentPropertyId() &&
            $connection1->getParentId() == $connection2->getParentId() &&
            $connection1->getChildEntityTypeId() == $connection2->getChildEntityTypeId() &&
            $connection1->getChildId() == $connection2->getChildId() // &&
            //$connection1->getSortIndex() == $connection2->getSortIndex()
        ) ? true : false;
    }

    /**
     * Get entity type from entityInstance-selector
     * @param $Selector
     * @return string
     */
    public static function getEntityTypeFromEntityInstanceSelector($Selector)
    {
        // split
        $aParts = explode('.', $Selector);

        // send
        return $aParts[0];
    }

    /**
     * Get entity id from entityInstance-selector
     * @param $Selector
     * @return string
     */
    public static function getEntityIdFromEntityInstanceSelector($sSelector)
    {
        // split
        $aParts = explode('.', $sSelector);

        // send
        return $aParts[1];
    }

    /**
     * Create connection
     * @param mixed $xValue
     * @param mixed $xParentEntityTypeId
     * @param mixed $xParentPropertyId
     * @param int $nParentId
     * @param array $aAllowedPropertyTypes
     * @param string $sPropertyName For purpose of error messages
     * @return MimotoEntityConnection|null
     */
    public static function createConnection($xValue, $xParentEntityTypeId, $xParentPropertyId, $nParentId, $aAllowedPropertyTypes, $xEntityTypeId, $sPropertyName)
    {
        // 1. init
        $connection = null;

        // 2. determine
        $sValueType = MimotoDataUtils::getValueType($xValue);

        // 3. prepare
        $aAllowedEntityTypeIds = MimotoDataUtils::flattenAllowedEntityTypes($aAllowedPropertyTypes);

        // 4. toggle
        switch($sValueType)
        {
            case MimotoEntityPropertyValueTypes::VALUETYPE_CONNECTION:
            case MimotoEntityPropertyValueTypes::VALUETYPE_ENTITY:
            case MimotoEntityPropertyValueTypes::VALUETYPE_ID:

                switch ($sValueType)
                {
                    case MimotoEntityPropertyValueTypes::VALUETYPE_CONNECTION:

                        // inherit
                        $connection = $xValue;

                        // compose
                        $connection->setChildEntityTypeId($xValue->getChildEntityTypeId());
                        $connection->setChildId($xValue->getChildId());
                        break;

                    case MimotoEntityPropertyValueTypes::VALUETYPE_ENTITY:
                    case MimotoEntityPropertyValueTypes::VALUETYPE_ID:

                        // 2. initialize new connection
                        $connection = new MimotoEntityConnection();
                        $connection->setParentEntityTypeId($xParentEntityTypeId);
                        $connection->setParentPropertyId($xParentPropertyId);
                        $connection->setParentId($nParentId);
                        $connection->setSortIndex(0);

                        switch ($sValueType)
                        {
                            case MimotoEntityPropertyValueTypes::VALUETYPE_ENTITY:

                                // compose
                                $connection->setChildEntityTypeId($xValue->getEntityTypeId());
                                $connection->setChildId($xValue->getId());
                                $connection->setEntity($xValue);
                                break;

                            case MimotoEntityPropertyValueTypes::VALUETYPE_ID:

                                // compose
                                $connection->setChildEntityTypeId($xEntityTypeId);
                                $connection->setChildId($xValue);
                                break;
                        }

                        break;
                }

                // validate config
                if (count($aAllowedEntityTypeIds) == 0)
                {
                    Mimoto::service('log')->silent("Missing configuration of allowed property types", "Please define which value types are allowed to connect to property '".$sPropertyName."'");
                    $connection = null;
                    break;
                }

                // validate childEntityType
                if (!empty($connection) && (empty($connection->getChildId()) || !MimotoDataUtils::isValidEntityId($connection->getChildId())))
                {
                    $connection = null;
                }
                else
                {
                    // validate
                    if (!in_array($connection->getChildEntityTypeId(), $aAllowedEntityTypeIds) && !in_array(CoreConfig::WILDCARD, $aAllowedEntityTypeIds))
                    {
                        Mimoto::service('log')->error("Incorrect value", "The property '".$sPropertyName."' only allows '".implode(',', MimotoDataUtils::flattenAllowedEntityTypes($aAllowedPropertyTypes, true))."'", true);
                    }
                }

                break;

            default:

                Mimoto::service('log')->silent("Unknown connection value", "The property '".$sPropertyName."' only allows values of type '".implode(',', $aAllowedPropertyTypes)."'", true);
                break;
        }

        // send
        return $connection;
    }

    /**
     * Flatten allowedEntityTypes
     * @param array $aAllowedEntityTypes
     * @param bool|null $bGetNamesInsteadOfIds
     * @return array Single array with the id's of the entities
     */
    public static function flattenAllowedEntityTypes($aAllowedEntityTypes, $bGetNamesInsteadOfIds = false)
    {
        // 1. init
        $aFlattenedAllowedEntityTypes = [];

        // 2. flatten
        $nAllowedEntityTypeCount = count($aAllowedEntityTypes);
        for ($nAllowedEntityTypeIndex = 0; $nAllowedEntityTypeIndex < $nAllowedEntityTypeCount; $nAllowedEntityTypeIndex++)
        {
            $aFlattenedAllowedEntityTypes[] = (!$bGetNamesInsteadOfIds) ? $aAllowedEntityTypes[$nAllowedEntityTypeIndex]->id : $aAllowedEntityTypes[$nAllowedEntityTypeIndex]->name;
        }

        // 3. send
        return $aFlattenedAllowedEntityTypes;
    }

    /**
     * Convert stored value to runtime value
     * @param mixed $value The value that has one of the types defined in MimotoEntityPropertyValueTypes
     * @param string $sType The preferred type of the value
     * @return mixed Runtime usable value
     */
    public static function convertStoredValueToRuntimeValue($value, $sType)
    {
        // convert
        switch ($sType)
        {
            case MimotoEntityPropertyValueTypes::VALUETYPE_TEXT:

                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN:

                // convert
                $value = ($value == 1) ? true : false;
                break;

            default:

                break;
        }

        // send
        return $value;
    }

    /**
     * Convert runtime value to storable value
     * @param mixed $value The value that has one of the types defined in MimotoEntityPropertyValueTypes
     * @param string $sType The preferred type of the value
     * @return mixed Storable value
     */
    public static function convertRuntimeValueToStorableValue($value, $sType)
    {
        // convert
        switch ($sType)
        {
            case MimotoEntityPropertyValueTypes::VALUETYPE_TEXT:

                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN:

                // convert
                $value = ($value === true) ? 1 : 0;
                break;

            default:

                break;
        }

        // send
        return $value;
    }
}

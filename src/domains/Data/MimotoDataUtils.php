<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\EntityConfig\EntityConfig;
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

    public static function buildSelector(...$aSelectorElements)
    {
        // 1/ init
        $sSelector = '';

        // 2. build
        foreach ( $aSelectorElements as $aSelectorElement)
        {
            if (!empty($sSelector)) $sSelector .= '.';
            $sSelector .= $aSelectorElement;
        }

        // 3. send
        return $sSelector;
    }

    public static function validatePropertyName($sPropertyName)
    {
        return preg_match("/^[a-zA-Z-_][a-zA-Z0-9-_]*(\.[a-zA-Z-_][a-zA-Z0-9_-]*)*$/", $sPropertyName);
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

    public static function isValidId($value)
    {
        // validate
        if (is_object($value)) return false;

        // verify
        if (is_string($value) && substr($value, 0, strlen(CoreConfig::CORE_PREFIX)) == CoreConfig::CORE_PREFIX)
        {
            return (preg_match("/^".CoreConfig::CORE_PREFIX."[a-zA-Z0-9_-]{1,}$/", $value)) ? true : false;
        }
        else
        {
            return (preg_match("/^[0-9]{1,}$/", $value)) ? true : false;
        }
    }

    public static function isValidEntityName($value)
    {
        // validate
        if (is_object($value)) return false;

        // verify
        if (is_string($value) && substr($value, 0, strlen(CoreConfig::CORE_PREFIX)) == CoreConfig::CORE_PREFIX)
        {
            return (preg_match("/^".CoreConfig::CORE_PREFIX."[a-zA-Z0-9_-]{1,}$/", $value)) ? true : false;
        }
        else
        {
            return (preg_match("/^[a-zA-Z][a-zA-Z0-9_-]*$/", $value)) ? true : false;
        }
    }

    /**
     * Check if a propertyId is formatted correctly
     * @param $value
     * @return bool
     */
    public static function isValidPropertyId($value)
    {
        // validate
        if (is_object($value)) return false;

        // verify
        if (is_string($value) && substr($value, 0, strlen(CoreConfig::CORE_PREFIX)) == CoreConfig::CORE_PREFIX)
        {
            return (preg_match("/^".CoreConfig::CORE_PREFIX."[a-zA-Z0-9_-]{1,}$/", $value)) ? true : false;
        }
        else
        {
            return (preg_match("/^[0-9]{1,}$/", $value)) ? true : false;
        }
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
        if (MimotoDataUtils::isValidId($xValue)) return MimotoEntityPropertyValueTypes::VALUETYPE_ID;

        // 4. check if value is empty
        if (empty($xValue)) return MimotoEntityPropertyValueTypes::VALUETYPE_EMPTY;

        // 5. no known type found
        return null;
    }
    
    public static function hasExpression($sPropertySelector)
    {
        return (preg_match("/^{[a-zA-Z0-9=\"',!]*?}$/", $sPropertySelector));
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
            
            // strip { and }
            $sExpression = substr($sPropertySelector, 1, strlen($sPropertySelector) - 2);

            // isolate individual expressions
            $aExpressions = explode(',', $sExpression);


            foreach($aExpressions as $sKey => $sExpression)
            {
                // handle expression: xxx=yyy
                if (strpos($sExpression, '='))
                {
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
                }
                // handle boolean
                else
                {
                    // init
                    $sExpressionValue = true;

                    // update
                    if (preg_match('/!/', $sExpression, $matches, PREG_OFFSET_CAPTURE) === 1)
                    {
                        $sExpression = preg_replace('/!/', '', $sExpression);
                        $sExpressionValue = false;
                    }

                    // cleanup
                    $sExpressionKey = trim($sExpression);
                }

                // store
                $selector->conditionals[$sExpressionKey] = $sExpressionValue;
            }
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
    public static function getEntityTypeFromEntityInstanceSelector($sSelector)
    {
        // split
        $aParts = explode('.', $sSelector);

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
        // #todo
        if (empty($sSelector) || substr($sSelector, 0, 1) == '[') return null; // can't handle collections yet

        // split
        $aParts = explode('.', $sSelector);

        // send
        return $aParts[1];
    }

    /**
     * Get property from entityProperty-selector
     * @param $Selector
     * @return string
     */
    public static function getPropertyFromFromEntityPropertySelector($sEntityPropertySelector)
    {
        // split
        $aParts = explode('.', $sEntityPropertySelector);

        // send
        return $aParts[2];
    }

    /**
     * Create connection
     * @param mixed $xValue
     * @param mixed $xParentEntityTypeId
     * @param mixed $xParentPropertyId
     * @param int $nParentId
     * @param array $aAllowedEntityTypes
     * @param string $sPropertyName For purpose of error messages
     * @return MimotoEntityConnection|null
     */
    public static function createConnection($xValue, $xParentEntityTypeId, $xParentPropertyId, $nParentId, $aAllowedEntityTypes, $xEntityTypeId, $sPropertyName)
    {
        // 1. init
        $connection = null;

        // 2. determine
        $sValueType = MimotoDataUtils::getValueType($xValue);

        // 3. prepare
        $aAllowedEntityTypeIds = MimotoDataUtils::flattenAllowedEntityTypes($aAllowedEntityTypes);

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
//                if (count($aAllowedEntityTypeIds) == 0)
//                {
//                    Mimoto::service('log')->silent("Missing configuration of allowed property types", "Please define which value types are allowed to connect to property '".$sPropertyName."'");
//                    $connection = null;
//                    break;
//                }

                // validate childEntityType
                if (!empty($connection) && (empty($connection->getChildId()) || !MimotoDataUtils::isValidId($connection->getChildId())))
                {
                    $connection = null;
                }
                else
                {
                    // read
                    $sChildEntityTypeId = $connection->getChildEntityTypeId();


                    // init
                    $bValidated = false;

                    // search
                    $nAllowedEntityTypeIdCount = count($aAllowedEntityTypeIds);
                    for ($nAllowedEntityTypeIdIndex = 0; $nAllowedEntityTypeIdIndex < $nAllowedEntityTypeIdCount; $nAllowedEntityTypeIdIndex++)
                    {
                        // register
                        $sAllowedEntityTypeId = $aAllowedEntityTypeIds[$nAllowedEntityTypeIdIndex];

                        // validate
                        if (Mimoto::service('entityConfig')->entityIsTypeOf($sChildEntityTypeId, $sAllowedEntityTypeId))
                        {
                            $bValidated = true;
                            break;
                        }
                    }

                    // verify
                    if (!$bValidated && empty($aAllowedEntityTypeIds)) $bValidated = true;

                    // validate
                    if (!$bValidated)
                    {
                        Mimoto::output('Connection error', $connection);
                        Mimoto::service('log')->error("Incorrect value", "The property '".Mimoto::service('entityConfig')->getEntityNameById($xParentEntityTypeId).".$sPropertyName' only allows '".implode(',', MimotoDataUtils::flattenAllowedEntityTypes($aAllowedEntityTypes, true))."' (and not `".Mimoto::service('entityConfig')->getEntityNameById($sChildEntityTypeId)."`)", true);
                    }

                }

                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_EMPTY:

                $connection = null;
                break;

            default:

                Mimoto::service('log')->error("Unknown connection value", "The property '".$sPropertyName."' only allows values of type '".implode(',', MimotoDataUtils::flattenAllowedEntityTypes($aAllowedEntityTypes, true))."'", true);
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
    public static function convertStoredValueToRuntimeValue($value, $sType, $sSubtype)
    {
        // convert
        switch ($sType)
        {
            case MimotoEntityPropertyValueTypes::VALUETYPE_TEXT:

                switch($sSubtype)
                {
                    case MimotoEntityPropertyValueTypes::VALUETYPE_INTEGER:

                        break;

                    case MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN:

                        // convert
                        $value = ($value == 1) ? true : false;
                        break;

                    case MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME:

                        break;

                    case MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD:

                        $value = json_decode($value);
                        break;

                    case MimotoEntityPropertyValueTypes::VALUETYPE_JSON:

                        $value = json_decode($value);
                        break;

                    default:

                        break;
                }

                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_INTEGER:

                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN:

                // convert
                $value = ($value == 1) ? true : false;
                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME: // #todo - duplicate code? (unused?)
            case MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD: // #todo - duplicate code? (unused?)
            case MimotoEntityPropertyValueTypes::VALUETYPE_JSON: // #todo - duplicate code? (unused?)

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
    public static function convertRuntimeValueToStorableValue($value, $sType, $sSubtype)
    {
        // convert
        switch($sType)
        {
            case MimotoEntityPropertyValueTypes::VALUETYPE_TEXT:

                switch($sSubtype)
                {
                    case MimotoEntityPropertyValueTypes::VALUETYPE_INTEGER:

                        break;

                    case MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN:

                        // convert
                        $value = ($value === true) ? 1 : 0;
                        break;

                    case MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME:

                        break;

                    case MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD:

                        // encrypt
                        $encryptedValue = Mimoto::service('session')->createPasswordHash($value);

                        // encode
                        $value = json_encode($encryptedValue);
                        break;

                    case MimotoEntityPropertyValueTypes::VALUETYPE_JSON:

                        $value = json_encode($value);
                        break;

                    default:

                        break;
                }

                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_INTEGER:

                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN:

                // convert
                $value = ($value === true) ? 1 : 0;
                break;

            case MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME: // #todo - duplicate code? (unused?)
            case MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD: // #todo - duplicate code? (unused?)
            case MimotoEntityPropertyValueTypes::VALUETYPE_JSON: // #todo - duplicate code? (unused?)

            default:

                break;
        }

        // send
        return $value;
    }

    public static function getConnectionById($nConnectionId)
    {
        // load all connections
        $stmt = Mimoto::service('database')->prepare(
            "SELECT * FROM `".CoreConfig::MIMOTO_CONNECTION."` WHERE ".
            "mimoto_id = :id "
        );
        $params = array(
            ':id' => $nConnectionId
        );
        $stmt->execute($params);

        // load
        $aResults = $stmt->fetchAll();

        // validate
        if (count($aResults) != 1) return null;

        // read
        $connectionData = $aResults[0];

        // create
        $connection = new MimotoEntityConnection();

        // setup
        $connection->setId($connectionData['mimoto_id']);
        $connection->setCreated($connectionData['mimoto_created']);
        $connection->setModified($connectionData['mimoto_modified']);
        $connection->setParentEntityTypeId($connectionData['parent_entity_type_id']);
        $connection->setParentId($connectionData['parent_id']);
        $connection->setParentPropertyId($connectionData['parent_property_id']);
        $connection->setChildEntityTypeId($connectionData['child_entity_type_id']);
        $connection->setChildId($connectionData['child_id']);
        $connection->setSortIndex($connectionData['sortindex']);

        // send
        return $connection;
    }

    public static function decodePostData($sEncodedPostData)
    {
        //Mimoto::error(json_decode(urldecode(base64_decode($sEncodedPostData))));

        return json_decode(rawurldecode($sEncodedPostData));
    }

    public static function getFormattingOptionsForEntityProperty($sEntityName, $sPropertyName)
    {
        // 1. init
        $formattingOptions = null;

        // 2. load
        $aEntities = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_ENTITY, 'values' => ['name' => $sEntityName]]);

        // validate
        if (count($aEntities) == 1)
        {
            // register
            $eEntity = $aEntities[0];

            // read
            $aProperties = $eEntity->get('properties');

            // find
            $nPropertyCount = count($aProperties);
            for ($nPropertyIndex = 0; $nPropertyIndex < $nPropertyCount; $nPropertyIndex++)
            {
                // register
                $eProperty = $aProperties[$nPropertyIndex];

                // verify
                if ($eProperty->get('name') == $sPropertyName)
                {
                    // read
                    $aSettings = $eProperty->get('settings');

                    // find
                    $nSettingCount = count($aSettings);
                    for ($nSettingIndex = 0; $nSettingIndex < $nSettingCount; $nSettingIndex++)
                    {
                        // register
                        $eSetting = $aSettings[$nSettingIndex];

                        // verify
                        if ($eSetting->get('key') == EntityConfig::SETTING_VALUE_FORMATTINGOPTIONS)
                        {
                            // read
                            $aFormattingOptions = $eSetting->get('formattingOptions');

                            // verify
                            if (count($aFormattingOptions) > 0)
                            {
                                $formattingOptions = (object) array(
                                    'toolbar' => [],
                                    'formats' => []
                                );

                                // find
                                $nFormattingOptionCount = count($aFormattingOptions);
                                for ($nFormattingOptionIndex = 0; $nFormattingOptionIndex < $nFormattingOptionCount; $nFormattingOptionIndex++)
                                {
                                    // register
                                    $eFormattingOption = $aFormattingOptions[$nFormattingOptionIndex];

                                    // register
                                    $formattingOptions->formats[] = $eFormattingOption->get('name');


                                    switch($eFormattingOption->get('name'))
                                    {
                                        case 'header':

                                            $formattingOptions->toolbar[] = (object) array('header' => [1, 2, 3, 4, 5, 6, false]);
                                            break;

                                        case 'list':

                                            $formattingOptions->toolbar[] = (object) array('list' => 'ordered');
                                            $formattingOptions->toolbar[] = (object) array('list' => 'bullet');
                                            break;

                                        case 'indent':

                                            $formattingOptions->toolbar[] = (object) array('indent' => '-1');
                                            $formattingOptions->toolbar[] = (object) array('indent' => '+1');
                                            break;

                                        default:

                                            $formattingOptions->toolbar[] = $eFormattingOption->get('name');
                                            break;
                                    }


                                    // ['bold', 'italic', 'underline', 'strike'],
                                    // ['blockquote', 'code-block', 'link'],
                                    // formats: ['bold', 'italic', 'underline', 'strike', 'blockquote', 'code-block', 'link', 'header', 'list', 'indent']
                                }
                            }
                            break;
                        }
                    }
                }
            }
        }

        // send
        return $formattingOptions;
    }

    public static function convertSelector($sSelector)
    {
        // 1. init
        $selector = (object) array();

        // 2. prepare
        $aCoreSelectorElements = ['type', 'id', 'property'];

        // 3. split
        $aSelectorParts = explode('.', $sSelector);

        // 4.
        $nPartCount = count($aSelectorParts);
        for ($nPartIndex = 0; $nPartIndex < $nPartCount; $nPartIndex++)
        {
            $selector->{$aCoreSelectorElements[$nPartIndex]} = $aSelectorParts[$nPartIndex];
        }

        // 5. return
        return $selector;
    }

}

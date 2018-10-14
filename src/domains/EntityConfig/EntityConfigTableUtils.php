<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;


/**
 * EntityConfigTableUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityConfigTableUtils
{


    public static function entityNameIsValid($sEntityName)
    {
        // validate
        return (preg_match("/[a-zA-Z0-9-_]+/", $sEntityName));
    }

    public static function entityNameIsUnique($sEntityName)
    {
        $stmt = Mimoto::service('database')->prepare("SELECT * FROM `".CoreConfig::MIMOTO_ENTITY."` WHERE name = :name");
        $params = array(':name' => $sEntityName);
        if ($stmt->execute($params) === false) Mimoto::error("Error while searching for duplicates of entity name '$sEntityName'");
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($aResults) == 0) ? true : false;
    }

    public static function tableNameIsUnique($sEntityName)
    {
        $stmt = Mimoto::service('database')->prepare("SHOW TABLES LIKE '".$sEntityName."'");
        $params = array();
        if ($stmt->execute($params) === false) Mimoto::error("Error while checking for duplicate entity table '$sEntityName'");
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($aResults) == 0) ? true : false;
    }

    public static function createEntityTable($sEntityName)
    {
        $stmt = Mimoto::service('database')->prepare(
            "CREATE TABLE `".$sEntityName."` (".
            "   `mimoto_id` int(10) unsigned NOT NULL AUTO_INCREMENT, ".
            "   `mimoto_created` datetime DEFAULT NULL, ".
            "   `mimoto_modified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, ".
            "   PRIMARY KEY (`mimoto_id`) ".
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
        $params = array();
        return $stmt->execute($params);
    }

    public static function renameEntityTable($sCurrentEntityName, $sNewEntityName)
    {
        $stmt = Mimoto::service('database')->prepare(
            "RENAME TABLE `".$sCurrentEntityName."` TO `$sNewEntityName`"
        );
        $params = array();
        return $stmt->execute($params);
    }

    public static function deleteEntityTable($sEntityName)
    {
        $stmt = Mimoto::service('database')->prepare("DROP TABLE IF EXISTS `" . $sEntityName . "`");
        $params = array();
        return $stmt->execute($params);
    }

    public static function entityPropertyNameIsUnique($nEntityId, $sEntityPropertyName)
    {
        $stmt = Mimoto::service('database')->prepare(
            "SELECT * FROM `".CoreConfig::MIMOTO_ENTITYPROPERTY."` LEFT JOIN `".CoreConfig::MIMOTO_CONNECTION."` ".
            "ON `".CoreConfig::MIMOTO_CONNECTION.".mimoto_id = ".CoreConfig::MIMOTO_CONNECTION.".child_id ".
            "WHERE ".CoreConfig::MIMOTO_CONNECTION.".parent_id = :parent_id ".
            "&& ".CoreConfig::MIMOTO_CONNECTION.".parent_property_id = :parent_property_id ".
            "&& ".CoreConfig::MIMOTO_ENTITYPROPERTY.".name = :name");
        $params = array(
            "parent_id" => $nEntityId,
            "parent_property_id" => CoreConfig::MIMOTO_ENTITY.'--properties',
            "name" => $sEntityPropertyName
        );
        if ($stmt->execute($params) === false) Mimoto::error("Error while checking for duplicate EntityProperty '$sEntityPropertyName'");
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($aResults) == 0) ? true : false;
    }


    public static function addPropertyColumnToEntityTable($sEntityName, $sPropertyName, $sColumnType, $sColumnOnTheLeft)
    {
        // 1. convert
        $sDataType = self::getColumnDataType($sColumnType);

        // a. add column to table
        //$stmt = Mimoto::service('database')->prepare("ALTER TABLE `".$sEntityName."` ADD COLUMN `".$sPropertyName."` ".$sDataType." AFTER `".$sColumnOnTheLeft."`");
        $stmt = Mimoto::service('database')->prepare("ALTER TABLE `".$sEntityName."` ADD COLUMN `".$sPropertyName."` ".$sDataType);
        $params = array();
        if ($stmt->execute($params) === false) Mimoto::error("Error while adding column '$sPropertyName' to entity table '$sEntityName'");
    }

    public static function renamePropertyColumn($sEntityName, $sOldPropertyName, $sNewPropertyName, $sColumnType)
    {
        // 1. convert
        $sDataType = self::getColumnDataType($sColumnType);

        // 2. add column to table
        $stmt = Mimoto::service('database')->prepare("ALTER TABLE `".$sEntityName."` CHANGE COLUMN `".$sOldPropertyName."` `".$sNewPropertyName."` ".$sDataType);
        $params = array();
        if ($stmt->execute($params) === false) Mimoto::error("Error while renaming column `$sOldPropertyName` to `$sNewPropertyName` in entity table `$sEntityName``");
    }

    public static function alterPropertyColumnType($sEntityName, $sPropertyName, $sColumnType)
    {
        // 1. convert
        $sDataType = self::getColumnDataType($sColumnType);

        // 2. add column to table
        $stmt = Mimoto::service('database')->prepare("ALTER TABLE `".$sEntityName."` MODIFY `".$sPropertyName."` ".$sDataType);
        $params = array();
        if ($stmt->execute($params) === false) Mimoto::error("Error while changing the type of column '$sPropertyName' of entity table '$sEntityName' to '$sDataType'");
    }

    public static function removePropertyColumnFromEntityTable($sEntityName, $sPropertyName)
    {
        // 2. add column to table
        $stmt = Mimoto::service('database')->prepare("ALTER TABLE `".$sEntityName."` DROP COLUMN `".$sPropertyName."`");
        $params = array();
        $stmt->execute($params);
        //if ($stmt->execute($params) === false) Mimoto::error("Error while removing column '$sPropertyName' from entity table '$sEntityName'");
    }

    public static function flushEntityConfigCache()
    {
        // TODO Flush memcache
    }

    private static function getColumnDataType($sColumnType)
    {
        // 1. determine column specs
        $sDataType = null;
        switch($sColumnType)
        {
            case CoreConfig::DATA_VALUE_TEXTLINE: $sDataType = "VARCHAR(255)"; break;
            case CoreConfig::DATA_VALUE_TEXTBLOCK: $sDataType = "TEXT"; break;
            case MimotoEntityPropertyValueTypes::VALUETYPE_BOOLEAN: $sDataType = "ENUM('0','1')"; break;
            case MimotoEntityPropertyValueTypes::VALUETYPE_DATETIME: $sDataType = "DATETIME"; break;
            case MimotoEntityPropertyValueTypes::VALUETYPE_PASSWORD: $sDataType = "VARCHAR(255)"; break;
            case MimotoEntityPropertyValueTypes::VALUETYPE_JSON: $sDataType = "TEXT"; break;
        }

        // 2. verify specs
        if (empty($sDataType))
        {
            Mimoto::service('log')->error("Unknow mysql table property specs", "An entity table got the request to add an unknown property-column type");
            die();
        }

        // send
        return $sDataType;
    }

}

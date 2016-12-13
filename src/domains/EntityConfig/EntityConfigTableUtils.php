<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
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
        $stmt = $GLOBALS['database']->prepare("SELECT * FROM ".CoreConfig::MIMOTO_ENTITY." WHERE name = :name");
        $params = array(':name' => $sEntityName);
        if ($stmt->execute($params) === false) error("Error while searching for duplicates of entity name '$sEntityName'");
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($aResults) == 0) ? true : false;
    }

    public static function tableNameIsUnique($sEntityName)
    {
        $stmt = $GLOBALS['database']->prepare("SHOW TABLES LIKE '".$sEntityName."'");
        $params = array();
        if ($stmt->execute($params) === false) error("Error while checking for duplicate entity table '$sEntityName'");
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($aResults) == 0) ? true : false;
    }

    public static function createEntityTable($sEntityName)
    {
        $stmt = $GLOBALS['database']->prepare(
            "CREATE TABLE `".$sEntityName."` (".
            "   `id` int(10) unsigned NOT NULL AUTO_INCREMENT, ".
            "   `created` datetime DEFAULT NULL, ".
            "   PRIMARY KEY (`id`) ".
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
        $params = array();
        return $stmt->execute($params);
    }

    public static function renameEntityTable($sCurrentEntityName, $sNewEntityName)
    {
        $stmt = $GLOBALS['database']->prepare(
            "RENAME TABLE `".$sCurrentEntityName."` TO `$sNewEntityName`"
        );
        $params = array();
        return $stmt->execute($params);
    }

    public static function deleteEntityTable($sEntityName)
    {
        $stmt = $GLOBALS['database']->prepare("DROP TABLE IF EXISTS `" . $sEntityName . "`");
        $params = array();
        return $stmt->execute($params);
    }

    public static function entityPropertyNameIsUnique($nEntityId, $sEntityPropertyName)
    {
        $stmt = $GLOBALS['database']->prepare(
            "SELECT * FROM ".CoreConfig::MIMOTO_ENTITYPROPERTY." LEFT JOIN ".CoreConfig::MIMOTO_CONNECTIONS_CORE." ".
            "ON ".CoreConfig::MIMOTO_CONNECTIONS_CORE.".id = ".CoreConfig::MIMOTO_CONNECTIONS_CORE.".child_id ".
            "WHERE ".CoreConfig::MIMOTO_CONNECTIONS_CORE.".parent_id = :parent_id ".
            "&& ".CoreConfig::MIMOTO_CONNECTIONS_CORE.".parent_property_id = :parent_property_id ".
            "&& ".CoreConfig::MIMOTO_ENTITYPROPERTY.".name = :name");
        $params = array(
            "parent_id" => $nEntityId,
            "parent_property_id" => CoreConfig::MIMOTO_ENTITY.'--properties',
            "name" => $sEntityPropertyName
        );
        if ($stmt->execute($params) === false) error("Error while checking for duplicate EntityProperty '$sEntityPropertyName'");
        $aResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return (count($aResults) == 0) ? true : false;
    }

}

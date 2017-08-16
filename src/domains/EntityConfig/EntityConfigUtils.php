<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;


/**
 * EntityConfigUtils
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityConfigUtils
{


    /**
     * Load raw connection data
     * @param string Parent entity type id
     * @return array Entity connections (grouped by parentId)
     */
    public static function loadRawEntityData($sEntityTypeName)
    {
        // init
        $aRawInstances = [];

        // load all templates
        $stmt = Mimoto::service('database')->prepare('SELECT * FROM `'.$sEntityTypeName.'`');
        $params = array();
        $stmt->execute($params);

        // copy
        foreach ($stmt as $row)
        {
            $rawInstance = [];

            foreach ($row as $sKey => $value)
            {
                if (is_string($sKey)) $rawInstance[$sKey] = $value;
            }

            // store
            $aRawInstances[] = $rawInstance;
        }

        // send
        return $aRawInstances;
    }


    /**
     * Load raw connection data
     * @param string Parent entity type id
     * @return array Entity connections (grouped by parentId)
     */
    public static function loadRawConnectionData($sParentEntityTypeId)
    {
        // init
        $aConnections = [];

        // load all connections
        $stmt = Mimoto::service('database')->prepare(
            "SELECT * FROM `".CoreConfig::MIMOTO_CONNECTION."` WHERE ".
            "parent_entity_type_id = :parent_entity_type_id ".
            "ORDER BY parent_id ASC, sortindex ASC"
        );
        $params = array(
            ':parent_entity_type_id' => $sParentEntityTypeId
        );
        $stmt->execute($params);

        foreach ($stmt as $row)
        {
            // compose
            $connection = (object) array(
                'id' => $row['id'],                                         // the id of the connection
                'parent_entity_type_id' => $row['parent_entity_type_id'],   // the id of the parent's entity config
                'parent_id' => $row['parent_id'],                           // the id of the parent entity
                'parent_property_id' => $row['parent_property_id'],         // the id of the parent entity's property
                'child_entity_type_id' => $row['child_entity_type_id'],     // the id of the child's entity config
                'child_id' => $row['child_id'],                             // the id of the child entity connected to the parent
                'sortindex' => $row['sortindex']                            // the sortindex
            );

            // load
            $nParentId = $row['parent_id'];

            // store
            $aConnections[$nParentId][] = $connection;
        }

        // send
        return $aConnections;
    }

}

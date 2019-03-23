<?php

if (isset($_GET['type']) && $_GET['type'] == 'migrate2mimoto_id')
{
    echo '<pre>';

    $config = json_decode(file_get_contents(dirname(dirname(__FILE__)).'/mimoto.json'));
    $database = new \PDO("mysql:host=".$config->mysql->host.";dbname=".$config->mysql->dbname, $config->mysql->username, $config->mysql->password);


    $stmt = $database->prepare("show tables");
    //$stmt = $database->prepare("ALTER TABLE `".$sEntityName."` CHANGE COLUMN `".$sOldPropertyName."` `".$sNewPropertyName."` ".$sDataType);
    $params = array();
    if ($stmt->execute($params) === false) die('error');

    $aTables = $stmt->fetchAll(\PDO::FETCH_ASSOC);



    $nTableCount = count($aTables);
    for ($nTableIndex = 0; $nTableIndex < $nTableCount; $nTableIndex++)
    {
        // register
        $table = $aTables[$nTableIndex];

        $sTableName = $table['Tables_in_knvb.elearning'];

//        if($exists)
        {
            // do your stuff
            echo "<b>$sTableName</b><br>";

            $stmt = $database->prepare("show columns from `$sTableName`" );
            $params = array();
            if ($stmt->execute($params) === false) die('error');

            $aColumns = $stmt->fetchAll(\PDO::FETCH_ASSOC);


            // --- mimoto_id

            foreach($aColumns as $column)
            {
                if ($column['Field'] == 'id')
                {
                    echo '<i>Table still has `id` field. Renaming it to `mimoto_id`</i><br>';
                    $stmt = $database->prepare("ALTER TABLE `".$sTableName."` CHANGE COLUMN `".$column['Field'].'` `mimoto_id` '.$column['Type'].' '.(($column['Null'] == 'YES') ? 'DEFAULT NULL' : 'NOT NULL')." ".$column['Extra']." FIRST");
                    $params = array();
                    if ($stmt->execute($params) === false) die('error');
                    break;
                }
            }


            // --- mimoto_created

            $bColumnCreatedFound = false;
            foreach($aColumns as $column)
            {
                if ($column['Field'] == 'created')
                {
                    echo '<i>Table still has `created` field. Renaming it to `mimoto_created`</i><br>';
                    echo "ALTER TABLE `".$sTableName."` CHANGE COLUMN `".$column['Field'].'` `mimoto_created` '.$column['Type'].' '.(($column['Null'] == 'YES') ? 'DEFAULT NULL' : 'NOT NULL')." ".$column['Extra']." after `mimoto_id`";
                    $stmt = $database->prepare("ALTER TABLE `".$sTableName."` CHANGE COLUMN `".$column['Field'].'` `mimoto_created` '.$column['Type'].' '.(($column['Null'] == 'YES') ? 'DEFAULT NULL' : 'NOT NULL')." ".$column['Extra']." after `mimoto_id`");
                    $params = array();
                    if ($stmt->execute($params) === false) die('error');
                    $bColumnCreatedFound = true;
                }
                if ($column['Field'] == 'mimoto_created')
                {
                    $bColumnCreatedFound = true;
                }
            }
            if (!$bColumnCreatedFound)
            {
                echo "<i>Table `$sTableName` is missing column `mimoto_created`</i><br>";
                echo "ALTER TABLE `".$sTableName."` ADD COLUMN `mimoto_created` datetime DEFAULT NULL after `mimoto_id`";
                $stmt = $database->prepare("ALTER TABLE `".$sTableName."` ADD COLUMN `mimoto_created` datetime DEFAULT NULL after `mimoto_id`");
                $params = array();
                if ($stmt->execute($params) === false) die('error');
            }


            // --- mimoto_modified

            $bColumnModifiedFound = false;
            foreach($aColumns as $column)
            {
                if ($column['Field'] == 'mimoto_modified')
                {
                    $bColumnModifiedFound = true;
                    break;
                }
            }
            if (!$bColumnModifiedFound)
            {
                echo "<i>Table `$sTableName` is missing column `mimoto_modified`</i><br>";
                echo "ALTER TABLE `".$sTableName."` ADD COLUMN `mimoto_modified` datetime DEFAULT NULL on update CURRENT_TIMESTAMP after `mimoto_created`";
                $stmt = $database->prepare("ALTER TABLE `".$sTableName."` ADD COLUMN `mimoto_modified` datetime DEFAULT NULL on update CURRENT_TIMESTAMP after `mimoto_created`");
                $params = array();
                if ($stmt->execute($params) === false) die('error');
            }




            // alter table
            //yourtablename
            //change col3 col3 varchar(15)
            //after col1



//            $exists = false;
//            $columns = mysql_query("show columns from $db");
//            while($c = mysql_fetch_assoc($columns)){
//                if($c['Field'] == $column){
//                    $exists = true;
//                    break;
//                }
//            }
//            if(!$exists){
//                mysql_query("ALTER TABLE `$db` ADD `$column`  $column_attr");
//            }


            // ALTER TABLE `user` CHANGE `id` `id` INT( 11 ) COMMENT 'id of user'

        }

        echo '<br>';
    }


    $stmt = $database->prepare("SHOW INDEX FROM `_Mimoto_connection`" );
    $params = array();
    if ($stmt->execute($params) === false) die('error');

    $aCurrentIndexes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    //print_r($aCurrentIndexes);

    $aRequiredIndexes = [
        (object) array('name' => 'parent_entity_type_id', 'query' => 'ALTER TABLE `_Mimoto_connection` ADD INDEX `parent_entity_type_id`(`parent_entity_type_id`) USING BTREE;'),
        (object) array('name' => 'parent_property_id', 'query' => 'ALTER TABLE `_Mimoto_connection` ADD INDEX `parent_property_id`(`parent_property_id`) USING BTREE;'),
        (object) array('name' => 'child_entity_type_id', 'query' => 'ALTER TABLE `_Mimoto_connection` ADD INDEX `child_entity_type_id`(`child_entity_type_id`) USING BTREE;'),
        (object) array('name' => 'parent', 'query' => 'ALTER TABLE `_Mimoto_connection` ADD INDEX `parent`(`parent_id`, `parent_property_id`, `parent_entity_type_id`) USING BTREE;'),
        (object) array('name' => 'child', 'query' => 'ALTER TABLE `_Mimoto_connection` ADD INDEX `child`(`child_entity_type_id`, `child_id`, `parent_id`, `sortindex`) USING BTREE;')
    ];

    // validate or add
    $nRequiredIndexCount = count($aRequiredIndexes);
    for ($nRequiredIndexIndex = 0; $nRequiredIndexIndex < $nRequiredIndexCount; $nRequiredIndexIndex++)
    {
        // register
        $requiredIndex = $aRequiredIndexes[$nRequiredIndexIndex];

        // find
        $bIndexFound = false;
        $nCurrentIndexCount = count($aCurrentIndexes);
        for ($nCurrentIndexIndex = 0; $nCurrentIndexIndex < $nCurrentIndexCount; $nCurrentIndexIndex++)
        {
            // register
            $currentIndex = $aCurrentIndexes[$nCurrentIndexIndex];

            // verify
            if ($currentIndex['Key_name'] == $requiredIndex->name)
            {
                $bIndexFound = true;
                break;
            }
        }

        if (!$bIndexFound)
        {
            echo "<i>Table `_Mimoto_connection` is missing index `$requiredIndex->name`</i><br>";
            echo $requiredIndex->query.'<br>';
            $stmt = $database->prepare($requiredIndex->query);
            $params = array();
            if ($stmt->execute($params) === false) die('Error adding index `'.$requiredIndex->name.'`');
        }
    }

    // DROP INDEX table_name.index_name



    echo '</pre>';
    die('End of migration script');
}

die();

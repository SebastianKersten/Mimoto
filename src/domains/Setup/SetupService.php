<?php

// classpath
namespace Mimoto\Setup;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Symfony classes
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * SetupService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SetupService
{

    private $_aCoreTables = [
        CoreConfig::MIMOTO_ACTION,
        CoreConfig::MIMOTO_ACTION_SETTING,
        CoreConfig::MIMOTO_ACTION_CONDITIONAL,
        CoreConfig::MIMOTO_COMPONENT,
        CoreConfig::MIMOTO_COMPONENT_CONDITIONAL,
        CoreConfig::MIMOTO_COMPONENT_CONTAINER,
        CoreConfig::MIMOTO_COMPONENT_TEMPLATE,
        CoreConfig::MIMOTO_CONNECTION,
        CoreConfig::MIMOTO_DATASET,
        CoreConfig::MIMOTO_ENTITY,
        CoreConfig::MIMOTO_ENTITYPROPERTY,
        CoreConfig::MIMOTO_ENTITYPROPERTYSETTING,
        CoreConfig::MIMOTO_FILE,
        CoreConfig::MIMOTO_FORM,

        CoreConfig::MIMOTO_SERVICE,
        CoreConfig::MIMOTO_SERVICE_FUNCTION,

        //CoreConfig::MIMOTO_FORM_FIELD,
        CoreConfig::MIMOTO_FORM_FIELD_RULES,
        CoreConfig::MIMOTO_FORM_FIELD_VALIDATION,
        CoreConfig::MIMOTO_FORM_FIELD_OPTION,
        //CoreConfig::MIMOTO_FORM_FIELD_OPTION_MAP,

        CoreConfig::MIMOTO_FORM_INPUT_DATEPICKER,
        CoreConfig::MIMOTO_FORM_INPUT_PASSWORD,
        CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX,
        CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER,
        CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN,
        CoreConfig::MIMOTO_FORM_INPUT_IMAGE,
        CoreConfig::MIMOTO_FORM_INPUT_LIST,
        CoreConfig::MIMOTO_FORM_INPUT_ENTITY,
        CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT,
        CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON,
        CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK,
        CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE,
        CoreConfig::MIMOTO_FORM_INPUT_VIDEO,
        CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER,
        CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART,
        CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND,
        CoreConfig::MIMOTO_FORM_OUTPUT_TITLE,

        CoreConfig::MIMOTO_FORMATTINGOPTION,
        CoreConfig::MIMOTO_FORMATTINGOPTION_ATTRIBUTE,
        CoreConfig::MIMOTO_NOTIFICATION,
        CoreConfig::MIMOTO_OUTPUT,
        CoreConfig::MIMOTO_OUTPUT_CONTAINER,
        CoreConfig::MIMOTO_API,
        CoreConfig::MIMOTO_PAGE,
        CoreConfig::MIMOTO_PATH_ELEMENT,
        CoreConfig::MIMOTO_SELECTION,
        CoreConfig::MIMOTO_SELECTION_RULE,
        CoreConfig::MIMOTO_SELECTION_RULE_VALUE,
        CoreConfig::MIMOTO_USER,
        CoreConfig::MIMOTO_USER_ROLE
    ];


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct()
    {
        // store

    }




    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function getCoreTables()
    {
        return $this->_aCoreTables;
    }


    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------



    public function checkTables()
    {
        // init
        $result = (object) array(
            'valid' => true
        );


        // load
        $stmt = Mimoto::service('database')->prepare('show tables');
        $params = array();
        $stmt->execute($params);

        // load
        $aTableResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        // init
        $aProjectTables = [];

        // collect table names
        $nTableCount = count($aTableResults);
        for ($nTableIndex = 0; $nTableIndex < $nTableCount; $nTableIndex++)
        {
            // register
            $sTableName = $aTableResults[$nTableIndex]['Tables_in_'.Mimoto::service('config')->get('mysql.dbname')];

            // add
            if (substr($sTableName, 0, strlen(CoreConfig::CORE_PREFIX)) == CoreConfig::CORE_PREFIX) $aProjectTables[] = $sTableName;
        }

        // find missing tables
        $result->missingTables = [];
        $nCoreTableCount = count($this->_aCoreTables);
        for ($nCoreTableIndex = 0; $nCoreTableIndex < $nCoreTableCount; $nCoreTableIndex++)
        {
            // register
            $sCoreTable = $this->_aCoreTables[$nCoreTableIndex];

            // verify or add
            if (!in_array($sCoreTable, $aProjectTables))
            {
                $result->missingTables[] = $sCoreTable;
                $result->valid = false;
            }
        }

        // find redundant tables
        $aTableNames = [];
        $result->redundantTables = [];

        $nProjectTableCount = count($aProjectTables);
        for ($nProjectTableIndex = 0; $nProjectTableIndex < $nProjectTableCount; $nProjectTableIndex++)
        {
            // register
            $sProjectTable = $aProjectTables[$nProjectTableIndex];

            // verify or add
            if (!in_array($sProjectTable, $this->_aCoreTables))
            {
                $result->redundantTables[] = $sProjectTable;
                $result->valid = false;
            }
            else
            {
                $aTableNames[] = $sProjectTable;
            }
        }

        // init
        $result->unsyncedTables = [];

        // validate table stucture
        $nTableCount = count($aTableNames);
        for ($nTableIndex = 0; $nTableIndex < $nTableCount; $nTableIndex++)
        {
            // register
            $sTableName = $aTableNames[$nTableIndex];

            // validate
            $table = $this->checkTableStructure($sTableName);

            // replace
            if ($table->status != 'Ok!')
            {
                $result->unsyncedTables[] = $table;
                $result->valid = false;
            }
        }

        // 3. send
        return $result;
    }

    public function addCoreTable($sTableName)
    {
        // 1. load
        $sTableStructure = $this->getTableStructure($sTableName);

        // 2. validate
        if (empty($sTableStructure)) return '';

        // 3. convert
        $table = json_decode($sTableStructure);

        // 4. compose
        $sQuery =  'CREATE TABLE `'.$sTableName.'` (';
        $sQuery .= '`id` int(10) unsigned NOT NULL AUTO_INCREMENT,';

        // 5. add columns
        $nColumnCount = count($table);
        for ($nColumnIndex = 0; $nColumnIndex < $nColumnCount; $nColumnIndex++)
        {
            // register
            $column = $table[$nColumnIndex];

            // skip
            if ($column->Field == 'id' || $column->Field == 'created') continue;

            // build
            $sQuery .= '`'.$column->Field.'` '.$column->Type.' '.(($column->Null == 'YES') ? 'DEFAULT NULL' : 'NOT NULL').',';
        }

        // 6. compose
        $sQuery .= '`created` datetime DEFAULT NULL,';
        $sQuery .= 'PRIMARY KEY (`id`) USING BTREE';
        $sQuery .= ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';

        // 7. create
        $stmt = Mimoto::service('database')->prepare($sQuery);
        $params = array();
        $stmt->execute($params);

        // 8. send
        return true;
    }

    public function fixCoreTable($sTableName)
    {
        // 1. load
        $table = $this->checkTableStructure($sTableName);

        // 2. validate
        if ($table->status == 'Ok!') return false;



        // --- add missing columns


        $nIssueCount = count($table->issues);
        for ($nIssueIndex = 0; $nIssueIndex < $nIssueCount; $nIssueIndex++)
        {
            // register
            $issue = $table->issues[$nIssueIndex];

            // verify
            if ($issue->whatsWrong != 'Missing column') continue;

            // a. add column to table
            $stmt = Mimoto::service('database')->prepare("ALTER TABLE `".$sTableName."` ADD COLUMN .$issue->shouldBe");
            $params = array();
            if ($stmt->execute($params) === false) return "Error while adding column `".$issue->shouldBe."` to entity table '$sTableName'";
        }



        // --- remove redundant columns


        $nIssueCount = count($table->issues);
        for ($nIssueIndex = 0; $nIssueIndex < $nIssueCount; $nIssueIndex++)
        {
            // register
            $issue = $table->issues[$nIssueIndex];

            // verify
            if ($issue->whatsWrong != 'Redundant column') continue;

            // a. add column to table
            $stmt = Mimoto::service('database')->prepare("ALTER TABLE `".$sTableName."` DROP COLUMN `".$issue->field."`");
            $params = array();
            if ($stmt->execute($params) === false) return "Error while removing column `".$issue->field."` from entity table '$sTableName'";
        }



        // --- change column format


        $nIssueCount = count($table->issues);
        for ($nIssueIndex = 0; $nIssueIndex < $nIssueCount; $nIssueIndex++)
        {
            // register
            $issue = $table->issues[$nIssueIndex];

            // verify
            if ($issue->whatsWrong != 'Wrong format') continue;

            // a. add column to table
            $stmt = Mimoto::service('database')->prepare("ALTER TABLE `".$sTableName."` MODIFY ".$issue->shouldBe);
            $params = array();
            if ($stmt->execute($params) === false) return "Error while changing column `".$issue->field."` format on entity table '$sTableName'";
        }



        // --- change order


        // 1. reload
        $table = $this->checkTableStructure($sTableName);

        // 2. validate
        if ($table->status == 'Ok!') return true;


        $nIssueCount = count($table->issues);
        for ($nIssueIndex = 0; $nIssueIndex < $nIssueCount; $nIssueIndex++)
        {
            // register
            $issue = $table->issues[$nIssueIndex];

            // verify
            if ($issue->whatsWrong != 'Wrong order') continue;


            // 1. load
            $sTableStructure = $this->getTableStructure($sTableName);

            // 2. validate
            if (empty($sTableStructure)) return false;

            // 3. convert
            $aTableStructure = json_decode($sTableStructure);

            // 4. reorder
            $nColumnCount = count($aTableStructure);
            for ($nColumnIndex = $nColumnCount - 1; $nColumnIndex >= 0; $nColumnIndex--)
            {
                // register
                $column = $aTableStructure[$nColumnIndex];

                // move columns
                $stmt = Mimoto::service('database')->prepare("ALTER TABLE `".$sTableName."` MODIFY COLUMN `".$column->Field.'` '.$column->Type.' '.(($column->Null == 'YES') ? 'DEFAULT NULL' : 'NOT NULL')." ".$column->Extra." FIRST");
                $params = array();
                if ($stmt->execute($params) === false) return "Error while moving column `".$column->Field."` to correct order on entity table '$sTableName'";
            }
        }

        // 8. send
        return true;
    }

    public function removeCoreTable($sTableName)
    {
        // 1. remove
        $stmt = Mimoto::service('database')->prepare("DROP TABLE IF EXISTS `" . $sTableName . "`");
        $params = array();
        $stmt->execute($params);

        // 2. send
        return true;
    }



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    private function checkTableStructure($sTableName)
    {
        // init
        $table = (object) array(
            'name' => $sTableName
        );

        // load
        $stmt = Mimoto::service('database')->prepare('describe '.$sTableName);
        $params = array();
        $stmt->execute($params);

        // load
        $aStructureResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        //Mimoto::output($sTableName, json_encode($aStructureResults));

        $jsonTableStructure = $this->getTableStructure($sTableName);


        if (json_encode($aStructureResults) == $jsonTableStructure)
        {
            $table->status = 'Ok!';
        }
        else
        {
            $table->status = 'Issue';
            $table->issues = [];


            $aDefinitionColumns = json_decode($jsonTableStructure);
            $aDefinitionColumnNames = [];

            // 5. add columns
            $nDefinitionColumnCount = count($aDefinitionColumns);
            for ($nDefinitionColumnIndex = 0; $nDefinitionColumnIndex < $nDefinitionColumnCount; $nDefinitionColumnIndex++)
            {
                // register
                $definitonColumn = $aDefinitionColumns[$nDefinitionColumnIndex];

                // store
                $aDefinitionColumnNames[] = $definitonColumn->Field;

                // init
                $bColumnFound = false;

                // find
                $nColumnCount = count($aStructureResults);
                for ($nColumnIndex = 0; $nColumnIndex < $nColumnCount; $nColumnIndex++)
                {
                    // register
                    $column = $aStructureResults[$nColumnIndex];

                    // skip
                    if ($column['Field'] == $definitonColumn->Field)
                    {
                        if (
                            $column['Type'] != $definitonColumn->Type ||
                            $column['Null'] != $definitonColumn->Null ||
                            $column['Key'] != $definitonColumn->Key ||
                            $column['Default'] != $definitonColumn->Default ||
                            $column['Extra'] != $definitonColumn->Extra
                        )
                        {
                            $table->issues[] = (object) array(
                                'field' => $definitonColumn->Field,
                                'whatsWrong' => 'Wrong format',
                                'current' => $column['Field'].' '.$column['Type'].' '.(($column['Null'] == 'YES') ? 'DEFAULT NULL' : 'NOT NULL'),
                                'shouldBe' => $definitonColumn->Field.' '.$definitonColumn->Type.' '.(($definitonColumn->Null == 'YES') ? 'DEFAULT NULL' : 'NOT NULL').(!empty($definitonColumn->Extra) ? ' '.$definitonColumn->Extra : '')
                            );
                        }

                        $bColumnFound = true;
                        break;
                    }

                }

                if (!$bColumnFound)
                {
                    // register
                    $table->issues[] = (object) array(
                        'field' => $definitonColumn->Field,
                        'whatsWrong' => 'Missing column',
                        'shouldBe' => $definitonColumn->Field.' '.$definitonColumn->Type.' '.(($definitonColumn->Null == 'YES') ? 'DEFAULT NULL' : 'NOT NULL').(!empty($definitonColumn->Extra) ? ' '.$definitonColumn->Extra : '')
                    );
                }
            }


            // --- redundant columns


            // init
            $aStructureColumnNames = [];


            // find
            $nColumnCount = count($aStructureResults);
            for ($nColumnIndex = 0; $nColumnIndex < $nColumnCount; $nColumnIndex++)
            {
                // register
                $column = $aStructureResults[$nColumnIndex];

                // store
                $aStructureColumnNames[] = $column['Field'];

                // verify
                if (!in_array($column['Field'], $aDefinitionColumnNames))
                {
                    $table->issues[] = (object) array(
                        'field' => $column['Field'],
                        'whatsWrong' => 'Redundant column'
                    );
                }
            }


            // --- order


            if (count($table->issues) == 0)
            {
                if (json_encode($aStructureColumnNames) != json_encode($aDefinitionColumnNames))
                {
                    $table->issues[] = (object) array(
                        'whatsWrong' => 'Wrong order',
                        'current' => json_encode($aStructureColumnNames),
                        'shouldBe' => json_encode($aDefinitionColumnNames)
                    );
                }
            }
        }

        // send
        return $table;
    }
    
    private function getTableStructure($sTableName)
    {
        // init
        $sTableStructure = '';
        
        switch($sTableName)
        {
            case CoreConfig::MIMOTO_ACTION: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"title","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"event","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"async","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_ACTION_CONDITIONAL: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value1","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value2","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_ACTION_SETTING: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"key","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_API: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_COMPONENT: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_COMPONENT_CONDITIONAL: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_COMPONENT_CONTAINER: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_COMPONENT_TEMPLATE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"file","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_CONNECTION: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"parent_entity_type_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"parent_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"parent_property_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"child_entity_type_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"child_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"sortindex","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_DATASET: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"}]'; break;

            case CoreConfig::MIMOTO_ENTITY: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"isUserExtension","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"isAbstract","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_ENTITYPROPERTY: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"subtype","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_ENTITYPROPERTYSETTING: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"key","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_APP: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"vendor","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"version","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"isEnabled","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FILE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"path","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mime","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"size","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"width","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"height","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"aspectRatio","Type":"float(10,5)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"originalName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"manualSave","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"realtimeCollaborationMode","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"customSubmit","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"action","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"method","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"target","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_FIELD: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"placeholder","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"prefix","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"title","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"subtitle","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"introduction","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_FIELD_OPTION: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mappingLabel","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mappingValue","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
//            case CoreConfig::MIMOTO_FORM_FIELD_OPTION_MAP: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"targetKey","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"originKey","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_FIELD_VALIDATION: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"errorMessage","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"trigger","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_FIELD_RULES: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"key","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;

            case CoreConfig::MIMOTO_SERVICE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"file","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"owner","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_SERVICE_FUNCTION: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;

            case CoreConfig::MIMOTO_FORM_INPUT_DATEPICKER: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"enableTime","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_PASSWORD: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"placeholder","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"option","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_COLORPICKER: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_IMAGE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_LIST: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_ENTITY: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"option","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"placeholder","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"optional","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"regexp","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"maxchars","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"placeholder","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"prefix","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUT_VIDEO: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"}]'; break;
            case CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"title","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"}]'; break;
            case CoreConfig::MIMOTO_FORM_OUTPUT_TITLE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"title","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"subtitle","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;


            case CoreConfig::MIMOTO_FORMATTINGOPTION: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"tagName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"toolbar","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"jsOnAdd","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"jsOnEdit","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORMATTINGOPTION_ATTRIBUTE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"path","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mime","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"size","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"width","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"height","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"aspectRatio","Type":"float(10,5)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"originalName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_NOTIFICATION: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"title","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"message","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"category","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"dispatcher","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"state","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_OUTPUT: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"isRoot","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_OUTPUT_CONTAINER: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_PAGE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_PATH_ELEMENT: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"staticValue","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"varName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_SELECTION: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_SELECTION_RULE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"typeAsVar","Type":"int(1)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"typeVarName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"idAsVar","Type":"int(1)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"idVarName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"propertyAsVar","Type":"int(1)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"propertyVarName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_SELECTION_RULE_VALUE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"propertyName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_USER: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"firstName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"lastName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"email","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"password","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_USER_ROLE: $sTableStructure = '[{"Field":"mimoto_id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"mimoto_created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mimoto_modified","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":"on update CURRENT_TIMESTAMP"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
        }
        
        // send
        return $sTableStructure;
    }

}

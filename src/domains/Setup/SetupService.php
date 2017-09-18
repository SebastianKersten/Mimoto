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
        '_Mimoto_action',
        '_Mimoto_component',
        '_Mimoto_componentconditional',
        '_Mimoto_componenttemplate',
        '_Mimoto_connection',
        '_Mimoto_dataset',
        '_Mimoto_entity',
        '_Mimoto_entityproperty',
        '_Mimoto_entitypropertysetting',
        '_Mimoto_file',
        '_Mimoto_form',
        '_Mimoto_form_field',
        '_Mimoto_form_field_rules',
        '_Mimoto_form_inputoption',
        //'_Mimoto_form_inputoption_map',
        '_Mimoto_form_field_validation',
        '_Mimoto_formattingoption',
        '_Mimoto_formattingoptionattribute',
        '_Mimoto_layout',
        '_Mimoto_layoutcontainer',
        '_Mimoto_notification',
        '_Mimoto_output',
        '_Mimoto_output_container',
        '_Mimoto_route',
        '_Mimoto_route_path_element',
        '_Mimoto_selection',
        '_Mimoto_selectionrule',
        '_Mimoto_user',
        '_Mimoto_user_role'
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
            $sTableName = $aTableResults[$nTableIndex]['Tables_in_'.Mimoto::value('config')->mysql->dbname];

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
        $result->tables = [];
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
                $result->tables[] = $sProjectTable;
            }
        }

        // validate table stucture
        $nTableCount = count($result->tables);
        for ($nTableIndex = 0; $nTableIndex < $nTableCount; $nTableIndex++)
        {
            // register
            $sTableName = $result->tables[$nTableIndex];

            // replace
            $result->tables[$nTableIndex] = $this->checkTableStructure($sTableName);

            // toggle
            if (($result->tables[$nTableIndex]->status != 'Ok!')) $result->valid = false;
        }

        // 3. send
        return $result;
    }

    public function createCoreTable($sTableName)
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


        $jsonTableStructure = $this->getTableStructure($sTableName);
        
        if (json_encode($aStructureResults) == $jsonTableStructure)
        {
            $table->status = 'Ok!';
        }
        else
        {
            $table->status = 'Issue';
        }
        //Mimoto::output($sTableName, json_encode($aStructureResults));


        // send
        return $table;
    }
    
    private function getTableStructure($sTableName)
    {
        // init
        $sTableStructure = '';
        
        switch($sTableName)
        {
            case CoreConfig::MIMOTO_ACTION: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_COMPONENT: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_COMPONENTCONDITIONAL: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_COMPONENTTEMPLATE: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"file","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_CONNECTION: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"parent_entity_type_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"parent_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"parent_property_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"child_entity_type_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"child_id","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"sortindex","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_DATASET: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"isHiddenFromMenu","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_ENTITY: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"isAbstract","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_ENTITYPROPERTY: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"subtype","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_ENTITYPROPERTYSETTING: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"key","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FILE: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"path","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mime","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"size","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"width","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"height","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"aspectRatio","Type":"float(10,5)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"originalName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"manualSave","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"realtimeCollaborationMode","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"customSubmit","Type":"enum(\'0\',\'1\')","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"action","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"method","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"target","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_FIELD: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"description","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"placeholder","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"prefix","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"title","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"subtitle","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"introduction","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_FIELD_RULES: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"key","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_INPUTOPTION: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"label","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
//            case CoreConfig::MIMOTO_FORM_INPUTOPTION_MAP: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"targetKey","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"originKey","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORM_FIELD_VALIDATION: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"value","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"errorMessage","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"trigger","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORMATTINGOPTION: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"tagName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"toolbar","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"jsOnAdd","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"jsOnEdit","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_FORMATTINGOPTIONATTRIBUTE: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"path","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"mime","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"size","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"width","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"height","Type":"int(10) unsigned","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"aspectRatio","Type":"float(10,5)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"originalName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_LAYOUT: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"file","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_LAYOUTCONTAINER: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_NOTIFICATION: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"title","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"message","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"category","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"dispatcher","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"state","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_OUTPUT: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_OUTPUT_CONTAINER: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_ROUTE: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_ROUTE_PATH_ELEMENT: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"type","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"staticValue","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"varName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_SELECTION: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_SELECTIONRULE: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"typeAsVar","Type":"int(1)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"typeVarName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"idAsVar","Type":"int(1)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"idVarName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"propertyAsVar","Type":"int(1)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"propertyVarName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_USER: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"firstName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"lastName","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"email","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"password","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
            case CoreConfig::MIMOTO_USER_ROLE: $sTableStructure = '[{"Field":"id","Type":"int(10) unsigned","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},{"Field":"name","Type":"varchar(255)","Null":"YES","Key":"","Default":null,"Extra":""},{"Field":"created","Type":"datetime","Null":"YES","Key":"","Default":null,"Extra":""}]'; break;
        }
        
        // send
        return $sTableStructure;
    }

}

<?php

// classpath
namespace Mimoto\Selection;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * SelectionService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SelectionService
{

    // config data
    private $_aSelectionConfigs = [];



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct()
    {
        return;
        // toggle between cache or database
        if ( Mimoto::service('cache')->isEnabled() && Mimoto::service('cache')->getValue('mimoto.core.selectionconfigs'))
        {
            // load
            $this->_aSelectionConfigs = Mimoto::service('cache')->getValue('mimoto.core.selectionconfigs');
        }
        else
        {
            // load
            $this->_aSelectionConfigs = CoreConfig::getCoreSelections();
            $this->_aSelectionConfigs = array_merge($this->_aSelectionConfigs, $this->loadProjectSelectionConfigs());

            // cache
            if (Mimoto::service('cache')->isEnabled())
            {
                Mimoto::service('cache')->setValue('mimoto.core.selectionconfigs', $this->_aSelectionConfigs);
            }
        }
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get form by its name
     */
    public function getSelectionByName($sSelectionName)
    {
        $nSelectionConfigCount = count($this->_aSelectionConfigs);
        for ($nSelectionConfigIndex = 0; $nSelectionConfigIndex < $nSelectionConfigCount; $nSelectionConfigIndex++)
        {
            // register
            $selectionConfig = $this->_aSelectionConfigs[$nSelectionConfigIndex];

            if ($selectionConfig->name == $sSelectionName)
            {
                if (isset($selectionConfig->class) && substr($sSelectionName, 0, strlen(CoreConfig::CORE_PREFIX)) == CoreConfig::CORE_PREFIX)
                {
                    // load form
                    $selection = call_user_func(array($selectionConfig->class, 'getSelection'));
                }
                else
                {
                    // load form from database
                    $selection = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $selectionConfig->id);
                }

                // validate and send
                if ($selection !== false) return $selection;
            }
        }

        // if here, broadcast error
        Mimoto::service('log')->error('Unknown form requested', "I wasn't able to find the selection with name <b>".$sSelectionName."</b> in the database");
    }




    /**
     * Load project selections
     */
    private function loadProjectSelectionConfigs()
    {
        // load
        $aAllSelectionConfigs = $this->loadRawSelectionConfigData();
        $aAllSelectionConfigConnections = $this->loadRawSelectionConfigConnectionData(CoreConfig::MIMOTO_SELECTION);
        $aAllSelectionRules = $this->loadRawSelectionConfigConnectionData(CoreConfig::MIMOTO_SELECTIONRULE);

        $nSelectionConfigCount = count($aAllSelectionConfigConnections);
        for ($nSelectionConfigIndex = 0; $nSelectionConfigIndex < $nSelectionConfigCount; $nSelectionConfigIndex++)
        {
            // register
            $selectionConfig = $aAllSelectionConfigConnections[$nSelectionConfigIndex];

            // read
            $nSelectionId = $selectionConfig->id;

            // verify
            if (isset($aAllSelectionConfigConnections[$nSelectionId]))
            {
                // connect
                $nSelectionFieldCount = count($aAllSelectionConfigConnections[$nSelectionId]);
                for ($nSelectionFieldIndex = 0; $nSelectionFieldIndex < $nSelectionFieldCount; $nSelectionFieldIndex++)
                {
                    // register
                    $selectionRuleConnection = $aAllSelectionConfigConnections[$nSelectionId][$nSelectionFieldIndex];

                }
            }
        }

        // send
        return $aAllSelectionConfigs;
    }



    // ----------------------------------------------------------------------------
    // --- Private methods - Raw data ---------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Load raw selection data
     * @return array Entities
     */
    private function loadRawSelectionConfigData()
    {
        // init
        $aSelections = [];

        // load all entities
        $stmt = Mimoto::service('database')->prepare('SELECT * FROM `'.CoreConfig::MIMOTO_SELECTION.'`');
        $params = array();
        $stmt->execute($params);

        foreach ($stmt as $row)
        {
            // compose
            $selection = (object) array(
                'id' => $row['id'],
                'created' => $row['created'],
                'name' => $row['name'],
                'rules' => []
            );

            // store
            $aSelections[] = $selection;
        }

        // send
        return $aSelections;
    }

    /**
     * Load raw connection data
     * @param string Parent entity type id
     * @return array Entity connections
     */
    private function loadRawSelectionConfigConnectionData($sParentEntityTypeId)
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
                'parent_property_id' => $row['parent_property_id'],         // the id of the parent entity's property
                'parent_id' => $row['parent_id'],                           // the id of the parent entity
                'child_entity_type_id' => $row['child_entity_type_id'],     // the id of the child's entity config
                'child_id' => $row['child_id'],                             // the id of the child entity connected to the parent
                'sortindex' => $row['sortindex']                            // the sortindex
            );

            // load
            $nEntityId = $row['parent_id'];

            // store
            $aConnections[$nEntityId][] = $connection;
        }

        // send
        return $aConnections;
    }

}

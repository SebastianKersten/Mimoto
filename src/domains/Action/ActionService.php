<?php

// classpath
namespace Mimoto\Action;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * ActionService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ActionService
{

    // config data
    private $_aActionConfigs = [];



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct()
    {
        // toggle between cache or database
        if ( Mimoto::service('cache')->isEnabled() && Mimoto::service('cache')->getValue('mimoto.core.actionconfigs'))
        {
            // load
            $this->_aActionConfigs = Mimoto::service('cache')->getValue('mimoto.core.actionconfigs');
        }
        else
        {
            // load
            $this->_aActionConfigs = CoreConfig::getCoreActions();
//            $this->_aActionConfigs = array_merge($this->_aActionConfigs, $this->loadProjectActionConfigs());
//
//            // cache
//            if (Mimoto::service('cache')->isEnabled())
//            {
//                Mimoto::service('cache')->setValue('mimoto.core.actionconfigs', $this->_aActionConfigs);
//            }
        }


        //error($this->_aActionConfigs);
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------


    //public function getActionsByEvent($sEvent)
    public function getAllActions()
    {
        return $this->_aActionConfigs;
    }


    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Load project forms
     */
    private function loadProjectActionConfigs()
    {
        // load
        $aAllFormConfigs = $this->loadRawFormConfigData();
        $aAllFormConfigConnections = $this->loadRawFormConfigConnectionData(CoreConfig::MIMOTO_FORM);

        $nFormConfigCount = count($aAllFormConfigs);
        for ($nFormConfigIndex = 0; $nFormConfigIndex < $nFormConfigCount; $nFormConfigIndex++)
        {
            // register
            $formConfig = $aAllFormConfigs[$nFormConfigIndex];

            // read
            $nFormId = $formConfig->id;

            if (isset($aAllFormConfigConnections[$nFormId]))
            {
                $nFormFieldCount = count($aAllFormConfigConnections[$nFormId]);

                for ($nFormFieldIndex = 0; $nFormFieldIndex < $nFormFieldCount; $nFormFieldIndex++)
                {
                    // register
                    $formFieldConnection = $aAllFormConfigConnections[$nFormId][$nFormFieldIndex];

                    // check if field is input
                    if (Mimoto::service('config')->entityIsTypeOf($formFieldConnection->child_entity_type_id, CoreConfig::MIMOTO_FORM_INPUT))
                    {
                        // store
                        $formConfig->inputFieldIds[] = $formFieldConnection->child_id;
                    }
                }
            }
        }

        // send
        return $aAllFormConfigs;
    }



    // ----------------------------------------------------------------------------
    // --- Private methods - Raw data ---------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Load raw form data
     * @return array Entities
     */
    private function loadRawFormConfigData()
    {
        // init
        $aForms = [];

        // load all entities
        $stmt = Mimoto::service('database')->prepare('SELECT * FROM `'.CoreConfig::MIMOTO_FORM.'`');
        $params = array();
        $stmt->execute($params);

        foreach ($stmt as $row)
        {
            // compose
            $form = (object) array(
                'id' => $row['id'],
                'created' => $row['created'],
                'name' => $row['name'],
                'description' => $row['description'],
                'realtimeCollaborationMode' => $row['realtimeCollaborationMode'],
                'customSubmit' => $row['customSubmit'],
                'action' => $row['action'],
                'method' => $row['method'],
                'target' => $row['target'],
                'inputFieldIds' => []
            );

            // store
            $aForms[] = $form;
        }

        // send
        return $aForms;
    }

    /**
     * Load raw connection data
     * @param string Parent entity type id
     * @return array Entity connections
     */
    private function loadRawFormConfigConnectionData($sParentEntityTypeId)
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

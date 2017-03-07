<?php

// classpath
namespace Mimoto\Selection;

// Mimoto classes
use Mimoto\EntityConfig\EntityConfigUtils;
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
        // toggle between cache or database
        if ( Mimoto::service('cache')->isEnabled() && Mimoto::service('cache')->getValue('mimoto.core.selectionconfigs'))
        {
            // load
            $this->_aSelectionConfigs = Mimoto::service('cache')->getValue('mimoto.core.selectionconfigs');
        }
        else
        {
            // load
            $this->_aSelectionConfigs = array_merge(CoreConfig::getCoreSelections(), $this->loadProjectSelectionConfigs());

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
    public function getSelection($sSelectionNameOrId)
    {
        // init
        $selection = null;

        // define search startegy
        $bSearchById = MimotoDataUtils::isValidId($sSelectionNameOrId);

        // find
        $nSelectionConfigCount = count($this->_aSelectionConfigs);
        for ($nSelectionConfigIndex = 0; $nSelectionConfigIndex < $nSelectionConfigCount; $nSelectionConfigIndex++)
        {
            // register
            $selectionConfig = $this->_aSelectionConfigs[$nSelectionConfigIndex];

            // verify
            if (($bSearchById && $selectionConfig->id == $sSelectionNameOrId) ||
                (!$bSearchById && $selectionConfig->name == $sSelectionNameOrId))
            {
                // store
                $selection = $selectionConfig;
                break;
            }
        }

        // validate or report
        if (empty($selection)) Mimoto::service('log')->silent('Unknown selection requested', "I wasn't able to find the selection with name or id <b>`".$sSelectionNameOrId."`</b> in the database");

        // send
        return $selection;
    }



    /**
     * Load project selections
     */
    private function loadProjectSelectionConfigs()
    {
        // init
        $aSelections = [];

        // init
        $aAllSelections = [];
        $aAllSelectionRuleConnections = EntityConfigUtils::loadRawConnectionData(CoreConfig::MIMOTO_SELECTION);
        $aAllSelectionRules = [];


        // load all selections
        $stmt = Mimoto::service('database')->prepare('SELECT * FROM `'.CoreConfig::MIMOTO_SELECTION.'`');
        $params = array();
        $stmt->execute($params);

        foreach ($stmt as $row)
        {
            // compose and store
            $aAllSelections[] = (object) array(
                'id' => $row['id'],
                'name' => $row['name'],
                'created' => $row['created'],
                'rules' => []
            );
        }

        // load all selection rules
        $stmt = Mimoto::service('database')->prepare('SELECT * FROM `'.CoreConfig::MIMOTO_SELECTIONRULE.'`');
        $params = array();
        $stmt->execute($params);

        foreach ($stmt as $row)
        {
            // compose and store
            $aAllSelectionRules[] = (object) array(
                'id' => $row['id'],
                'type' => $row['type'],
                'entity_type_id' => $row['entity_type_id'],
                'instance_id' => $row['instance_id'],
                'property_id' => $row['property_id'],
                'created' => $row['created'],
            );
        }

        // build
        $nSelectionCount = count($aAllSelections);
        for ($nSelectionIndex = 0; $nSelectionIndex < $nSelectionCount; $nSelectionIndex++)
        {
            // register
            $selection = $aAllSelections[$nSelectionIndex];

            // read
            $nSelectionId = $selection->id;

            // init
            $aRules = [];

            // verify
            if (isset($aAllSelectionRuleConnections[$nSelectionId]))
            {
                // connect
                $nSelectionRuleCount = count($aAllSelectionRuleConnections[$nSelectionId]);
                for ($nSelectionRuleIndex = 0; $nSelectionRuleIndex < $nSelectionRuleCount; $nSelectionRuleIndex++)
                {
                    // register
                    $selectionRuleConnection = $aAllSelectionRuleConnections[$nSelectionId][$nSelectionRuleIndex];

                    // verify
                    if ($selectionRuleConnection->parent_id == $selection->id)
                    {
                        // search
                        $nRuleCount = count($aAllSelectionRules);
                        for ($nRuleIndex = 0;$nRuleIndex < $nRuleCount; $nRuleIndex++)
                        {
                            // register
                            $rule = $aAllSelectionRules[$nRuleIndex];

                            // verify
                            if ($rule->id == $selectionRuleConnection->child_id)
                            {
                                // validate
                                if (!empty($rule->entity_type_id) || !empty($rule->instance_id) || !empty($rule->property_id))
                                {
                                    // compose and store
                                    $aRules[] = (object) array(
                                        'entity_type_id' => $rule->entity_type_id,
                                        'instance_id' => $rule->instance_id,
                                        'property_id' => $rule->property_id
                                    );
                                }
                            }
                        }
                    }
                }
            }

            // verify
            if (count($aRules) > 0)
            {
                // store
                $selection->rules = array_merge($selection->rules, $aRules);

                // store
                $aSelections[] = $selection;
            }
        }

        // send
        return $aSelections;
    }

}

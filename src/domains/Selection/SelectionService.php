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
     * @param $selectionSettings array|object The settings for a quick configuration
     * @return Selection
     */
    public function create($selectionSettings = null)
    {
        // init
        return new Selection($selectionSettings);
    }



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
                $selection = $this->buildSelectionFromConfig($selectionConfig);
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
        $aAllSelections = EntityConfigUtils::loadRawEntityData(CoreConfig::MIMOTO_SELECTION);
        $aAllSelectionRuleConnections = EntityConfigUtils::loadRawConnectionData(CoreConfig::MIMOTO_SELECTION);
        $aAllSelectionRules = EntityConfigUtils::loadRawEntityData(CoreConfig::MIMOTO_SELECTION_RULE);
        $aAllSelectionRuleSettingsConnections = EntityConfigUtils::loadRawConnectionData(CoreConfig::MIMOTO_SELECTION_RULE);
        $aAllSelectionRuleValues = EntityConfigUtils::loadRawEntityData(CoreConfig::MIMOTO_SELECTION_RULE_VALUE);




        // --- compose ---


        // build
        $nSelectionCount = count($aAllSelections);
        for ($nSelectionIndex = 0; $nSelectionIndex < $nSelectionCount; $nSelectionIndex++)
        {
            // register
            $selection = $aAllSelections[$nSelectionIndex];

            // read
            $nSelectionId = $selection->mimoto_id;

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
                    if ($selectionRuleConnection->parent_id == $selection->mimoto_id)
                    {
                        // search
                        $nRuleCount = count($aAllSelectionRules);
                        for ($nRuleIndex = 0;$nRuleIndex < $nRuleCount; $nRuleIndex++)
                        {
                            // register
                            $rule = $aAllSelectionRules[$nRuleIndex];

                            // verify
                            if ($rule->mimoto_id == $selectionRuleConnection->child_id)
                            {
                                // init
                                $bSettingFound = false;

                                if (isset($aAllSelectionRuleSettingsConnections[$rule->mimoto_id]))
                                {
                                    // init
                                    $newSelectionRule = (object) array();

                                    $nSelectionRuleSettingCount = count($aAllSelectionRuleSettingsConnections[$rule->mimoto_id]);
                                    for ($nSelectionRuleSettingIndex = 0; $nSelectionRuleSettingIndex < $nSelectionRuleSettingCount; $nSelectionRuleSettingIndex++)
                                    {
                                        // register
                                        $selectionRuleSetting = $aAllSelectionRuleSettingsConnections[$rule->mimoto_id][$nSelectionRuleSettingIndex];

                                        switch($selectionRuleSetting->parent_property_id)
                                        {
                                            case CoreConfig::MIMOTO_SELECTION_RULE.'--type':

                                                $newSelectionRule->type = Mimoto::service('entityConfig')->getEntityNameById($selectionRuleSetting->child_id);
//                                            $newSelectionRule->type = (object) array(
//                                                'id' => $selectionRuleSetting->child_id,
//                                                'name' => Mimoto::service('entityConfig')->getEntityNameById($selectionRuleSetting->child_id)
//                                            );
                                                $bSettingFound = true;
                                                break;

                                            case CoreConfig::MIMOTO_SELECTION_RULE.'--instance':

                                                $newSelectionRule->instance = $selectionRuleSetting->child_id;
//                                                $newSelectionRule->instance = (object) array(
//                                                    'entity_type_id' => $selectionRuleSetting->child_entity_type_id,
//                                                    'entity_type_name' => Mimoto::service('entityConfig')->getEntityNameById($selectionRuleSetting->child_entity_type_id),
//                                                    'instance_id' => $selectionRuleSetting->child_id
//                                                );

                                                $bSettingFound = true;
                                                break;

                                            case CoreConfig::MIMOTO_SELECTION_RULE.'--property':

                                                $newSelectionRule->property = Mimoto::service('entityConfig')->getPropertyNameById($selectionRuleSetting->child_id, $selectionRuleSetting->parent_entity_type_id);
//                                                $newSelectionRule->property = (object) array(
//                                                    'property_type_id' => $selectionRuleSetting->child_id,
//                                                    'property_type_name' => Mimoto::service('entityConfig')->getPropertyNameById($selectionRuleSetting->child_id, $selectionRuleSetting->parent_entity_type_id)
//                                                );
                                                $bSettingFound = true;
                                                break;

                                            case CoreConfig::MIMOTO_SELECTION_RULE.'--values':

                                                // init
                                                if (!isset($newSelectionRule->values)) $newSelectionRule->values = [];

                                                $nRuleValueCount = count($aAllSelectionRuleValues);
                                                for ($nRuleValueIndex = 0; $nRuleValueIndex < $nRuleValueCount; $nRuleValueIndex++)
                                                {
                                                    // register
                                                    $ruleValue = $aAllSelectionRuleValues[$nRuleValueIndex];

                                                    if ($ruleValue->mimoto_id == $selectionRuleSetting->child_id)
                                                    {
                                                        // add
                                                        $newSelectionRule->values[] = (object) array(
                                                            'propertyName' => $ruleValue->propertyName,
                                                            'value' => $ruleValue->value,
                                                        );
                                                        break;
                                                    }
                                                }
                                                $bSettingFound = true;
                                                break;
                                        }
                                    }
                                }

                                // verify and add
                                if ($bSettingFound) $aRules[] = $newSelectionRule;

                            }
                        }
                    }
                }
            }

            // verify
            if (count($aRules) > 0)
            {
                // store
                $selection->rules = $aRules;

                // store
                $aSelections[] = $selection;
            }
        }
        //die();
        //Mimoto::error($aSelections);
        // send
        return $aSelections;
    }


    private function buildSelectionFromConfig($selectionConfig)
    {
        // 1. init
        $selection = new Selection();

        // 2. setup
        $selection->setName($selectionConfig->name);

        // 3. parse rules
        $nRuleCount = count($selectionConfig->rules);
        for ($nRuleIndex = 0; $nRuleIndex < $nRuleCount; $nRuleIndex++)
        {
            // a. register
            $ruleConfig = $selectionConfig->rules[$nRuleIndex];

            // b. init
            $rule = $selection->addRule();

            // c. setup
            if (isset($ruleConfig->type)) $rule->setType($ruleConfig->type);
            if (isset($ruleConfig->instance)) $rule->setId($ruleConfig->instance);
            if (isset($ruleConfig->property)) $rule->setProperty($ruleConfig->property);


            // d. setup
            if (isset($ruleConfig->typeAsVar)) $rule->setTypeAsVar($ruleConfig->typeVarName);
            if (isset($ruleConfig->idAsVar)) $rule->setIdAsVar($ruleConfig->idVarName);
            if (isset($ruleConfig->properyAsVar)) $rule->setPropertyAsVar($ruleConfig->propertyVarName);

            // e. setup
            if (isset($ruleConfig->values) && !empty($ruleConfig->values))
            {
                // I. read
                $aRuleValues = $ruleConfig->values;

                // II. add values
                $nRuleValueCount = count($aRuleValues);
                for ($nRuleValueIndex = 0; $nRuleValueIndex < $nRuleValueCount; $nRuleValueIndex++)
                {
                    // 1. register
                    $ruleValue = $aRuleValues[$nRuleValueIndex];

                    // 2. add
                    $rule->setValue($ruleValue->propertyName, $ruleValue->value);
                }
            }
        }

        // 4. add data
        if (isset($selectionConfig->data) && is_array($selectionConfig->data)) $selection->setData($selectionConfig->data);


        //Mimoto::output($selectionConfig->name, $selectionConfig);
        //Mimoto::output('$selectionConfig', $selectionConfig);
        //Mimoto::error($selection);

        // 5. send
        return $selection;
    }

}

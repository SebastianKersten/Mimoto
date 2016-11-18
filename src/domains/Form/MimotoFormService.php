<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;

use Mimoto\Core\forms\EntityForm;
use Mimoto\Core\forms\EntityPropertyForm;


/**
 * MimotoFormService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoFormService
{

    // services
    private $_MimotoEntityService;
    private $_MimotoEntityConfigService;
    private $_MimotoLogService;


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct($MimotoEntityService, $MimotoEntityConfigService, $MimotoLogService)
    {
        // register
        $this->_MimotoEntityService = $MimotoEntityService;
        $this->_MimotoEntityConfigService = $MimotoEntityConfigService;
        $this->_MimotoLogService = $MimotoLogService;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get form by its name
     */
    public function getFormByName($sFormName)
    {
        // 1. check if form is part of core
        if (substr($sFormName, 0, strlen(CoreConfig::CORE_PREFIX)) == CoreConfig::CORE_PREFIX)
        {
            // load
            $form = $this->loadCoreForm($sFormName);

            // validate and send
            if ($form !== false) return $form;
        }

        // 2. load form from database
        $aResults = $this->_MimotoEntityService->find(['type' => CoreConfig::MIMOTO_FORM, 'value' => ["name" => $sFormName]]);

        // 3. validate if form exists
        if (!isset($aResults[0]))
        {
            $this->_MimotoLogService->warn('Unknown form requested', "I wasn't able to find the form with name <b>".$sFormName."</b> in the database");
            die();
        }
        
        // send
        return $aResults[0];
    }

    public function getFormVars($form, $xValues, $aFields = null)
    {
        // 1. prepare
        $orderedValues = $this->orderValues($xValues);


        // standaard formulier feedback, met id


        // 2. register fields
        $aFields = (!empty($aFields)) ? $aFields : $form->getValue('fields');

        // 3. init
        $formVars = (object) array(
            'fieldVars' => [],
            'connectedEntities' => []
        );

        // 4. find input fields
        $nFieldCount = count($aFields);
        for ($i = 0; $i < $nFieldCount; $i++)
        {
            // register
            $field = $aFields[$i];

            // filter, inputs only
            if (!$field->typeOf(CoreConfig::MIMOTO_FORM_INPUT)) continue;

            // register
            $fieldValue = $field->getValue('value');

            // skip if invalid
            if (empty($fieldValue))
            {
                $GLOBALS['Mimoto.Log']->warn("Input misses a value", "The input with id <b>".$field->getId()."</b> is missing it's value property");
                continue;
            }

            // register
            $sVarType = $fieldValue->getValue(CoreConfig::INPUTVALUE_VARTYPE);
            $sFieldSelector = $field->getEntityTypeName().'.'.$field->getId();

            // validate
            switch($sVarType)
            {
                case CoreConfig::INPUTVALUE_VARTYPE_VARNAME:

                    // register
                    $sVarName = $fieldValue->getValue('varname');

                    // validate
                    if (!isset($orderedValues->customvars[$sVarName]))
                    {
                        $GLOBALS['Mimoto.Log']->notify('Input has no varname', "The input with id <b>".$field->getId()."</b> is of type <b>varname</b> but the actual varname hasn't been defined");
                        continue;
                    }

                    // store
                    $formVars->fieldVars[$sFieldSelector] = (object) array(
                        'key' => $sVarName,
                        'value' => $orderedValues->customvars[$sVarName]
                    );

                    break;

                case CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY:

                    // read
                    $entityPropertyId = $fieldValue->getValue('entityproperty');

                    // validate
                    if (empty($entityPropertyId))
                    {
                        $GLOBALS['Mimoto.Log']->notify('Input not properly connected to a property', "The input with id <b>".$field->getId()."</b> is of type <b>entityproperty</b> but is not actually connected to a property");
                        continue;
                    }

                    // 1. get entity to which the property is connected
                    $sEntityName = $this->_MimotoEntityConfigService->getEntityNameByPropertyId($entityPropertyId);
                    $sPropertyName = $this->_MimotoEntityConfigService->getPropertyNameById($entityPropertyId);

                    // auto create
                    if (!isset($orderedValues->entities[$sEntityName])) $orderedValues->entities[$sEntityName] = $GLOBALS['Mimoto.Data']->create($sEntityName);

                    // prepare
                    $xEntityId = $orderedValues->entities[$sEntityName]->getId();
                    if (empty($xEntityId)) $xEntityId = CoreConfig::ENTITY_NEW;
                    $sEntitySelector = $sEntityName.'.'.$xEntityId;

                    // 1. store field var
                    $formVars->fieldVars[$sFieldSelector] = (object) array(
                        'key' => $sEntitySelector.'.'.$sPropertyName,
                        'value' => $orderedValues->entities[$sEntityName]->getValue($sPropertyName)
                    );

                    // 2. store entity
                    if (!in_array($sEntitySelector, $formVars->connectedEntities)) $formVars->connectedEntities[] = $sEntitySelector;

                    break;
            }
        }

        // NOTE - make sure the array is ordered in a similar fashion
        // every time in order to make sure a public key based on the
        // content is generated identical every time, regardless the
        // order in which $xValues is composed
        ksort($formVars->fieldVars);
        sort($formVars->connectedEntities);

        // send
        return $formVars;
    }


    private function orderValues($xValues)
    {
        // init
        $orderedValues = (object) array(
            'customvars' => [],
            'entities' => []
        );

        if ($xValues instanceof MimotoEntity)
        {
            $orderedValues->entities[$xValues->getEntityTypeName()] = $xValues;
            return $orderedValues;
        }
        elseif (is_array($xValues))
        {
            foreach ($xValues as $key => $value)
            {
                if ($value instanceof MimotoEntity)
                {
                    $sKey = (!empty($key) && is_nan(intval($key))) ? $key : $value->getEntityTypeName();
                    $orderedValues->entities[$sKey] = $value;
                }
                else
                {
                    $orderedValues->customvars[$key] = $value;
                }
            }
        }

        // send
        return $orderedValues;
    }


    private function loadCoreForm($sFormName)
    {
        switch($sFormName)
        {
            case CoreConfig::COREFORM_ENTITY_NEW: return EntityForm::getStructureNew(); break;
            case CoreConfig::COREFORM_ENTITY_EDIT: return EntityForm::getStructureEdit(); break;
            case CoreConfig::COREFORM_ENTITYPROPERTY_NEW: return EntityPropertyForm::getStructureNew(); break;
            case CoreConfig::COREFORM_ENTITYPROPERTY_EDIT: return EntityPropertyForm::getStructureEdit(); break;
        }
    }
}

<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;


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


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct($MimotoEntityService, $MimotoEntityConfigService)
    {
        // register
        $this->_MimotoEntityService = $MimotoEntityService;
        $this->_MimotoEntityConfigService = $MimotoEntityConfigService;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get form by its name
     */
    public function getFormByName($sFormName)
    {
        // 1. load form from database
        $aResults = $this->_MimotoEntityService->find(['type' => CoreConfig::MIMOTO_FORM, 'value' => ["name" => $sFormName]]);

        // 2. validate if form exists
        if (!isset($aResults[0])) error("Aimless says: Form with name '".$sFormName."' not found in database");
        // #todo - silent fail?
        
        // send
        return $aResults[0];
    }

    public function getFormVars($form, $xValues)
    {
        // 1. prepare
        $orderedValues = $this->orderValues($xValues);

        // 2. register fields
        $aFields = $form->getValue('fields', true);

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

            // filter
            if (!$field->typeOf(CoreConfig::MIMOTO_FORM_INPUT)) continue;

            // register
            $fieldValue = $field->getValue('value');

            if (empty($fieldValue)) continue; // #todo - silent fail notification

            // register
            $sVarType = $fieldValue->getValue(CoreConfig::INPUTVALUE_VARTYPE);

            // validate
            switch($sVarType)
            {
                case CoreConfig::INPUTVALUE_VARTYPE_VARNAME:

                    // register
                    $sVarName = $fieldValue->getValue('varname');

                    // validate
                    if (!isset($orderedValues->customvars[$sVarName])) continue;

                    // store
                    $formVars->fieldVars[$field->getId()] = (object) array(
                        'key' => $sVarName,
                        'value' => $orderedValues->customvars[$sVarName]
                    );

                    break;

                case CoreConfig::INPUTVALUE_VARTYPE_ENTITYPROPERTY:

                    // read
                    $entityPropertyId = $fieldValue->getValue('entityproperty', true);

                    // validate
                    if (is_nan($entityPropertyId)) continue;

                    // 1. get entity to which the property is connected
                    $sEntityName = $this->_MimotoEntityConfigService->getEntityNameByPropertyId($entityPropertyId);
                    $sPropertyName = $this->_MimotoEntityConfigService->getPropertyNameById($entityPropertyId);

                    // validate
                    if (!isset($orderedValues->entities[$sEntityName])) continue;

                    // prepare
                    $sEntitySelector = $sEntityName.'.'.$orderedValues->entities[$sEntityName]->getId();

                    // 1. store field var
                    $formVars->fieldVars[$field->getId()] = (object) array(
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
                    $sKey = (!empty($key)) ? $key : $value->getEntityTypeName();
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

}

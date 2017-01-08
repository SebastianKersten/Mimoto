<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;

use Mimoto\Core\forms\EntityForm;
use Mimoto\Core\forms\EntityPropertyForm;
use Mimoto\Core\forms\EntityPropertyForm_Value_type;
use Mimoto\Core\forms\EntityPropertyForm_Entity_allowedEntityType;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowedEntityTypes;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowDuplicates;
use Mimoto\Core\forms\ComponentForm;
use Mimoto\Core\forms\ContentSectionForm;
use Mimoto\Core\forms\FormForm;
use Mimoto\Core\forms\InputTextlineForm;
use Mimoto\Core\forms\LayoutDividerForm;
use Mimoto\Core\forms\LayoutGroupStartForm;
use Mimoto\Core\forms\LayoutGroupEndForm;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


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

    public function parseForm($sFormName, Request $request)
    {
        // 1. load request data
        $requestData = json_decode($request->getContent());

        // 2. register values
        $aRequestValues = $requestData->values;
        $sPublicKey = $requestData->publicKey;

        // get all vars and entities
        $aValues = [];
        $aEntities = [];
        foreach ($aRequestValues as $key => $value)
        {
            // filter
            if (strpos($key, '.') !== false)
            {
                // prepare
                $aSelectorElements = explode('.', $key);

                // validate
                if (count($aSelectorElements) != 3) continue; // #todo - silent fail - possible misabuse
                if (!MimotoDataUtils::validatePropertyName($aSelectorElements[0])) continue;
                if (!MimotoDataUtils::isValidEntityId($aSelectorElements[1])) continue;
                if (!MimotoDataUtils::validatePropertyName($aSelectorElements[2])) continue;

                // register
                $sEntityType = $aSelectorElements[0];
                $nEntityId = $aSelectorElements[1];
                $sPropertyName = $aSelectorElements[2];

                if (!isset($aEntities[$sEntityType]))
                {
                    $aEntities[$sEntityType] = (object) array(
                        'entityType' => $sEntityType,
                        'entityId' => $nEntityId,
                        'properties' => []
                    );
                }

                $aEntities[$sEntityType]->properties[] = $sPropertyName;
            }
            else
            {
                $aValues[$key] = $value;
            }
        }

        // collect
        foreach ($aEntities as $sEntityType => $entityInfo)
        {
            if ($entityInfo->entityId == CoreConfig::ENTITY_NEW)
            {
                // create
                $entityInfo->entity = $this->_MimotoEntityService->create($entityInfo->entityType);
            }
            else
            {
                // load
                $entityInfo->entity = $this->_MimotoEntityService->get($entityInfo->entityType, $entityInfo->entityId);
            }

            // load and store
            $aValues[$entityInfo->entityType] = $entityInfo->entity;
        }


        // 3. load form
        $form = Mimoto::service('forms')->getFormByName($sFormName);

        // 4. prepare
        $formVars = Mimoto::service('forms')->getFormVars($form, $aValues);

        // 5. authenticate
        if ($sPublicKey !== Mimoto::service('user')->getUserPublicKey(json_encode($formVars->connectedEntities)))
        {
            Mimoto::service('log')->error('No permission to submit form', "The form with name <b>".$sFormName."</b> has an incorrect public key", true);
        }


        $formResponse = (object) array( //new MimotoFormResponse();
            'status' => '?',
            'formName' => $sFormName,
            'errors' => []
        );


        // collect
        $bAnyNewEntity = false;
        foreach ($aEntities as $sEntityType => $entityInfo)
        {
            // parse
            $nPropertyCount = count($entityInfo->properties);
            for ($i = 0; $i < $nPropertyCount; $i++)
            {
                // register
                $sPropertyName = $entityInfo->properties[$i];

                // compose
                $sValueKey = $entityInfo->entityType.'.'.$entityInfo->entityId.'.'.$sPropertyName;


                // read
                $sPropertyType = $entityInfo->entity->getPropertyType($sPropertyName);

                switch($sPropertyType)
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                        // update
                        $entityInfo->entity->setValue($sPropertyName, $aRequestValues->$sValueKey);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // init
                        $connection = null;

                        // validate
                        if (!empty($aRequestValues->$sValueKey))
                        {
                            // register
                            $sConnectionValue = $aRequestValues->$sValueKey;

                            // split
                            $nChildType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sConnectionValue);
                            $nChildId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sConnectionValue);

                            // register
                            $nParentEntityTypeId = $entityInfo->entity->getEntityTypeId();
                            $nParentPropertyId = Mimoto::service('config')->getPropertyIdByName($sPropertyName);

                            // convert
                            $allowedEntityType = (object) array(
                                'id' => $nChildType,
                                'name' => Mimoto::service('config')->getEntityNameById($nChildType)
                            );

                            // create
                            $connection = MimotoDataUtils::createConnection($nChildId, $nParentEntityTypeId, $nParentPropertyId, $entityInfo->entity->getId(), [$allowedEntityType], $nChildType, $sPropertyName);
                        }

                        // store
                        $entityInfo->entity->setValue($sPropertyName, $connection);

                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // init
                        $aNewConnections = [];

                        // create connections
                        foreach ($aRequestValues->$sValueKey as $sConnectionValue)
                        {
                            // split
                            $nChildType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sConnectionValue);
                            $nChildId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sConnectionValue);

                            // register
                            $nParentEntityTypeId = $entityInfo->entity->getEntityTypeId();
                            $nParentPropertyId = Mimoto::service('config')->getPropertyIdByName($sPropertyName);

                            // convert
                            $allowedEntityType = (object) array(
                                'id' => $nChildType,
                                'name' => Mimoto::service('config')->getEntityNameById($nChildType)
                            );

                            // create
                            $connection = MimotoDataUtils::createConnection($nChildId, $nParentEntityTypeId, $nParentPropertyId, $entityInfo->entity->getId(), [$allowedEntityType], $nChildType, $sPropertyName);

                            // register
                            $aNewConnections[] = $connection;
                        }

                        // load
                        $aCurrentConnections = $entityInfo->entity->getValue($sPropertyName, true);

                        // find new connections
                        $nNewConnectionCount = count($aNewConnections);
                        for ($nNewConnectionIndex = 0; $nNewConnectionIndex < $nNewConnectionCount; $nNewConnectionIndex++)
                        {
                            // register
                            $newConnection = $aNewConnections[$nNewConnectionIndex];

                            $bConnectionFound = false;
                            $nCurrentConnectionCount = count($aCurrentConnections);
                            for ($nCurrentConnectionIndex = 0; $nCurrentConnectionIndex < $nCurrentConnectionCount; $nCurrentConnectionIndex++)
                            {
                                // register
                                $currentConnection = $aCurrentConnections[$nCurrentConnectionIndex];

                                // check
                                if (MimotoDataUtils::connectionsAreSimilar($newConnection, $currentConnection))
                                {
                                    $bConnectionFound = true;
                                    break;
                                }
                            }

                            // store if new
                            if (!$bConnectionFound) $entityInfo->entity->addValue($sPropertyName, $newConnection);
                        }

                        // reload after adding new connections
                        $aCurrentConnections = $entityInfo->entity->getValue($sPropertyName, true);

                        // find removed connections
                        $nCurrentConnectionCount = count($aCurrentConnections);
                        for ($nCurrentConnectionIndex = 0; $nCurrentConnectionIndex < $nCurrentConnectionCount; $nCurrentConnectionIndex++)
                        {
                            // register
                            $currentConnection = $aCurrentConnections[$nCurrentConnectionIndex];

                            $bConnectionFound = false;
                            $nNewConnectionCount = count($aNewConnections);
                            for ($nNewConnectionIndex = 0; $nNewConnectionIndex < $nNewConnectionCount; $nNewConnectionIndex++)
                            {
                                // register
                                $newConnection = $aNewConnections[$nNewConnectionIndex];

                                // check
                                if (MimotoDataUtils::connectionsAreSimilar($newConnection, $currentConnection))
                                {
                                    $bConnectionFound = true;
                                    break;
                                }
                            }

                            // store if new
                            if (!$bConnectionFound) $entityInfo->entity->removeValue($sPropertyName, $currentConnection);
                        }

                        // reload after adding new connections
                        $aCurrentConnections = $entityInfo->entity->getValue($sPropertyName, true);

                        break;

                    default:

                        // 1. log error
                }
            }


            // prepare response
            $bIsNew = (empty($entityInfo->entity->getId())) ? true : false;

            // store
            Mimoto::service('data')->store($entityInfo->entity);


            // compose response
            if ($bIsNew)
            {
                // toggle
                $bAnyNewEntity = true;

                // init if not yet defined
                if (!isset($formResponse->newEntities)) $formResponse->newEntities = [];

                // register
                $formResponse->newEntities[$sEntityType] = (object) array(
                    'selector' => $sEntityType.'.'.CoreConfig::ENTITY_NEW,
                    'id' => $sEntityType.'.'.$entityInfo->entity->getId()
                );
            }


            // auto add to property - #todo - move to separate function
            $sInstruction = (isset($requestData->onCreatedAddTo)) ? $requestData->onCreatedAddTo : null;


            if (!empty($sInstruction))
            {
                // split
                $aInstructionParts = explode('.', $sInstruction);

                // load
                $parentEntity = Mimoto::service('data')->get($aInstructionParts[0], $aInstructionParts[1]);

                // add
                $parentEntity->addValue($aInstructionParts[2], $entityInfo->entity);

                // store
                Mimoto::service('data')->store($parentEntity);
            }
        }



        // in case of change selectors due to a newly created entity, redetermine public key
        if ($bAnyNewEntity)
        {
            // 1. init
            $aNewValues = [];

            // 2. collect
            foreach ($aEntities as $sEntityType => $entityInfo) { $aNewValues[] = $entityInfo->entity; }

            // 3. load
            $formVars = Mimoto::service('forms')->getFormVars($form, $aNewValues);

            // 4. define
            $formResponse->newPublicKey = Mimoto::service('user')->getUserPublicKey(json_encode($formVars->connectedEntities));
        }

        // send
        return $formResponse;
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
                Mimoto::service('log')->warn("Input misses a value", "The input with id <b>".$field->getId()."</b> is missing it's value property");
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
                        Mimoto::service('log')->notify('Input has no varname', "The input with id <b>".$field->getId()."</b> is of type <b>varname</b> but the actual varname hasn't been defined");
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
                    $entityProperty = $fieldValue->getValue('entityproperty', true);

                    // validate
                    if (empty($entityProperty))
                    {
                        Mimoto::service('log')->notify('Input not properly connected to a property', "The input with id <b>".$field->getId()."</b> is of type <b>entityproperty</b> but is not actually connected to a property");
                        continue;
                    }

                    // read
                    $entityPropertyId = $entityProperty->getChildId();


                    // 1. get entity to which the property is connected
                    $sEntityName = $this->_MimotoEntityConfigService->getEntityNameByPropertyId($entityPropertyId);
                    $sPropertyName = $this->_MimotoEntityConfigService->getPropertyNameById($entityPropertyId);
                    $sPropertyType = $this->_MimotoEntityConfigService->getPropertyTypeById($entityPropertyId);

                    // auto create
                    if (!isset($orderedValues->entities[$sEntityName])) $orderedValues->entities[$sEntityName] = Mimoto::service('data')->create($sEntityName);

                    // prepare
                    $xEntityId = $orderedValues->entities[$sEntityName]->getId();
                    if (empty($xEntityId)) $xEntityId = CoreConfig::ENTITY_NEW;
                    $sEntitySelector = $sEntityName.'.'.$xEntityId;


                    // init
                    $propertyValue = null;

                    // read value
                    switch($sPropertyType)
                    {
                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                            $propertyValue = $orderedValues->entities[$sEntityName]->getValue($sPropertyName);
                            break;

                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                            $propertyValueConnection = $orderedValues->entities[$sEntityName]->getValue($sPropertyName, true);

                            if (!empty($propertyValueConnection))
                            {
                                $propertyValue = $propertyValueConnection->getChildEntityTypeName().'.'.$propertyValueConnection->getChildId();
                            }
                            break;

                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                            $propertyValue = [];

                            $aPropertyValueConnections = $orderedValues->entities[$sEntityName]->getValue($sPropertyName, true);

                            $nPropertyValueConnectionCount = count($aPropertyValueConnections);
                            for ($nPropertyValueConnectionIndex = 0; $nPropertyValueConnectionIndex < $nPropertyValueConnectionCount; $nPropertyValueConnectionIndex++)
                            {
                                $propertyValueConnection = $aPropertyValueConnections[$nPropertyValueConnectionIndex];

                                $propertyValue[] = $propertyValueConnection->getChildEntityTypeName().'.'.$propertyValueConnection->getChildId();
                            }
                            break;
                    }

                    // output('propertyValue', $propertyValue, true);


                    // 1. store field var
                    $formVars->fieldVars[$sFieldSelector] = (object) array(
                        'key' => $sEntitySelector.'.'.$sPropertyName,
                        'value' => $propertyValue
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

            case CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE: return EntityPropertyForm_Value_type::getStructure(); break;
            case CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE: return EntityPropertyForm_Entity_allowedEntityType::getStructure(); break;
            case CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES: return EntityPropertyForm_Collection_allowedEntityTypes::getStructure(); break;
            case CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES: return EntityPropertyForm_Collection_allowDuplicates::getStructure(); break;

            // component -----

            case CoreConfig::COREFORM_COMPONENT_NEW: return ComponentForm::getStructureNew(); break;
            case CoreConfig::COREFORM_COMPONENT_EDIT: return ComponentForm::getStructureEdit(); break;

            // content -----

            case CoreConfig::COREFORM_CONTENTSECTION_NEW: return ContentSectionForm::getStructureNew(); break;
            case CoreConfig::COREFORM_CONTENTSECTION_EDIT: return ContentSectionForm::getStructureEdit(); break;

            // form ----------

            case CoreConfig::COREFORM_FORM_NEW:  return FormForm::getStructureNew(); break;
            case CoreConfig::COREFORM_FORM_EDIT:  return FormForm::getStructureEdit(); break;

            // input ---------

            case CoreConfig::COREFORM_INPUT_TEXTLINE_NEW: return InputTextlineForm::getStructureNew(); break;
            case CoreConfig::COREFORM_INPUT_TEXTLINE_EDIT: return InputTextlineForm::getStructureEdit(); break;


            // layout ---------

            case CoreConfig::COREFORM_LAYOUT_DIVIDER_NEW: return LayoutDividerForm::getStructureNew(); break;
            case CoreConfig::COREFORM_LAYOUT_DIVIDER_EDIT: return LayoutDividerForm::getStructureEdit(); break;

            case CoreConfig::COREFORM_LAYOUT_GROUPSTART_NEW: return LayoutGroupStartForm::getStructureNew(); break;
            case CoreConfig::COREFORM_LAYOUT_GROUPSTART_EDIT: return LayoutGroupStartForm::getStructureEdit(); break;

            case CoreConfig::COREFORM_LAYOUT_GROUPEND_NEW: return LayoutGroupEndForm::getStructureNew(); break;
            case CoreConfig::COREFORM_LAYOUT_GROUPEND_EDIT: return LayoutGroupEndForm::getStructureEdit(); break;

            default: die("MimotoFormService.loadCoreForm('$sFormName') - Form not found");
        }
    }

    public function getCoreFormByEntityTypeId($sEntitytypeId)
    {
        switch($sEntitytypeId)
        {
            // input
            case CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX: return CoreConfig::COREFORM_INPUT_CHECKBOX_NEW; break;
            case CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN: return CoreConfig::COREFORM_INPUT_DROPDOWN_NEW; break;
            case CoreConfig::MIMOTO_FORM_INPUT_IMAGE: return CoreConfig::COREFORM_INPUT_IMAGE_NEW; break;
            case CoreConfig::MIMOTO_FORM_INPUT_LIST: return CoreConfig::COREFORM_INPUT_LIST_NEW; break;
            case CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT: return CoreConfig::COREFORM_INPUT_MULTISELECT_NEW; break;
            case CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON: return CoreConfig::COREFORM_INPUT_RADIOBUTTON_NEW; break;
            case CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK: return CoreConfig::COREFORM_INPUT_TEXTBLOCK_NEW; break;
            case CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE: return CoreConfig::COREFORM_INPUT_TEXTLINE_NEW; break;
            case CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF: return CoreConfig::COREFORM_INPUT_TEXTRTF_NEW; break;
            case CoreConfig::MIMOTO_FORM_INPUT_VIDEO: return CoreConfig::COREFORM_INPUT_VIDEO_NEW; break;

            // output
            case CoreConfig::MIMOTO_FORM_OUTPUT_TITLE: return CoreConfig::COREFORM_OUTPUT_TITLE_NEW; break;

            // layout
            case CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER: return CoreConfig::COREFORM_LAYOUT_DIVIDER_NEW; break;
            case CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART: return CoreConfig::COREFORM_LAYOUT_GROUPSTART_NEW; break;
            case CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND: return CoreConfig::COREFORM_LAYOUT_GROUPEND_NEW; break;
        }
    }
}

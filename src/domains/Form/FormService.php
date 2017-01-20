<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes

use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;

use Mimoto\Core\forms\EntityPropertyForm;
use Mimoto\Core\forms\EntityPropertyForm_Value_type;
use Mimoto\Core\forms\EntityPropertyForm_Entity_allowedEntityType;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowedEntityTypes;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowDuplicates;

use Mimoto\Core\entities\Entity;
use Mimoto\Core\entities\Component;

use Mimoto\Core\entities\Form;
use Mimoto\Core\entities\InputValue;
use Mimoto\Core\entities\InputTextline;

use Mimoto\Core\entities\LayoutGroupEnd;
use Mimoto\Core\entities\LayoutGroupStart;
use Mimoto\Core\entities\LayoutDivider;

use Mimoto\Core\entities\OutputTitle;

use Mimoto\Core\entities\ContentSection;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * FormService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormService
{

    // services
    private $_EntityService;
    private $_MimotoEntityConfigService;
    private $_MimotoLogService;


    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct($EntityService, $MimotoEntityConfigService, $MimotoLogService)
    {
        // register
        $this->_EntityService = $EntityService;
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
        $aResults = $this->_EntityService->find(['type' => CoreConfig::MIMOTO_FORM, 'value' => ["name" => $sFormName]]);

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

        // 3. load form
        $form = Mimoto::service('forms')->getFormByName($sFormName);

        // 4. load
        $xParent = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $form);

        // 5. find connected entity
        $sEntityName = ($xParent instanceof MimotoEntity) ? $xParent->getValue('name') : $xParent;


        $entity = (object) array(
            'type' => $sEntityName,
            'id' => $requestData->entityId,
            'properties' => []
        );


        // collect
        $bAnyNewEntity = false;

        // get all vars and entities
        $aValues = [];
        foreach ($aRequestValues as $key => $value)
        {
            // filter
            if (strpos($key, '.') !== false)
            {
                // prepare
                $aSelectorElements = explode('.', $key);

                // validate
                if (count($aSelectorElements) != 3) continue; // #todo - silent fail - possible abuse
                if (!MimotoDataUtils::validatePropertyName($aSelectorElements[0])) continue;
                if (!MimotoDataUtils::isValidEntityId($aSelectorElements[1])) continue;
                if (!MimotoDataUtils::validatePropertyName($aSelectorElements[2])) continue;

                // register
                $sEntityType = $aSelectorElements[0];
                $nEntityId = $aSelectorElements[1];
                $sPropertyName = $aSelectorElements[2];

                $entity->properties[] = $sPropertyName;
            }
            else
            {
                $aValues[$key] = $value; // custom vars
            }
        }


        // 4. prepare
        $formVars = Mimoto::service('forms')->getFormVars($form, $aValues, null, $entity->id);



        // collect
        if (empty($entity->id))
        {
            // create
            $entity->entity = $this->_EntityService->create($entity->type);

            // collect
            $bAnyNewEntity = true;
        }
        else
        {
            if (!MimotoDataUtils::isValidEntityId($entity->id))
            {
                Mimoto::service('log')->error('Invalid id on form submit', "The form with name <b>".$sFormName."</b> has an incorrect id `".$entity->id."`");
                die();
            }

            // load
            $entity->entity = $this->_EntityService->get($entity->type, $entity->id);
        }


        // 5. authenticate #todo
//        if ($sPublicKey !== Mimoto::service('user')->getUserPublicKey(json_encode($formVars->connectedEntities)))
//        {
//            Mimoto::service('log')->error('No permission to submit form', "The form with name <b>".$sFormName."</b> has an incorrect public key", true);
//        }


        $formResponse = (object) array( //new MimotoFormResponse();
            'status' => '?',
            'formName' => $sFormName,
            'errors' => []
        );


        // parse
        $nPropertyCount = count($entity->properties);
        for ($nPropertyIndex = 0; $nPropertyIndex < $nPropertyCount; $nPropertyIndex++)
        {
            // register
            $sPropertyName = $entity->properties[$nPropertyIndex];

            // compose
            $sValueKey = $entity->type.'.'.(!empty($entity->id) ? $entity->id : CoreConfig::ENTITY_NEW).'.'.$sPropertyName;

            // read
            $sPropertyType = $entity->entity->getPropertyType($sPropertyName);

            switch($sPropertyType)
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                    // update
                    $entity->entity->setValue($sPropertyName, $aRequestValues->$sValueKey);
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
                        $nParentEntityTypeId = $entity->entity->getEntityTypeId();
                        $nParentPropertyId = Mimoto::service('config')->getPropertyIdByName($sPropertyName);

                        // convert
                        $allowedEntityType = (object) array(
                            'id' => $nChildType,
                            'name' => Mimoto::service('config')->getEntityNameById($nChildType)
                        );

                        // create
                        $connection = MimotoDataUtils::createConnection($nChildId, $nParentEntityTypeId, $nParentPropertyId, $entity->entity->getId(), [$allowedEntityType], $nChildType, $sPropertyName);
                    }

                    // store
                    $entity->entity->setValue($sPropertyName, $connection);

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
                        $nParentEntityTypeId = $entity->entity->getEntityTypeId();
                        $nParentPropertyId = Mimoto::service('config')->getPropertyIdByName($sPropertyName);

                        // convert
                        $allowedEntityType = (object) array(
                            'id' => $nChildType,
                            'name' => Mimoto::service('config')->getEntityNameById($nChildType)
                        );

                        // create
                        $connection = MimotoDataUtils::createConnection($nChildId, $nParentEntityTypeId, $nParentPropertyId, $entity->entity->getId(), [$allowedEntityType], $nChildType, $sPropertyName);

                        // register
                        $aNewConnections[] = $connection;
                    }

                    // load
                    $aCurrentConnections = $entity->entity->getValue($sPropertyName, true);

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
                        if (!$bConnectionFound) $entity->entity->addValue($sPropertyName, $newConnection);
                    }

                    // reload after adding new connections
                    $aCurrentConnections = $entity->entity->getValue($sPropertyName, true);

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
                        if (!$bConnectionFound) $entity->entity->removeValue($sPropertyName, $currentConnection);
                    }

                    // reload after adding new connections
                    $aCurrentConnections = $entity->entity->getValue($sPropertyName, true);

                    break;

                default:

                    // 1. log error
            }
        }


        // prepare response
        $bIsNew = (empty($entity->entity->getId())) ? true : false;



        // store
        Mimoto::service('data')->store($entity->entity);


        // compose response
        if ($bIsNew)
        {
            // toggle
            $bAnyNewEntity = true;

            // init if not yet defined
            if (!isset($formResponse->newEntities)) $formResponse->newEntities = [];


            $formResponse->newEntityId = $entity->entity->getId();

            // register
            $formResponse->newEntities[$entity->type] = (object) array(
                'selector' => $entity->type.'.'.CoreConfig::ENTITY_NEW,
                'id' => $entity->type.'.'.$entity->entity->getId()
            );
        }


        // auto add to property - #todo - move to separate function
        $sInstruction = (isset($requestData->onCreatedConnectTo)) ? $requestData->onCreatedConnectTo : null;


        if (!empty($sInstruction))
        {
            // split
            $aInstructionParts = explode('.', $sInstruction);

            // register
            $sInstructionEntityTypeName     = $aInstructionParts[0];
            $nInstructionEntityId           = $aInstructionParts[1];
            $sInstructionEntityPropertyName = $aInstructionParts[2];

            // load
            $eParent = Mimoto::service('data')->get($sInstructionEntityTypeName, $nInstructionEntityId);

            // read
            $sPropertyType = $eParent->getPropertyType($sInstructionEntityPropertyName);

            // validate
            if ($sPropertyType == MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY || $sPropertyType == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION)
            {
                switch ($sPropertyType)
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // add
                        $eParent->setValue($sInstructionEntityPropertyName, $entity->entity);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // add
                        $eParent->addValue($sInstructionEntityPropertyName, $entity->entity);
                        break;
                }

                // store
                Mimoto::service('data')->store($eParent);
            }
        }



        // in case of change selectors due to a newly created entity, redetermine public key
        if ($bAnyNewEntity)
        {
            // 1. init
            $aNewValues = [$entity->entity];

            // 3. load
            $formVars = Mimoto::service('forms')->getFormVars($form, $aNewValues);

            // 4. define
            $formResponse->newPublicKey = Mimoto::service('user')->getUserPublicKey(json_encode($formVars->connectedEntities));
        }

        // send
        return $formResponse;
    }

    public function getFormVars($form, $xValues, $aFields = null, $nEntityId = null)
    {
        // 1. prepare
        $orderedValues = $this->orderValues($xValues);

        // standaard formulier feedback, met id


        // 2. register fields
        $aFields = (!empty($aFields)) ? $aFields : $form->getValue('fields');

        // 3. init
        $formVars = (object) array(
            'fieldVars' => [],
            'connectedEntities' => [],
            'entityId' => $nEntityId
        );


        // read
        $xParent = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $form);

        // set
        $sEntityName = ($xParent instanceof MimotoEntity) ? $xParent->getValue('name') : $xParent;

        // default
        $formVars->connectedEntities[] = $sEntityName.'.'.(empty($nEntityId) ? CoreConfig::ENTITY_NEW : $nEntityId);



        //output('$formVars', $formVars, true);

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
                    $entityProperty = $fieldValue->getValue('entityProperty', true);

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
            case CoreConfig::COREFORM_ENTITY: return Entity::getForm(); break;

            case CoreConfig::COREFORM_ENTITYPROPERTY_NEW: return EntityPropertyForm::getStructureNew(); break;
            case CoreConfig::COREFORM_ENTITYPROPERTY_EDIT: return EntityPropertyForm::getStructureEdit(); break;

            case CoreConfig::COREFORM_ENTITYPROPERTYSETTING_VALUE_TYPE: return EntityPropertyForm_Value_type::getStructure(); break;
            case CoreConfig::COREFORM_ENTITYPROPERTYSETTING_ENTITY_ALLOWEDENTITYTYPE: return EntityPropertyForm_Entity_allowedEntityType::getStructure(); break;
            case CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWEDENTITYTYPES: return EntityPropertyForm_Collection_allowedEntityTypes::getStructure(); break;
            case CoreConfig::COREFORM_ENTITYPROPERTYSETTING_COLLECTION_ALLOWDUPLICATES: return EntityPropertyForm_Collection_allowDuplicates::getStructure(); break;

            // component -----

            case CoreConfig::COREFORM_COMPONENT: return Component::getForm(); break;

            // content -----

            case CoreConfig::COREFORM_CONTENTSECTION: return ContentSection::getForm(); break;

            // form ----------

            case CoreConfig::COREFORM_FORM: return Form::getForm(); break;
            case CoreConfig::COREFORM_FORM_INPUTVALUE: return InputValue::getForm(); break;

            // input ---------

            case CoreConfig::COREFORM_INPUT_TEXTLINE: return InputTextline::getForm(); break;

            // output ---------

            case CoreConfig::COREFORM_OUTPUT_TITLE: return OutputTitle::getForm(); break;

            // layout ---------

            case CoreConfig::COREFORM_LAYOUT_DIVIDER: return LayoutDivider::getForm(); break;
            case CoreConfig::COREFORM_LAYOUT_GROUPSTART: return LayoutGroupStart::getForm(); break;
            case CoreConfig::COREFORM_LAYOUT_GROUPEND: return LayoutGroupEnd::getForm(); break;

            default: die("FormService.loadCoreForm('$sFormName') - Form not found");
        }
    }

    public function getCoreFormByEntityTypeId($sEntitytypeId)
    {
        switch($sEntitytypeId)
        {
            // input
            case CoreConfig::MIMOTO_FORM_INPUT_CHECKBOX: return CoreConfig::COREFORM_INPUT_CHECKBOX; break;
            case CoreConfig::MIMOTO_FORM_INPUT_DROPDOWN: return CoreConfig::COREFORM_INPUT_DROPDOWN; break;
            case CoreConfig::MIMOTO_FORM_INPUT_IMAGE: return CoreConfig::COREFORM_INPUT_IMAGE; break;
            case CoreConfig::MIMOTO_FORM_INPUT_LIST: return CoreConfig::COREFORM_INPUT_LIST; break;
            case CoreConfig::MIMOTO_FORM_INPUT_MULTISELECT: return CoreConfig::COREFORM_INPUT_MULTISELECT; break;
            case CoreConfig::MIMOTO_FORM_INPUT_RADIOBUTTON: return CoreConfig::COREFORM_INPUT_RADIOBUTTON; break;
            case CoreConfig::MIMOTO_FORM_INPUT_TEXTBLOCK: return CoreConfig::COREFORM_INPUT_TEXTBLOCK; break;
            case CoreConfig::MIMOTO_FORM_INPUT_TEXTLINE: return CoreConfig::COREFORM_INPUT_TEXTLINE; break;
            case CoreConfig::MIMOTO_FORM_INPUT_TEXTRTF: return CoreConfig::COREFORM_INPUT_TEXTRTF; break;
            case CoreConfig::MIMOTO_FORM_INPUT_VIDEO: return CoreConfig::COREFORM_INPUT_VIDEO; break;

            // output
            case CoreConfig::MIMOTO_FORM_OUTPUT_TITLE: return CoreConfig::COREFORM_OUTPUT_TITLE; break;

            // layout
            case CoreConfig::MIMOTO_FORM_LAYOUT_DIVIDER: return CoreConfig::COREFORM_LAYOUT_DIVIDER; break;
            case CoreConfig::MIMOTO_FORM_LAYOUT_GROUPSTART: return CoreConfig::COREFORM_LAYOUT_GROUPSTART; break;
            case CoreConfig::MIMOTO_FORM_LAYOUT_GROUPEND: return CoreConfig::COREFORM_LAYOUT_GROUPEND; break;
        }
    }
}

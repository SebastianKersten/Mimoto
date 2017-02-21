<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * FormService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormService
{

    // config data
    private $_aFormConfigs = [];



    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Constructor
     */
    public function __construct()
    {
        // toggle between cache or database
        if ( Mimoto::service('cache')->isEnabled() && Mimoto::service('cache')->getValue('mimoto.core.formconfigs'))
        {
            // load
            $this->_aFormConfigs = Mimoto::service('cache')->getValue('mimoto.core.formconfigs');
        }
        else
        {
            // load
            $this->_aFormConfigs = CoreConfig::getCoreForms();
            $this->_aFormConfigs = array_merge($this->_aFormConfigs, $this->loadProjectFormConfigs());

            // cache
            if (Mimoto::service('cache')->isEnabled())
            {
                Mimoto::service('cache')->setValue('mimoto.core.formconfigs', $this->_aFormConfigs);
            }
        }
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods----------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get form by its name
     */
    public function getFormByName($sFormName)
    {
        $nFormConfigCount = count($this->_aFormConfigs);
        for ($nFormConfigIndex = 0; $nFormConfigIndex < $nFormConfigCount; $nFormConfigIndex++)
        {
            // register
            $formConfig = $this->_aFormConfigs[$nFormConfigIndex];

            if ($formConfig->name == $sFormName)
            {
                if (isset($formConfig->class) && substr($sFormName, 0, strlen(CoreConfig::CORE_PREFIX)) == CoreConfig::CORE_PREFIX)
                {
                    // load form
                    $form = call_user_func(array($formConfig->class, 'getForm'));
                }
                else
                {
                    // load form from database
                    $form = Mimoto::service('data')->get(CoreConfig::MIMOTO_FORM, $formConfig->id);
                }

                // validate and send
                if ($form !== false) return $form;
            }
        }

        // if here, broadcast error
        Mimoto::service('log')->error('Unknown form requested', "I wasn't able to find the form with name <b>".$sFormName."</b> in the database");
    }

    public function getFormFieldByFieldId($nRequestedFieldId)
    {
        // init
        $field = null;

        $nFormConfigCount = count($this->_aFormConfigs);
        for ($nFormConfigIndex = 0; $nFormConfigIndex < $nFormConfigCount; $nFormConfigIndex++)
        {
            // register
            $formConfig = $this->_aFormConfigs[$nFormConfigIndex];

            // register
            $aInputFieldIds = $formConfig->inputFieldIds;

            $nInputFieldIdCount = count($aInputFieldIds);
            for ($nInputFieldIdIndex = 0; $nInputFieldIdIndex < $nInputFieldIdCount; $nInputFieldIdIndex++)
            {
                // register
                $formFielId = $aInputFieldIds[$nInputFieldIdIndex];

                // verify
                if ($formFielId == $nRequestedFieldId)
                {
                    // load form
                    $form = call_user_func(array($formConfig->class, 'getForm'));

                    // validate and send
                    $aFormFields = $form->getValue('fields');

                    $nFormFieldCount = count($aFormFields);
                    for ($nFormFieldIndex = 0; $nFormFieldIndex < $nFormFieldCount; $nFormFieldIndex++)
                    {
                        // register
                        $formField = $aFormFields[$nFormFieldIndex];

                        // verify
                        if ($formField->getId() == $nRequestedFieldId)
                        {
                            $field = $formField;
                            break 3;
                        }
                    }
                }
            }
        }

        // send
        return $field;
    }



    public function parseForm($sFormName, Request $request)
    {
        // 1. load request data
        $requestData = json_decode($request->getContent());

        // 2. register values
        $aValues = $requestData->values;

        // 3. load form
        $form = Mimoto::service('forms')->getFormByName($sFormName);

        // 4. load
        $xParent = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $form);

        // 5. find connected entity
        $sEntityName = ($xParent instanceof MimotoEntity) ? $xParent->getValue('name') : $xParent;


        // collect
        if (empty($requestData->entityId))
        {
            // create
            $entity = Mimoto::service('data')->create($sEntityName);
        }
        else
        {
            if (!MimotoDataUtils::isValidEntityId($requestData->entityId))
            {
                Mimoto::service('log')->error('Invalid id on form submit', "The form with name <b>".$sFormName."</b> has an incorrect id `".$requestData->entityId."`");
                die();
            }

            // load
            $entity = Mimoto::service('data')->get($sEntityName, $requestData->entityId);
        }


        // 4. prepare
        $formFieldValues = Mimoto::service('forms')->getFormFieldValues($form, $entity, null, $entity->getId()); // todo - strip values

        // get all vars and entities
        $nFieldCount = count($formFieldValues->fields);
        for ($nFieldIndex = 0; $nFieldIndex < $nFieldCount; $nFieldIndex++)
        {
            // register
            $field = $formFieldValues->fields[$nFieldIndex];

            // read
            $sFieldKey = $field->key;

            // validate is value was passed
            $field->newValue = (isset($aValues->$sFieldKey)) ? $aValues->$sFieldKey : $field->newValue = null;
        }


        // 5. authenticate #todo
        $sPublicKey = $requestData->publicKey;
//        if ($sPublicKey !== Mimoto::service('users')->getUserPublicKey(json_encode($formVars->connectedEntities)))
//        {
//            Mimoto::service('log')->error('No permission to submit form', "The form with name <b>".$sFormName."</b> has an incorrect public key", true);
//        }


        $formResponse = (object) array( //new MimotoFormResponse();
            'status' => '?',
            'formName' => $sFormName,
            'errors' => []
        );


        // get all vars and entities
        $nFieldCount = count($formFieldValues->fields);
        for ($nFieldIndex = 0; $nFieldIndex < $nFieldCount; $nFieldIndex++)
        {
            // register
            $field = $formFieldValues->fields[$nFieldIndex];

            // validate
            if (!$entity->hasProperty($field->propertyName)) Mimoto::service('log')->error('Unknown property on submit form', "The form with name <b>".$sFormName."</b> tries to store an unknown property", true);


            // read
            $sPropertyType = $entity->getPropertyType($field->propertyName);


            switch($sPropertyType)
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                    // update
                    $entity->setValue($field->propertyName, $field->newValue);
                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                    // init
                    $connection = null;

                    // validate
                    if (!empty($field->newValue))
                    {
                        // register
                        $sConnectionValue = $field->newValue;

                        // split
                        $nChildType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sConnectionValue);
                        $nChildId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sConnectionValue);

                        // register
                        $nParentEntityTypeId = $entity->getEntityTypeId();
                        $nParentPropertyId = Mimoto::service('config')->getPropertyIdByName($field->propertyName, $nParentEntityTypeId);

                        // convert
                        $allowedEntityType = (object) array(
                            'id' => $nChildType,
                            'name' => Mimoto::service('config')->getEntityNameById($nChildType)
                        );

                        // create
                        $connection = MimotoDataUtils::createConnection($nChildId, $nParentEntityTypeId, $nParentPropertyId, $entity->getId(), [$allowedEntityType], $nChildType, $field->propertyName);
                    }

                    // store
                    $entity->setValue($field->propertyName, $connection);

                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                    // init
                    $aNewConnections = [];


                    // correct
                    if (!empty($field->newValue) && !is_array($field->newValue)) $field->newValue = [$field->newValue];


                    // verify
                    if (!empty($field->newValue))
                    {
                        // create connections
                        foreach ($field->newValue as $sConnectionValue)
                        {
                            // split
                            $nChildType = MimotoDataUtils::getEntityTypeFromEntityInstanceSelector($sConnectionValue);
                            $nChildId = MimotoDataUtils::getEntityIdFromEntityInstanceSelector($sConnectionValue);

                            // register
                            $nParentEntityTypeId = $entity->getEntityTypeId();
                            $nParentPropertyId = Mimoto::service('config')->getPropertyIdByName($field->propertyName, $nParentEntityTypeId);

                            // convert
                            $allowedEntityType = (object)array(
                                'id' => $nChildType,
                                'name' => Mimoto::service('config')->getEntityNameById($nChildType)
                            );

                            // create
                            $connection = MimotoDataUtils::createConnection($nChildId, $nParentEntityTypeId, $nParentPropertyId, $entity->getId(), [$allowedEntityType], $nChildType, $field->propertyName);

                            // register
                            $aNewConnections[] = $connection;
                        }
                    }

                    // load
                    $aCurrentConnections = $entity->getValue($field->propertyName, true);

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
                        if (!$bConnectionFound) $entity->addValue($field->propertyName, $newConnection);
                    }

                    // reload after adding new connections
                    $aCurrentConnections = $entity->getValue($field->propertyName, true);

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
                        if (!$bConnectionFound) $entity->removeValue($field->propertyName, $currentConnection);
                    }

                    // reload after adding new connections
                    $aCurrentConnections = $entity->getValue($field->propertyName, true);

                    break;

                default:

                    // 1. log error
            }
        }



        // prepare response
        $bIsNew = (empty($entity->getId())) ? true : false;



        // store
        Mimoto::service('data')->store($entity);


        // compose response
        if ($bIsNew)
        {
            // toggle
            $bAnyNewEntity = true;

            // init if not yet defined
            if (!isset($formResponse->newEntities)) $formResponse->newEntities = [];


            $formResponse->newEntityId = $entity->getId();

            // register
            $formResponse->newEntities[$entity->getEntityTypeName()] = (object) array(
                'selector' => $entity->getEntityTypeName().'.'.CoreConfig::ENTITY_NEW,
                'id' => $entity->getEntityTypeName().'.'.$entity->getId()
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
            if ($sPropertyType == MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY ||
                $sPropertyType == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION)
            {
                switch ($sPropertyType)
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // add
                        $eParent->setValue($sInstructionEntityPropertyName, $entity);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // add
                        $eParent->addValue($sInstructionEntityPropertyName, $entity);
                        break;
                }

                // store
                Mimoto::service('data')->store($eParent);
            }
        }

        // in case of change selectors due to a newly created entity, redetermine public key
        if ($bIsNew)
        {
            // 1. load
            $formFieldValues = Mimoto::service('forms')->getFormFieldValues($form, $entity);

            // 2. define
            $formResponse->newPublicKey = Mimoto::service('users')->getUserPublicKey(json_encode($formFieldValues));
        }

        // send
        return $formResponse;
    }




    public function getFormFieldValues($form, $entity, $aFields = null, $nEntityId = null)
    {
        // 1. register fields
        $aFormFields = (!empty($aFields)) ? $aFields : $form->getValue('fields');

        // read
        $xParent = Mimoto::service('config')->getParent(CoreConfig::MIMOTO_ENTITY, CoreConfig::MIMOTO_ENTITY.'--forms', $form);

        // set
        $sEntityName = ($xParent instanceof MimotoEntity) ? $xParent->getValue('name') : $xParent;


        // 1. init
        $formFieldValues = (object) array(
            'entityId' => $nEntityId,
            'entitySelector' => $sEntityName.'.'.(empty($nEntityId) ? CoreConfig::ENTITY_NEW : $nEntityId),
            'fields' => []
        );

        // 4. find input fields
        $nFormFieldCount = count($aFormFields);
        for ($nFormFieldIndex = 0; $nFormFieldIndex < $nFormFieldCount; $nFormFieldIndex++)
        {
            // register
            $formField = $aFormFields[$nFormFieldIndex];

            // filter, inputs only
            if (!$formField->typeOf(CoreConfig::MIMOTO_FORM_INPUT)) continue;

            // read
            $fieldValueConnection = $formField->getValue('value', true);

            // skip if invalid
            if (empty($fieldValueConnection))
            {
                Mimoto::service('log')->warn("An input's value is unset", "The input with id <b>".$formField->getId()."</b> is missing it's value property");
                continue;
            }

            // register
            $sFieldSelector = $formField->getEntityTypeName().'.'.$formField->getId();

            // read
            $fieldValueId = $fieldValueConnection->getChildId();


            // 1. get entity to which the property is connected
            $sEntityName = Mimoto::service('config')->getEntityNameByPropertyId($fieldValueId);
            $sPropertyName = Mimoto::service('config')->getPropertyNameById($fieldValueId);
            $sPropertyType = Mimoto::service('config')->getPropertyTypeById($fieldValueId);

            // auto create
            if (!isset($entity)) $entity = Mimoto::service('data')->create($sEntityName);

            // prepare
            $xEntityId = $entity->getId();
            if (empty($xEntityId)) $xEntityId = CoreConfig::ENTITY_NEW;
            $sEntitySelector = $sEntityName.'.'.$xEntityId;


            // init
            $propertyValue = null;

            // read value
            switch($sPropertyType)
            {
                case MimotoEntityPropertyTypes::PROPERTY_TYPE_VALUE:

                    $propertyValue = $entity->getValue($sPropertyName);
                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                    $propertyValueConnection = $entity->getValue($sPropertyName, true);

                    if (!empty($propertyValueConnection))
                    {
                        $propertyValue = $propertyValueConnection->getChildEntityTypeName().'.'.$propertyValueConnection->getChildId();
                    }
                    break;

                case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                    $propertyValue = [];

                    $aPropertyValueConnections = $entity->getValue($sPropertyName, true);

                    $nPropertyValueConnectionCount = count($aPropertyValueConnections);
                    for ($nPropertyValueConnectionIndex = 0; $nPropertyValueConnectionIndex < $nPropertyValueConnectionCount; $nPropertyValueConnectionIndex++)
                    {
                        $propertyValueConnection = $aPropertyValueConnections[$nPropertyValueConnectionIndex];

                        $propertyValue[] = $propertyValueConnection->getChildEntityTypeName().'.'.$propertyValueConnection->getChildId();
                    }
                    break;
            }

            // 1. store field var
            $formFieldValues->fields[] = (object) array(
                'fieldSelector' => $sFieldSelector,
                'key' => $sEntitySelector.'.'.$sPropertyName,
                'propertyName' => $sPropertyName,
                'value' => $propertyValue
            );
        }

        // send
        return $formFieldValues;
    }


    // #todo - get form based on connected entity (= parent.forms)

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


    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Load project forms
     */
    private function loadProjectFormConfigs()
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
            "SELECT * FROM `".CoreConfig::MIMOTO_CONNECTIONS_CORE."` WHERE ".
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

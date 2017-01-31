<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;

use Mimoto\Core\forms\EntityPropertyForm_Value_type;
use Mimoto\Core\forms\EntityPropertyForm_Entity_allowedEntityType;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowedEntityTypes;
use Mimoto\Core\forms\EntityPropertyForm_Collection_allowDuplicates;

use Mimoto\Core\entities\Entity;
use Mimoto\Core\entities\EntityProperty;

use Mimoto\Core\entities\Component;

use Mimoto\Core\entities\Form;
use Mimoto\Core\entities\Input;

use Mimoto\Core\entities\InputTextline;
use Mimoto\Core\entities\InputTextBlock;
use Mimoto\Core\entities\InputTextRTF;
use Mimoto\Core\entities\InputRadioButton;
use Mimoto\Core\entities\InputCheckbox;

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

        $form = $aResults[0];

        // 3. validate if form exists
        if (empty($form))
        {
            $this->_MimotoLogService->warn('Unknown form requested', "I wasn't able to find the form with name <b>".$sFormName."</b> in the database");
            die();
        }
        
        // send
        return $form;
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
            $entity = $this->_EntityService->create($sEntityName);
        }
        else
        {
            if (!MimotoDataUtils::isValidEntityId($requestData->entityId))
            {
                Mimoto::service('log')->error('Invalid id on form submit', "The form with name <b>".$sFormName."</b> has an incorrect id `".$requestData->entityId."`");
                die();
            }

            // load
            $entity = $this->_EntityService->get($sEntityName, $requestData->entityId);
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
            if (isset($aValues->$sFieldKey)) $field->newValue = $aValues->$sFieldKey;
        }


        // 5. authenticate #todo
        $sPublicKey = $requestData->publicKey;
//        if ($sPublicKey !== Mimoto::service('user')->getUserPublicKey(json_encode($formVars->connectedEntities)))
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

            // validate
            if (!isset($field->newValue)) continue;


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
                    if (!empty($field->newValue)) // todo here!!!
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
                        $allowedEntityType = (object) array(
                            'id' => $nChildType,
                            'name' => Mimoto::service('config')->getEntityNameById($nChildType)
                        );

                        // create
                        $connection = MimotoDataUtils::createConnection($nChildId, $nParentEntityTypeId, $nParentPropertyId, $entity->getId(), [$allowedEntityType], $nChildType, $field->propertyName);

                        // register
                        $aNewConnections[] = $connection;
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
            if ($sPropertyType == MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY || $sPropertyType == MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION)
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
            $formResponse->newPublicKey = Mimoto::service('user')->getUserPublicKey(json_encode($formFieldValues));
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
            $sEntityName = $this->_MimotoEntityConfigService->getEntityNameByPropertyId($fieldValueId);
            $sPropertyName = $this->_MimotoEntityConfigService->getPropertyNameById($fieldValueId);
            $sPropertyType = $this->_MimotoEntityConfigService->getPropertyTypeById($fieldValueId);

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

    private function loadCoreForm($sFormName)
    {
        switch($sFormName)
        {
            case CoreConfig::COREFORM_ENTITY: return Entity::getForm(); break;

            case CoreConfig::COREFORM_ENTITYPROPERTY: return EntityProperty::getForm(); break;

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

            // input ---------

            case CoreConfig::COREFORM_INPUT_TEXTLINE: return InputTextline::getForm(); break;
            case CoreConfig::COREFORM_INPUT_TEXTBLOCK: return InputTextBlock::getForm(); break;
            case CoreConfig::COREFORM_INPUT_TEXTRTF: return InputTextRTF::getForm(); break;
            case CoreConfig::COREFORM_INPUT_RADIOBUTTON: return InputRadioButton::getForm(); break;
            case CoreConfig::COREFORM_INPUT_CHECKBOX: return InputCheckbox::getForm(); break;

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

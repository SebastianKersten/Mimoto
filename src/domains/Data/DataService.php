<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Selection\Selection;
use Mimoto\Selection\SelectionRuleTypes;


/**
 * DataService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DataService
{
    
    // config
    private $_aEntityConfigs = [];
    
    // components
    private $_entityRepository;
    
    // services
    private $_EntityConfigService;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param array $aEntityConfigs
     */
    public function __construct($aCustomEntityConfigs, $entityRepository, $entityConfigService)
    {
        
        // store
        $this->_entityRepository = $entityRepository;
        $this->_EntityConfigService = $entityConfigService;
        
        // register custom configs
        $nCustomEntityConfigCount = count($aCustomEntityConfigs);
        for ($i = 0; $i < $nCustomEntityConfigCount; $i++)
        {
            // register
            $entityConfig = $aCustomEntityConfigs[$i];
            
            // store
            $this->_aEntityConfigs[$entityConfig->getName()] = $entityConfig;
        }
        
        // load
        $aDatabaseEntityConfigs = $this->_EntityConfigService->getAllEntityConfigs();

        $nDatabaseEntityConfigCount = count($aDatabaseEntityConfigs);
        for ($i = 0; $i < $nDatabaseEntityConfigCount; $i++)
        {
            // register
            $entityConfig = $aDatabaseEntityConfigs[$i];
            
            // store if not overrules
            if (!isset($this->_aEntityConfigs[$entityConfig->getName()]))
            {
                $this->_aEntityConfigs[$entityConfig->getName()] = $entityConfig;
            }
        }
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Create entity
     * @param string $sEntityType
     * @return MimotoEntity The entity
     */
    public function create($sEntityType)
    {
        // verify
        if (!isset($this->_aEntityConfigs[$sEntityType]))
        {
            
            $entityConfig = $this->_EntityConfigService->getEntityConfigByName($sEntityType);
            
            if ($entityConfig !== false)
            {
                $this->_aEntityConfigs[$sEntityType] = $entityConfig;
            }
            else
            {
                throw new MimotoEntityException("( '-' ) - Sorry, I do not know the entity type '$sEntityType'");
            }
        }
        
        try
        {
            $entity = $this->_entityRepository->create($this->_aEntityConfigs[$sEntityType]);
        }
        catch(MimotoEntityException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $entity;
    }
    
    
    
    /**
     * Get entity by id
     * @param string $sEntityType
     * @param int $nId
     * @return MimotoEntity The entity
     */
    public function get($sEntityType, $nId)
    {
        // verify and convert
        if (MimotoDataUtils::isValidId($sEntityType)) $sEntityType = $this->_EntityConfigService->getEntityNameById($sEntityType);

        // verify
        if (!isset($this->_aEntityConfigs[$sEntityType]))
        {
            
            $entityConfig = $this->_EntityConfigService->getEntityConfigByName($sEntityType);

            if ($entityConfig !== false)
            {
                $this->_aEntityConfigs[$sEntityType] = $entityConfig;
            }
            else
            {
                throw new MimotoEntityException("( '-' ) - Sorry, I do not know the entity type '$sEntityType'");
            }
        }
        
        try
        {
            $entity = $this->_entityRepository->get($this->_aEntityConfigs[$sEntityType], $nId);
        }
        catch(MimotoEntityException $e)
        {
            return null;
        }
        
        // send
        return $entity;
    }

    /**
     * Get all entities
     */
    public function select($xSelection)
    {
        // init
        $aRequestedEntities = [];
        $selection = null;


        if (is_string($xSelection))
        {
            // load
            $selection = Mimoto::service('selection')->getSelection($xSelection);
        }
        else if ((is_array($xSelection) || is_object($xSelection)))
        {
            if ($xSelection instanceof Selection)
            {
                // register
                $selection = $xSelection;
            }
            else
            {
                // create
                $selection = new Selection($xSelection);
            }
        }

        // validate
        if ($selection instanceof Selection)
        {
            // register
            $aRules = $selection->getRules();

            // parse rules
            $nRuleCount = count($aRules);
            for ($nRuleIndex = 0; $nRuleIndex < $nRuleCount; $nRuleIndex++)
            {
                // register
                $rule = $aRules[$nRuleIndex];

                // read
                $sEntityType = $rule->getType();

                // validate
                if (empty($sEntityType)) continue;

                // load
                $entityConfig = $this->getEntityConfig($sEntityType);

                // load
                $aRequestedEntities = array_merge($aRequestedEntities, $this->_entityRepository->select($entityConfig, $rule));
            }

            // #todo remove duplicates


            // add core data
            if (!empty($aInstances = $selection->getData()))
            {
                $aRequestedEntities = array_merge($aRequestedEntities, $aInstances);
            }

        }


        //Mimoto::error($aRequestedEntities);

        // send
        return $aRequestedEntities;
    }
    
    /**
     * Get all entities
     */
    public function find($criteria)
    {
        // init
        $aRequestedEntities = [];


        if (isset($criteria[SelectionRuleTypes::TYPE]) && !isset($criteria[SelectionRuleTypes::CHILDOF]))
        {
            // read
            $sEntityType = $criteria[SelectionRuleTypes::TYPE];

            // verify and convert
            if (MimotoDataUtils::isValidId($sEntityType)) $sEntityType = $this->_EntityConfigService->getEntityNameById($sEntityType);

            // verify
            if (!isset($this->_aEntityConfigs[$sEntityType]))
            {

                $entityConfig = $this->_EntityConfigService->getEntityConfigByName($sEntityType);

                if ($entityConfig !== false)
                {
                    $this->_aEntityConfigs[$sEntityType] = $entityConfig;
                } else
                {
                    Mimoto::service('log')->warn("Requested entity type not found", "Sorry, I do not know the entity type $sEntityType'");
                }
            }

            // load
            $aRequestedEntities = $this->_entityRepository->find($this->_aEntityConfigs[$sEntityType], $criteria);
        }
        else
        if (isset($criteria[SelectionRuleTypes::CHILDOF]) && isset($criteria[SelectionRuleTypes::INSTANCE]))
        {
            // init
            $eParent = $criteria[SelectionRuleTypes::INSTANCE];

            // convert
            if (MimotoDataUtils::isValidId($criteria[SelectionRuleTypes::INSTANCE]) && isset($criteria[SelectionRuleTypes::TYPE]) && MimotoDataUtils::isValidEntityName($criteria[SelectionRuleTypes::TYPE]))
            {
                // load
                $eParent = Mimoto::service('data')->get($criteria[SelectionRuleTypes::TYPE], $criteria[SelectionRuleTypes::INSTANCE]);
            }

            // verify
            if (!empty($eParent) && $eParent instanceof MimotoEntity)
            {
                // init
                $sPropertyName = $criteria[SelectionRuleTypes::CHILDOF];

                if (MimotoDataUtils::isValidPropertyId($criteria[SelectionRuleTypes::CHILDOF]))
                {
                    // convert
                    $sPropertyName = Mimoto::service('entityConfig')->getPropertyNameById($criteria[SelectionRuleTypes::CHILDOF]);
                }

                // verify
                if ($eParent->hasProperty($sPropertyName))
                {
                    // toggle
                    switch($eParent->getPropertyType($sPropertyName))
                    {
                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                            // load
                            $eChild = $eParent->getValue($sPropertyName);

                            // store
                            if (!empty($eChild)) $aRequestedEntities[] = $eChild;
                            break;

                        case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                            // load
                            $eChildren = $eParent->getValue($sPropertyName);

                            // store
                            if (!empty($eChildren)) $aRequestedEntities = array_merge($aRequestedEntities, $eChildren);
                            break;
                    }
                }
            }
        }
        
        // send
        return $aRequestedEntities;
    }
    
    /**
     * Store entity via main repository
     * @param MimotoEntity $entity
     */
    public function store(MimotoEntity $entity)
    {
        // verify
        if (!isset($this->_aEntityConfigs[$entity->getEntityTypeName()]))
        {
            
            $entityConfig = $this->_EntityConfigService->getEntityConfigByName($entity->getEntityTypeName());
            
            if ($entityConfig !== false)
            {
                $this->_aEntityConfigs[$entity->getEntityTypeName()] = $entityConfig;
            }
            else
            {
                throw new MimotoEntityException("( '-' ) - Sorry, I do not know the entity type '".$entity->getEntityTypeName()."'");
            }
        }
        else
        {
            $entityConfig = $this->_aEntityConfigs[$entity->getEntityTypeName()];
        }

        return $this->_entityRepository->store($entityConfig, $entity);
    }

    /**
     * Delete entity via main repository
     * @param MimotoEntity $entity
     */
    public function delete(MimotoEntity $entity = null, $nConnectionId = null, $bForceDelete = false)
    {
        // validate
        if (empty($entity)) return false;

        // verify
        if (!isset($this->_aEntityConfigs[$entity->getEntityTypeName()]))
        {

            $entityConfig = Mimoto::service('entityConfig')->getEntityConfigByName($entity->getEntityTypeName());

            if ($entityConfig !== false)
            {
                $this->_aEntityConfigs[$entity->getEntityTypeName()] = $entityConfig;
            }
            else
            {
                throw new MimotoEntityException("( '-' ) - Sorry, I do not know the entity type '".$entity->getEntityTypeName()."'");
            }
        }
        else
        {
            $entityConfig = $this->_aEntityConfigs[$entity->getEntityTypeName()];
        }

        return $this->_entityRepository->delete($entityConfig, $entity, $nConnectionId, $bForceDelete);
    }

    /**
     * Create entity
     * @param string $sEntityType
     * @param array $aParentEntitySelectionConfigs Contains object with 'type', 'id' and 'property'
     * @return object Object containing the entity and the connection
     */
    public function createAndConnect($sEntityType, $aParentEntitySelectionConfigs)
    {
        // 1. init
        $result = (object) array(
            'entity' => Mimoto::service('data')->create($sEntityType),
            'connection' => null
        );

        // 2. store
        Mimoto::service('data')->store($result->entity);

        // 3. connect to parents
        $nParentCount = count($aParentEntitySelectionConfigs);
        for ($nParentIndex = 0; $nParentIndex < $nParentCount; $nParentIndex++)
        {
            // a. register
            $parent = $aParentEntitySelectionConfigs[$nParentIndex];

            // b. load
            $eParent = Mimoto::service('data')->get($parent->type, $parent->id);

            // d. verify
            if (!empty($eParent))
            {
                // I. connect
                switch($eParent->getPropertyType($parent->property))
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // set
                        $eParent->setValue($parent->property, $result->entity);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // add
                        $eParent->addValue($parent->property, $result->entity);
                        break;
                }

                // II. store
                Mimoto::service('data')->store($eParent);

                // III. register
                if (count($aParentEntitySelectionConfigs) === 1)
                {
                    // read
                    $aAllChildren = $eParent->getValue($parent->property, true);

                    // register
                    $result->connection = $aAllChildren[count($aAllChildren) - 1];
                }
            }
        }

        // 4. send
        return $result;
    }



    /**
     * Get entity config by name
     * @param $sEntityType mixed
     * @return mixed
     */
    public function getEntityConfig($xEntityType) // #todo - move to config
    {
        //Mimoto::error($xEntityType);

        // verify and convert
        $sEntityType = (MimotoDataUtils::isValidId($xEntityType)) ? $this->_EntityConfigService->getEntityNameById($xEntityType) : $xEntityType;

        // verify
        if (!isset($this->_aEntityConfigs[$sEntityType]))
        {

            $entityConfig = $this->_EntityConfigService->getEntityConfigByName($sEntityType);

            if ($entityConfig !== false)
            {
                $this->_aEntityConfigs[$sEntityType] = $entityConfig;
            } else
            {
                Mimoto::service('log')->error("Requested entity type not found in selection rule", "Sorry, I do not know the entity type '$sEntityType' from a rule in the selection", true);
            }
        }

        // send
        return $this->_aEntityConfigs[$sEntityType];
    }

    /**
     * Get dataset by label
     * @param $sDatasetLabel
     * @return null
     */
    public function getDataset($sDatasetLabel)
    {
        // 1. load
        $aDatasets = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_DATASET, 'values' => ['name' => $sDatasetLabel]]);

        // 2. verify and send
        return (count($aDatasets) == 1) ? $aDatasets[0] : null;
    }

    /**
     * Get dataset item by field value
     * @param $sDatasetLabel
     * @param $sFieldName
     * @param $xValue
     * @return null
     */
    public function getDatasetItem($sDatasetLabel, $sFieldName, $xValue)
    {
        // 1. load
        $aDatasets = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_DATASET, 'values' => ['name' => $sDatasetLabel]]);

        // verify
        if (count($aDatasets) == 1)
        {
            // register
            $eDatatset = $aDatasets[0];
            $aDatasetItems = $eDatatset->get('data');

            // search correct block
            $nDatasetItemCount = count($aDatasetItems);
            for ($nDatasetItemIndex = 0; $nDatasetItemIndex < $nDatasetItemCount; $nDatasetItemIndex++)
            {
                // register
                $eDatasetItem = $aDatasetItems[$nDatasetItemIndex];

                // verify
                if ($eDatasetItem->get($sFieldName) == $xValue) return $eDatasetItem;
            }
        }

        // send
        return null;
    }

}

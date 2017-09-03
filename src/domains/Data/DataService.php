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

            // 2. remove duplicates
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
                    $sPropertyName = Mimoto::service('config')->getPropertyNameById($criteria[SelectionRuleTypes::CHILDOF]);
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
    public function delete(MimotoEntity $entity, $nConnectionId = null)
    {
        // verify
        if (!isset($this->_aEntityConfigs[$entity->getEntityTypeName()]))
        {

            $entityConfig = Mimoto::service('config')->getEntityConfigByName($entity->getEntityTypeName());

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

        return $this->_entityRepository->delete($entityConfig, $entity, $nConnectionId);
    }

    /**
     * Create entity
     * @param string $sEntityType
     * @param array $aParentEntitySelectionConfigs Contains object with 'type', 'id' and 'property'
     * @return MimotoEntity The entity
     */
    public function createAndConnect($sEntityType, $aParentEntitySelectionConfigs)
    {
        // 1. create
        $eEntity = Mimoto::service('data')->create($sEntityType);

        // 2. store
        Mimoto::service('data')->store($eEntity);

        // 3. connect to parents
        $nParentCount = count($aParentEntitySelectionConfigs);
        for ($nParentIndex = 0; $nParentIndex < $nParentCount; $nParentIndex++)
        {
            // a. register
            $parent = $aParentEntitySelectionConfigs[$nParentIndex];

            // b. load
            $eParent = Mimoto::service('data')->get($parent->type, $parent->id);

            // c. verify
            if (!empty($eParent))
            {
                switch($eParent->getPropertyType($parent->property))
                {
                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_ENTITY:

                        // I. add
                        $eParent->setValue($parent->property, $eEntity);
                        break;

                    case MimotoEntityPropertyTypes::PROPERTY_TYPE_COLLECTION:

                        // I. add
                        $eParent->addValue($parent->property, $eEntity);
                        break;
                }

                // II. store
                Mimoto::service('data')->store($eParent);
            }
        }

        // 4. send
        return $eEntity;
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

}

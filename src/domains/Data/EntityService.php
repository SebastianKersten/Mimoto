<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\EntityConfig\MimotoEntityPropertyTypes;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Selection\SelectionRuleTypes;


/**
 * EntityService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EntityService
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
    public function find($criteria)
    {
        // init
        $aRequestedEntities = [];


        if (isset($criteria[SelectionRuleTypes::TYPE]) && !isset($criteria[SelectionRuleTypes::CHILDOF]))
        {
            // read
            $sEntityType = $criteria[SelectionRuleTypes::TYPE];

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
            if (MimotoDataUtils::isValidEntityId($criteria[SelectionRuleTypes::INSTANCE]) && isset($criteria[SelectionRuleTypes::TYPE]) && MimotoDataUtils::isValidEntityName($criteria[SelectionRuleTypes::TYPE]))
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

    public function select($sSelectionName)
    {
        // init
        $aRequestedEntities = [];

        // load
        $selection = Mimoto::service('selection')->getSelectionByName($sSelectionName);

        // validate
        if (empty($selection)) return $aRequestedEntities;


        // search
        $nRuleCount = count($selection->rules);
        for ($nRuleIndex = 0; $nRuleIndex < $nRuleCount; $nRuleIndex++)
        {
            // register
            $rule = $selection->rules[$nRuleIndex];

            // compose
            $criteria = array(
                SelectionRuleTypes::TYPE => Mimoto::service('config')->getEntityNameById($rule->entity_type_id),
                SelectionRuleTypes::INSTANCE => $rule->instance_id,
                SelectionRuleTypes::CHILDOF => $rule->property_id,
            );

            // load and register
            $aRequestedEntities = array_merge(Mimoto::service('data')->find($criteria), $aRequestedEntities);
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
    public function delete(MimotoEntity $entity)
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

        return $this->_entityRepository->delete($entityConfig, $entity);
    }
    
}

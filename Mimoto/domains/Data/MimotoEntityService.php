<?php

// classpath
namespace Mimoto\Data;

// Mimoto classes
use Mimoto\Data\MimotoEntityException;


/**
 * MimotoEntityService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityService
{
    
    // config
    var $_aEntityConfigs = [];
    
    // components
    var $_entityRepository;
    
    // services
    var $_EntityConfigService;
    
    
    
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
        for ($i = 0; $i < count($aCustomEntityConfigs); $i++)
        {
            // register
            $entityConfig = $aCustomEntityConfigs[$i];
            
            // store
            $this->_aEntityConfigs[$entityConfig->getName()] = $entityConfig;
        }
        
        // load
        $aDatabaseEntityConfigs = $this->_EntityConfigService->getAllEntityConfigs();
        
        for ($i = 0; $i < count($aDatabaseEntityConfigs); $i++)
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
            return false;
        }
        
        // send
        return $entity;
    }
    
    
    /**
     * Get all entities
     */
    public function find($criteria)
    {
        // read
        $sEntityType = $criteria['type'];

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
        
        // load
        $aEntities = $this->_entityRepository->find($this->_aEntityConfigs[$sEntityType], $criteria);
        
        // send
        return $aEntities;
    }
    
    
    /**
     * Store entity via main repository
     * @param MimotoEntity $entity
     */
    public function store(MimotoEntity $entity)
    {
        // verify
        if (!isset($this->_aEntityConfigs[$entity->getEntityType()]))
        {
            
            $entityConfig = $this->_EntityConfigService->getEntityConfigByName($entity->getEntityType());
            
            if ($entityConfig !== false)
            {
                $this->_aEntityConfigs[$entity->getEntityType()] = $entityConfig;
            }
            else
            {
                throw new MimotoEntityException("( '-' ) - Sorry, I do not know the entity type '".$entity->getEntityType()."'");
            }
        }
        else
        {
            $entityConfig = $this->_aEntityConfigs[$entity->getEntityType()];
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
        if (!isset($this->_aEntityConfigs[$entity->getEntityType()]))
        {

            $entityConfig = $this->_EntityConfigService->getEntityConfigByName($entity->getEntityType());

            if ($entityConfig !== false)
            {
                $this->_aEntityConfigs[$entity->getEntityType()] = $entityConfig;
            }
            else
            {
                throw new MimotoEntityException("( '-' ) - Sorry, I do not know the entity type '".$entity->getEntityType()."'");
            }
        }
        else
        {
            $entityConfig = $this->_aEntityConfigs[$entity->getEntityType()];
        }

        return $this->_entityRepository->delete($entityConfig, $entity);
    }
    
}

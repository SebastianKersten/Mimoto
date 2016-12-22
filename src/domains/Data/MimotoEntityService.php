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

        if (isset($criteria['type']))
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
                } else
                {
                    $GLOBALS['Mimoto.Log']->warning("Requested entity type not found", "Sorry, I do not know the entity type $sEntityType'");
                }
            }

            // load
            $aEntities = $this->_entityRepository->find($this->_aEntityConfigs[$sEntityType], $criteria);
        }
        
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

        return $this->_entityRepository->delete($entityConfig, $entity);
    }
    
}

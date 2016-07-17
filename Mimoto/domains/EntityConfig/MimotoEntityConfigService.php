<?php

// classpath
namespace Mimoto\EntityConfig;

// Mimoto classes
use Mimoto\Data\MimotoEntityConfigException;


/**
 * MimotoEntityConfigService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityConfigService
{
    
    // config
    var $_aEntityConfigs = [];
    
    // components
    var $_entityConfigRepository;
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param object $entityConfigRepository
     */
    public function __construct($entityConfigRepository)
    {
        // store
        $this->_entityConfigRepository = $entityConfigRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get entity by id
     * @param int $nId
     * @return MimotoEntityConfig The requested entity config
     */
    public function getEntityConfigById($nId)
    {
        try
        {
            $entityConfig = $this->_entityConfigRepository->get($nId);
        }
        catch(MimotoEntityException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $entityConfig;
    }
    
    public function getAllEntityConfigData()
    {
        return $this->_entityConfigRepository->getAllEntityConfigData();
    }
    
    
    
    /**
     * Get entity config by name
     */
    public function getEntityConfigByName($sEntityConfigName)
    {
        return $this->_entityConfigRepository->getEntityConfigByName($sEntityConfigName);
    }
    
    
    /**
     * Get all entities
     */
    public function getAllEntityConfigs($criteria = null)
    {
        
        return $this->_entityConfigRepository->getAllEntityConfigs();
        
        
//        // verify
//        if (!isset($this->_aEntityConfigs[$sEntityType])) { throw new MimotoEntityException("( '-' ) - Sorry, I do not know the entity type '$sEntityType'"); }
//        
//        // load
//        $aEntities = $this->_entityRepository->find($this->_aEntityConfigs[$sEntityType], $criteria);
//        
//        // send
//        return $aEntities;
    }
    
    public function getEntityNameById($nId)
    {
        return $this->_entityConfigRepository->getEntityNameById($nId);
    }
    
    public function getEntityIdByName($sName)
    {
        return $this->_entityConfigRepository->getEntityIdByName($sName);
    }
    
    
    // 1. add node
    // 2. remove node
    // 3. store
    // 4. load all configs
    
    
    /**
     * Store entity via main repository
     * @param MimotoEntity $entoty
     */
//    public function storeEntity(array met vars)
//    {
//        $this->_mainRepository->store($entity);
//        
//        // load or create
//        $client = (!is_nan($nId) && $nId > 0) ? $this->getMainRepository()->get($nId) : $this->getMainRepository()->create();
//        
//        // register
//        $client->setName($sName);
//        
//        // store
//        $this->getMainRepository()->store($client); // #todo - returns new client?
//    }
    
}

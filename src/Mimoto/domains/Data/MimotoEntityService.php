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
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param array $aEntityConfigs
     */
    public function __construct($aEntityConfigs, $entityRepository)
    {
        // store
        $this->_entityRepository = $entityRepository;
        
        for ($i = 0; $i < count($aEntityConfigs); $i++)
        {
            // register
            $entityConfig = $aEntityConfigs[$i];
            
            // store
            $this->_aEntityConfigs[$entityConfig->getName()] = $entityConfig;
        }
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get entity by id
     * @param int $nId
     * @return MimotoEntity The entity
     */
    public function getEntityById($sEntityType, $nId)
    {
        // verify
        if (!isset($this->_aEntityConfigs[$sEntityType])) { throw new MimotoEntityException("( '-' ) - Sorry, I do not know the entity type '$sEntityType'"); }
        
        try
        {
            $entity = $this->_entityRepository->get($this->_aEntityConfigs[$sEntityType], $nId);
        }
        catch(MimotoEntityException $e)
        {
            die($e->getMessage());
        }
        
        // send
        return $entity;
    }
    
    /**
     * Get all entities
     */
    public function getAllEntities($sEntityType, $criteria = null)
    {
        // verify
        if (!isset($this->_aEntityConfigs[$sEntityType])) { throw new MimotoEntityException("( '-' ) - Sorry, I do not know the entity type '$sEntityType'"); }
        
        // load
        $aEntities = $this->_entityRepository->find($this->_aEntityConfigs[$sEntityType], $criteria);
        
        // send
        return $aEntities;
    }
    
    
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

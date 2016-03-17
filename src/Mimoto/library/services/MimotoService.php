<?php

// classpath
namespace Mimoto\library\services;

// Mimoto classes
use Mimoto\library\entities\MimotoEntity;
use Mimoto\library\repositories\MimotoRepository;


/**
 * MimotoService
 *
 * @author Sebastian Kersten
 */
class MimotoService
{
    
    // repositories
    private $_mainRepository;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Set main repository
     * @param MimotoRepository $repository
     */
    public function setMainRepository(MimotoRepository $repository)
    {
        // store
        $this->_mainRepository = $repository;
    }
    
    /**
     * Get main repository
     * @return MimotoRepository
     */
    public function getMainRepository()
    {
        return $this->_mainRepository;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Get entity by id from main repository
     * @param int $nId
     * @return MimotoEntity The entity
     */
    public function getEntityById($nId)
    {
        return $this->_mainRepository->get($nId);
    }
    
    /**
     * Store entity via main repository
     * @param MimotoEntity $entoty
     */
    public function storeEntity(MimotoEntity $entity)
    {
        $this->_mainRepository->store($entity);
    }
    
}
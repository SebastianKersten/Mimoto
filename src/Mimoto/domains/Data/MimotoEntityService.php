<?php

// classpath
namespace Mimoto\Data;


/**
 * MimotoEntityService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityService
{
    
    // config
    var $_aEntityConfigs;
    
    // components
    var $_entityRepository;
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     * @param array $aEntityConfigs
     */
    public function __construct($aEntityConfigs)
    {
        // store
        $this->_aEntityConfigs = $aEntityConfigs;
        
        // init
        $this->_entityRepository = [];
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    // 1. authenticate users
    // 2. show which user on which part
    // 3. live diff updates client2client
    // 4. mls_input
    // 5. Aimless.registerInput()
    // 6. focus input when other user active
    
    
    /**
     * Get entity by id
     * @param int $nId
     * @return MimotoEntity The entity
     */
    public function getEntityById($sEntityType, $nId)
    {
        // 1. er is maar 1 repository
        // 2. check if repository exists? er servcie exists, or entity
        // 3. gooi config in repository en maak entities
        
        //return $this->_entityRepository->get($nId);
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

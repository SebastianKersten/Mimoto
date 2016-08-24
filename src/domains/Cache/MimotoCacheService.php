<?php

// classpath
namespace Mimoto\Cache;


/**
 * MimotoCacheService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoCacheService
{
    
    // services
    private $_memcache;
    
    
    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($memcache)
    {
        // register
        $this->_memcache = $memcache;
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    public function getValue($sKey)
    {
        return $this->_memcache->get($sKey);
    }
    
    public function setValue($sKey, $value, $flag = false, $expire = 0)
    {
        return $this->_memcache->set($sKey, $value, $flag, $expire);
    }
    
}

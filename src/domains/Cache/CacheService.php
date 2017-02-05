<?php

// classpath
namespace Mimoto\Cache;


/**
 * CacheService
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CacheService
{

    // services
    private $_memcache;

    // settings
    private $_bCacheEnabled;


    // ----------------------------------------------------------------------------
    // --- Properties -------------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function isEnabled()
    {
        return $this->_bCacheEnabled;
    }

    
    // ----------------------------------------------------------------------------
    // --- Constructor ------------------------------------------------------------
    // ----------------------------------------------------------------------------
    
    
    /**
     * Constructor
     */
    public function __construct($memcache, $bEnableCache = false)
    {
        // register
        $this->_memcache = $memcache;

        // init
        $this->_bCacheEnabled = $bEnableCache;

        // flush all
        if (!$this->_bCacheEnabled) $this->_memcache->flush();
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

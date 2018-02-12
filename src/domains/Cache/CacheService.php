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
    private $_memcached;

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
    public function __construct($memcached, $bEnableCache = false)
    {
        // register
        $this->_memcached = $memcached;

        // init
        $this->_bCacheEnabled = $bEnableCache;

        // flush all
        if (!$this->_bCacheEnabled && !empty($this->_memcached)) $this->_memcached->flush();
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function hasValue($sKey)
    {
        return ($this->_memcached->get($sKey) !== false);
    }

    public function getValue($sKey)
    {
        return $this->_memcached->get($sKey);
    }
    
    public function setValue($sKey, $value, $flag = false, $expire = 0)
    {
        return $this->_memcached->set($sKey, $value, $flag, $expire);
    }

    public function flush()
    {
        if ($this->_bCacheEnabled) $this->_memcached->flush();
    }

    public function delete($sKey)
    {
        if ($this->_bCacheEnabled) $this->_memcached->delete($sKey);
    }
}

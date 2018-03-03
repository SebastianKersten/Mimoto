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
    private $_sPrefix;


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
    public function __construct($memcached, $bEnableCache = false, $sPrefix = '')
    {
        // register
        $this->_memcached = $memcached;

        // init
        $this->_bCacheEnabled = $bEnableCache;
        $this->_sPrefix = $sPrefix.'-';

        // flush all
        if (!$this->_bCacheEnabled && !empty($this->_memcached)) $this->_memcached->flush();
    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function hasValue($sKey)
    {
        return ($this->_memcached->get($this->_sPrefix.$sKey) !== false);
    }

    public function getValue($sKey)
    {
        return $this->_memcached->get($this->_sPrefix.$sKey);
    }
    
    public function setValue($sKey, $value, $expire = 0)
    {
        return $this->_memcached->set($this->_sPrefix.$sKey, $value, $expire);
    }

    public function flush()
    {
        if ($this->_bCacheEnabled) $this->_memcached->flush();
    }

    public function delete($sKey)
    {
        if ($this->_bCacheEnabled) $this->_memcached->delete($this->_sPrefix.$sKey);
    }
}

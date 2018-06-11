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

    // session cache
    private $_sessionCache;


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
        $this->_sessionCache = [];

        // flush all
        if (!$this->_bCacheEnabled && !empty($this->_memcached)) $this->_memcached->flush();

    }
    
    
    
    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function hasValue($sKey)
    {
        if (isset($this->_sessionCache[$this->_sPrefix.$sKey]))
        {
            return true;
        }
        else
        {
            return ($this->_memcached->get($this->_sPrefix.$sKey) !== false);
        }
    }

    public function getValue($sKey)
    {
        if (isset($this->_sessionCache[$this->_sPrefix.$sKey]))
        {
            return $this->_sessionCache[$this->_sPrefix.$sKey];
        }
        else
        {
            $value = $this->_memcached->get($this->_sPrefix.$sKey);
            if ($value !== false) $this->_sessionCache[$this->_sPrefix.$sKey] = $value;
            return $value;
        }
    }
    
    public function setValue($sKey, $value, $expire = 0)
    {
        $this->_sessionCache[$this->_sPrefix.$sKey] = $value;
        return $this->_memcached->set($this->_sPrefix.$sKey, $value, $expire);
    }

    public function flush()
    {
        if ($this->_bCacheEnabled)
        {
            $this->_sessionCache = [];
            $this->_memcached->flush();
        }
    }

    public function delete($sKey)
    {
        unset($this->_sessionCache[$this->_sPrefix.$sKey]);
        if ($this->_bCacheEnabled) $this->_memcached->delete($this->_sPrefix.$sKey);
    }
}

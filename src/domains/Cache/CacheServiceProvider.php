<?php

// classpath
namespace Mimoto\Cache;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * CacheServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class CacheServiceProvider implements ServiceProviderInterface
{
    // configuration
    private $_memcachedConfig;


    public function __construct($memcachedConfig)
    {
        // 1. init
        if (empty($memcachedConfig)) $memcachedConfig = (object) array();

        // 2. setup
        $memcachedConfig->enabled = (isset($memcachedConfig->enabled)) ? $memcachedConfig->enabled : false;
        $memcachedConfig->keyPrefix = (isset($memcachedConfig->keyPrefix)) ? $memcachedConfig->keyPrefix : '';
        $memcachedConfig->address = (isset($memcachedConfig->address)) ? $memcachedConfig->address : '127.0.0.1';
        $memcachedConfig->port = (isset($memcachedConfig->port)) ? $memcachedConfig->port : 11211;

        // 3. store
        $this->_memcachedConfig = $memcachedConfig;
    }


    public function register(Application $app)
    {
        $app['Mimoto.Cache'] = $app->share(function($app)
        {
            $memcache = null;

            if ($this->_memcachedConfig->enabled)
            {
                // init
                $memcache = new \Memcached;

                // connect
                $memcache->addServer($this->_memcachedConfig->address, $this->_memcachedConfig->port);

                // if ($bResult) #todo - only start on success
            }

            return new CacheService($memcache, $this->_memcachedConfig->enabled, $this->_memcachedConfig->keyPrefix);
        });
        
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('cache', $app['Mimoto.Cache']);
    }
    
}

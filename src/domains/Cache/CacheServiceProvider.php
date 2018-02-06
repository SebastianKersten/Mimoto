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
    private $_bEnableCache;


    public function __construct($bEnableCache = false)
    {
        // register
        $this->_bEnableCache = $bEnableCache;
    }


    public function register(Application $app)
    {
        $app['Mimoto.Cache'] = $app->share(function($app)
        {
            $memcache = null;

            if ($this->_bEnableCache)
            {
                // init
                $memcache = new \Memcache;

                // connect
                $memcache->addServer('localhost', 11211);

                // if ($bResult) #todo - only start on success
            }

            return new CacheService($memcache, $this->_bEnableCache);
        });
        
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('cache', $app['Mimoto.Cache']);
    }
    
}

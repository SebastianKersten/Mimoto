<?php

// classpath
namespace Mimoto\Cache;

// Mimoto classes
use Mimoto\Cache\MimotoCacheService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoCacheServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoCacheServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Cache'] = $app->share(function($app)
        {
            // init
            $memcache = new \Memcache;
            
            // connect
            $memcache->connect('localhost', 11211);
            
            // if ($bResult) #todo - only start on success
            
            return new MimotoCacheService($memcache);
        });
        
    }

    public function boot(Application $app) {}
    
}

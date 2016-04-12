<?php

// classpath
namespace Mimoto\Config;

// Mimoto classes
use Mimoto\Data\MimotoEntityConfigService;
use Mimoto\Data\MimotoEntityConfigRepository;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoEntityConfigServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEntityConfigServiceProvider implements ServiceProviderInterface
{
    
    /**
     * Register service to app
     * @param Application $app
     */
    public function register(Application $app)
    {
        // register
        $app['Mimoto.EntityConfigService'] = $app->share(function($app) {
            
            // init
            $service = new MimotoEntityConfigService(new MimotoEntityConfigRepository());
            
            // send
            return $service;
        });
    }
    
    /**
     * Boot service
     * @param Application $app
     */
    public function boot(Application $app) {}
    
}

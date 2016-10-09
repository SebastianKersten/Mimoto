<?php

// classpath
namespace Mimoto\Log;

// Mimoto classes
use Mimoto\Log\MimotoLogService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoFormServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoLogServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Log'] = $app['Mimoto.LogService'] = $app->share(function($app)
        {
            return new MimotoLogService($app['Mimoto.Data']);
        });
    }

    public function boot(Application $app)
    {
        // register
        $GLOBALS['Mimoto.Log'] = $app['Mimoto.Log'];
    }
    
}

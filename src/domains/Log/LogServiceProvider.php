<?php

// classpath
namespace Mimoto\Log;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * LogServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class LogServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.LogService'] = $app->share(function($app)
        {
            return new LogService();
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('log', $app['Mimoto.LogService']);
    }
    
}

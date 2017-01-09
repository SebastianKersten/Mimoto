<?php

// classpath
namespace Mimoto\Log;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Log\MimotoLogService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * LogServiceProvider
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
        Mimoto::setService('log', $app['Mimoto.Log']);
    }
    
}

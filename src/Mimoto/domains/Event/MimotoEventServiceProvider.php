<?php

// classpath
namespace Mimoto\Event;

// Mimoto classes
use Mimoto\Event\MimotoEventService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoEventServiceProvider
 *
 * @author Sebastian Kersten
 */
class MimotoEventServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['EventService'] = $app->share(function ($app) {
            return new MimotoEventService($app['dispatcher'], $app['LiveScreenService']);
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

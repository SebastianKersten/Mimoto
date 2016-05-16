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
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoEventServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['Mimoto.EventService'] = $app->share(function ($app) {
            return new MimotoEventService($app['dispatcher'], $app['Mimoto.AimlessService']);
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

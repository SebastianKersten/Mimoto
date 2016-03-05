<?php

// classpath
namespace Momkai\Event;

// Momkai classes
use Momkai\Event\EventService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * EventServiceProvider
 *
 * @author Sebastian Kersten
 */
class EventServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['EventService'] = $app->share(function ($app) {
            return new EventService($app['dispatcher']);
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

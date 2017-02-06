<?php

// classpath
namespace Mimoto\Event;

// Mimoto classes
use Mimoto\Event\EventService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * EventServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class EventServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['Mimoto.EventService'] = $app->share(function ($app)
        {
            $service = new EventService($app['dispatcher']);
            
            return $service;
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

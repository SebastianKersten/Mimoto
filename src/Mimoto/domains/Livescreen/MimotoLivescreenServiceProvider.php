<?php

// classpath
namespace library\Livescreen;

// Momkai classes
use library\Livescreen\LivescreenService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * LivescreenServiceProvider
 *
 * @author Sebastian Kersten
 */
class LivescreenServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['LivescreenService'] = $app->share(function ($app) {
            return new LivescreenService();
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

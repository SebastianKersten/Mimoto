<?php

// classpath
namespace Mimoto\Route;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * RouteServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class RouteServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Route'] = $app['Mimoto.RouteService'] = $app->share(function($app)
        {
            return new RouteService($app['Mimoto.Page'], $app['Mimoto.API']);
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('route', $app['Mimoto.Route']);
    }
    
}

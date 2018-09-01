<?php

// classpath
namespace Mimoto\API;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * APIServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class APIServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.API'] = $app['Mimoto.APIService'] = $app->share(function($app)
        {
            return new APIService();
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('api', $app['Mimoto.API']);
    }
    
}

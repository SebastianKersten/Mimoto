<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * OutputServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class OutputServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Output'] = $app['Mimoto.OutputService'] = $app->share(function($app)
        {
            return new OutputService($app['Mimoto.Data'], $app['Mimoto.Forms'], Mimoto::service('log'), Mimoto::service('twig'));
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('output', $app['Mimoto.Output']);
    }
    
}

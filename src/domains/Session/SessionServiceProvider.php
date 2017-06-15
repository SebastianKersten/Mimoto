<?php

// classpath
namespace Mimoto\Session;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * SessionServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SessionServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Session'] = $app['Mimoto.SessionService'] = $app->share(function($app)
        {
            return new SessionService($app);
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('session', $app['Mimoto.Session']);
    }
    
}

<?php

// classpath
namespace Mimoto\User;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * UserServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class UserServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.User'] = $app['Mimoto.UserService'] = $app->share(function($app)
        {
            return new UserService();
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('users', $app['Mimoto.User']);
    }
    
}

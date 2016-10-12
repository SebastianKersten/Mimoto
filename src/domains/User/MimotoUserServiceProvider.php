<?php

// classpath
namespace Mimoto\User;

// Mimoto classes
use Mimoto\Log\MimotoLogService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoUserServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoUserServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.User'] = $app['Mimoto.UserService'] = $app->share(function($app)
        {
            return new MimotoUserService();
        });
    }

    public function boot(Application $app)
    {
        // register
        $GLOBALS['Mimoto.User'] = $app['Mimoto.User'];
    }
    
}

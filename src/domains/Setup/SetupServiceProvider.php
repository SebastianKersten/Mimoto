<?php

// classpath
namespace Mimoto\Setup;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * SetupServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SetupServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Setup'] = $app['Mimoto.SetupService'] = $app->share(function($app)
        {
            return new SetupService($app);
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('setup', $app['Mimoto.Setup']);
    }
    
}

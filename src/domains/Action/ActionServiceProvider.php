<?php

// classpath
namespace Mimoto\Action;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * ActionServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class ActionServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.ActionService'] = $app->share(function($app)
        {
            return new ActionService();
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('actions', $app['Mimoto.ActionService']);
    }
    
}

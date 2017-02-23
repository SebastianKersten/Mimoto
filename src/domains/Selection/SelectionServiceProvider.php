<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * SelectionServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SelectionServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Selection'] = $app['Mimoto.SelectionService'] = $app->share(function($app)
        {
            return new SelectionService();
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('selection', $app['Mimoto.Selection']);
    }
    
}

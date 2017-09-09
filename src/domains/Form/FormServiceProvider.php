<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * FormServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class FormServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        $app['Mimoto.Forms'] = $app['Mimoto.FormService'] = $app->share(function($app)
        {
            return new FormService();
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('input', $app['Mimoto.Forms']);
    }
    
}

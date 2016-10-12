<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Form\MimotoFormService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoFormServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoFormServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        // register
        $app->post('/Mimoto.Aimless/form/{sFormName}', 'Mimoto\\Aimless\\MimotoAimlessController::parseForm');
        $app->get('/Mimoto.Aimless/form/{sFormName}', 'Mimoto\\Aimless\\MimotoAimlessController::parseForm'); // #todo - dev only

        $app['Mimoto.Forms'] = $app['Mimoto.FormService'] = $app->share(function($app)
        {
            return new MimotoFormService($app['Mimoto.Data'], $app['Mimoto.Config']);
        });
    }

    public function boot(Application $app)
    {
        // register
        $GLOBALS['Mimoto.Forms'] = $app['Mimoto.Forms'];
    }
    
}

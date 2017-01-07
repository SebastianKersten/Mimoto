<?php

// classpath
namespace Mimoto\Form;

// Mimoto classes
use Mimoto\Mimoto;
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
        $app->post('/Mimoto.Aimless/validate/{nValidationId}', 'Mimoto\\Aimless\\MimotoAimlessController::validateFormField');

        $app['Mimoto.Forms'] = $app['Mimoto.FormService'] = $app->share(function($app)
        {
            return new MimotoFormService($app['Mimoto.Data'], $app['Mimoto.Config'], $app['Mimoto.Log']);
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('forms', $app['Mimoto.Forms']);
    }
    
}

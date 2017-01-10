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
        // register
        $app->post('/Mimoto.Aimless/form/{sFormName}', 'Mimoto\\Aimless\\MimotoAimlessController::parseForm');
        $app->post('/Mimoto.Aimless/validate/{nValidationId}', 'Mimoto\\Aimless\\MimotoAimlessController::validateFormField');

        $app['Mimoto.Forms'] = $app['Mimoto.FormService'] = $app->share(function($app)
        {
            return new FormService($app['Mimoto.Data'], $app['Mimoto.Config'], $app['Mimoto.Log']);
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('forms', $app['Mimoto.Forms']);
    }
    
}
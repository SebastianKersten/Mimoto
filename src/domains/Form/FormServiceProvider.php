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
        $app->post('/Mimoto.Aimless/upload/image', 'Mimoto\\Aimless\\MimotoAimlessController::uploadImage');

        $app['Mimoto.Forms'] = $app['Mimoto.FormService'] = $app->share(function($app)
        {
            return new FormService();
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('forms', $app['Mimoto.Forms']);
    }
    
}

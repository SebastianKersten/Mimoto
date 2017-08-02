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
        $app->post('/Mimoto.Aimless/form/{sFormName}', 'Mimoto\\api\\OutputController::parseForm');
        $app->post('/Mimoto.Aimless/validate/{nValidationId}', 'Mimoto\\api\\OutputController::validateFormField');
        $app->post('/Mimoto.Aimless/upload/image', 'Mimoto\\api\\OutputController::uploadImage');
        $app->post('/Mimoto.Aimless/upload/video', 'Mimoto\\api\\OutputController::uploadVideo');

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

<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Mimoto;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * AimlessServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class AimlessServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        // register
        $app->get('/Mimoto.Aimless/data/{sEntityType}/{nEntityId}/{sComponentId}', 'Mimoto\\Aimless\\MimotoAimlessController::renderEntityView');
        $app->get('/Mimoto.Aimless/wrapper/{sEntityType}/{nEntityId}/{sWrapperName}', 'Mimoto\\Aimless\\MimotoAimlessController::renderWrapperView');
        $app->get('/Mimoto.Aimless/wrapper/{sEntityType}/{nEntityId}/{sWrapperName}/{sComponentName}', 'Mimoto\\Aimless\\MimotoAimlessController::renderWrapperView');
        $app->post('/Mimoto.Aimless/realtime/collaboration', 'Mimoto\\Aimless\\MimotoAimlessController::authenticateUser');

        $app['Mimoto.Aimless'] = $app['Mimoto.AimlessService'] = $app->share(function($app)
        {
            return new AimlessService($app['Mimoto.Data'], $app['Mimoto.Forms'], Mimoto::service('log'), Mimoto::service('twig'));
        });
    }

    public function boot(Application $app)
    {
        // register
        Mimoto::setService('aimless', $app['Mimoto.Aimless']);
    }
    
}

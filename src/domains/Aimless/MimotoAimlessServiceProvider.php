<?php

// classpath
namespace Mimoto\Aimless;

// Mimoto classes
use Mimoto\Aimless\MimotoAimlessService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoAimlessServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class MimotoAimlessServiceProvider implements ServiceProviderInterface
{
    
    public function register(Application $app)
    {
        // register
        $app->get('/Mimoto.Aimless/data/{sEntityType}/{nEntityId}/{sTemplateId}', 'Mimoto\\Aimless\\MimotoAimlessController::renderEntityView');

        $app['Mimoto.Aimless'] = $app['Mimoto.AimlessService'] = $app->share(function($app)
        {
            return new MimotoAimlessService($app['Mimoto.Data'], $app['Mimoto.Forms'], $app['twig']);
        });
    }

    public function boot(Application $app)
    {
        // register
        $GLOBALS['Mimoto.Aimless'] = $app['Mimoto.Aimless'];
    }
    
}

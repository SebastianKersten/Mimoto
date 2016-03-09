<?php

// classpath
namespace Mimoto\Livescreen;

// Mimoto classes
use Mimoto\Livescreen\MimotoLivescreenService;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * MimotoLivescreenServiceProvider
 *
 * @author Sebastian Kersten
 */
class MimotoLivescreenServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {   
        // register
        $app->get('/livescreen/{sEntityType}/{nId}/{sTemplate}', 'Mimoto\\Livescreen\\MimotoLivescreenController::getView');
        
        $app['LivescreenService'] = $app->share(function ($app) {
            return new MimotoLivescreenService($app['Livescreen.entities']);
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

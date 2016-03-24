<?php

// classpath
namespace MaidoProjects\SubprojectState;

// Momkai classes
use MaidoProjects\SubprojectState\SubprojectStateService;
use MaidoProjects\SubprojectState\SubprojectStateRepository;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * SubprojectStateServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SubprojectStateServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['SubprojectStateService'] = $app->share(function ($app) {
            return new SubprojectStateService(new SubprojectStateRepository($app['EventService']));
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

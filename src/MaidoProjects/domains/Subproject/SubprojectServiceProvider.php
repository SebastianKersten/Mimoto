<?php

// classpath
namespace MaidoProjects\Subproject;

// Momkai classes
use MaidoProjects\Subproject\SubprojectService;
use MaidoProjects\Subproject\SubprojectRepository;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * SubprojectServiceProvider
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class SubprojectServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['SubprojectService'] = $app->share(function ($app) {
            return new SubprojectService(new SubprojectRepository($app['EventService']));
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

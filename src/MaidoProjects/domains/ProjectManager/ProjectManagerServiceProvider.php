<?php

// classpath
namespace MaidoProjects\ProjectManager;

// Momkai classes
use MaidoProjects\ProjectManager\ProjectManagerService;
use MaidoProjects\ProjectManager\ProjectManagerRepository;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * ProjectManagerServiceProvider
 *
 * @author Sebastian Kersten
 */
class ProjectManagerServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['ProjectManagerService'] = $app->share(function ($app) {
            return new ProjectManagerService(new ProjectManagerRepository($app['EventService']));
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

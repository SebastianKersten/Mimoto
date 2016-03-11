<?php

// classpath
namespace MaidoProjects\Project;

// Momkai classes
use MaidoProjects\Project\ProjectService;
use MaidoProjects\Project\ProjectRepository;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * ProjectServiceProvider
 *
 * @author Sebastian Kersten
 */
class ProjectServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        
        $app['ProjectService'] = $app->share(function ($app) {
            return new ProjectService(
                    new ProjectRepository(
                            $app['EventService'],
                            $app['SubprojectService'],
                            $app['ProjectManagerService'],
                            $app['ClientService'],
                            $app['AgencyService']
                        )
                );
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

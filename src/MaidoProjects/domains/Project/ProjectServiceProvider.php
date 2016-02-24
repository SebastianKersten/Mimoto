<?php

// classpath
namespace MaidoProjects\Project;

// Momkai classes
use MaidoProjects\Project\ProjectService;
use MaidoProjects\Project\ProjectRepository;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


class ProjectServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        
        $app['ProjectService'] = $app->share(function ($app) {
            return new ProjectService(
                    $app['SubprojectService'],
                    $app['ProjectManagerService'],
                    $app['ClientService'],
                    $app['AgencyService'],
                    new ProjectRepository(
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

<?php

// classpath
namespace MaidoProjects\Subproject;

// Momkai classes
use MaidoProjects\Subproject\SubprojectService;
use MaidoProjects\Subproject\SubprojectRepository;
use MaidoProjects\Subproject\SubprojectStateRepository;

// Silex classes
use Silex\Application;
use Silex\ServiceProviderInterface;


/**
 * SubprojectServiceProvider
 *
 * @author Sebastian Kersten
 */
class SubprojectServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['SubprojectService'] = $app->share(function ($app) {
            return new SubprojectService(new SubprojectRepository(), new SubprojectStateRepository());
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

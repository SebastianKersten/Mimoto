<?php

namespace MaidoProjects\ProjectManager;

use Silex\Application;
use Silex\ServiceProviderInterface;
use MaidoProjects\ProjectManager\ProjectManagerService;


class ProjectManagerServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['ProjectManagerService'] = $app->share(function ($app) {
            return new ProjectManagerService();
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}

<?php

namespace MaidoProjects\Subproject;

use Silex\Application;
use Silex\ServiceProviderInterface;
use MaidoProjects\Subproject\SubprojectService;


class SubprojectServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['SubprojectService'] = $app->share(function ($app) {
            return new SubprojectService();
        });
    }

    public function boot(Application $app)
    {
        // noop
    }
}
